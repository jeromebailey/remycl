<?php

namespace App\Http\Controllers;

use App\Imports\ClientsImport;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\SMSHelper;
use App\Models\Smstemplate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Policypayment;
use App\Models\ScheduledSms;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    //
    private string $baseUrl = 'https://api.mock.myappliedproducts.com';
    private string $bearerToken = 'eyJraWQiOiIyZTJiZjhiZi00NjA3LTQwMzItYWY4OS0xOGVkMjFhNGExYzEiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzY29wZSI6ImVwaWNcL2NsaWVudHM6YWxsIiwiaXNzIjoiaHR0cHM6XC9cL2FwaS5tb2NrLm15YXBwbGllZHByb2R1Y3RzLmNvbVwvIiwiZXhwIjoxNzU3MDQ3MTA2LCJpYXQiOjE3NTcwMzk5MDYsImp0aSI6Ijg4NWIzYTk3LWFiY2YtNDkxYS1hOGQ2LWRmYzEzODlmNmMyZCJ9.iCtG1xkcH1kofuThO8l50QXquYHWVFvC_NV6xRntyQLTztmy7-sM4F5kYMYMY38fOP0k8TG6RZU0OwkEVO7vn-WyRFdynfF6gQruiE37IoqVkCMVJcTEZYc5iztvjKzuQs_oG-1k4gNL3H35ryvZSJYoMjzwC3Q1-7B6qx5gZmdLyXcyxmAFt7UGwz9mM2kqbZ-FWANnqlU0eKNd2e3oaYNCK3qvqT2Yqq9VffbHpmY5pl5au8oLBvEd90qIQ__3sMVmHZ41aMsYyBpo_tmjFbw3kA_lVgAwvL6O_6H3eqrIXGT209XgZ_HlXQ3SmJl3JOAPaUUC6I_WpGsDZWxQ1A';


    public function index()
    {
        if (! Gate::allows('view-all-clients', Auth::user())) {
            abort(403);
        }

        $id = Auth::user()->id;
        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = ($slug == 'super-admin') ? 'admin' : $slug;

        switch($slug)
        {
            case 'super-admin':
                $allClients = Client::getAllClients();

                $breadcrumbs = array(
                    ['path' => $roleSlug . '/clients', 'crumb' => 'Clients'],
                    ['path' => $roleSlug . '/clients', 'crumb' => 'All Clients']
                );

                $data = array(
                    'viewTitle' => 'All Clients',
                    'clients' => $allClients,
                    'role_slug' => $roleSlug,
                    'breadcrumbs' => $breadcrumbs
                );
                return view('clients.list-clients', $data);
                break;

            case 'sales-exec':
                    $allClients = Client::getAllClientsByUserId($id);
    
                    $data = array(
                        'viewTitle' => 'My Clients',
                        'clients' => $allClients,
                        'role_slug' => $roleSlug
                    );
                    return view('clients.list-clients', $data);
                    break;
        }
    }
    
    public function showClientDetails($id){

        if(empty($id)){
            abort(404);
        } else {
            try{
                $client = Client::where('_uid', $id)->get();

                $clientId = $client[0]->id;
                $clientDetails = Client::getClientDetails($clientId);

                $breadcrumbs = array([
                    'path' => '',
                    'crumb' => 'Clients'
                    ]
                );

                $data = array(
                    'client_details' => $clientDetails[0],
                    'role_slug' => User::getRoleSlugForUser(),
                    'breadcrumbs' => $breadcrumbs
                );


                return view('clients/client-details', $data);
            } catch(Exception $e){
                dd($e->getMessage());
            }
        }
    }

    public function sendSMSToClientsWithExpiringPolicies(Request $request){
        if(!empty($request)){
            //dd($request);
            
            $clientIds = $request->input('clientIds', []);
            $amountOfDays = $request->input('days');
            
            //$expiryDate = date('Y-m-d', strtotime( '+' . $amountOfDays .' days'));
            
            foreach ($clientIds as $key => $value) {
                
                $client = Client::where('_uid', $value)->get()[0];
                $clientDetails = Client::getClientDetails($client->id);
                $firstName = $clientDetails[0]->first_name;
                $policyNo = $clientDetails[0]->policy_no;
                $policyType = $clientDetails[0]->policy_type;
                $phoneNo = $clientDetails[0]->phone_no;
                $expiryDate = date('d-M-y', strtotime($clientDetails[0]->policy_expires_at));
                
                try{
                    SMSHelper::sendPolicyExpiringSMS($firstName, $policyType, $policyNo, $expiryDate, $phoneNo);

                    return response()->json([
                        'success' => true
                    ]);
                } catch(Exception $e){
                    return response()->json([
                        'success' => false
                    ]);
                }
                
            }
        }
    }

    public function updateClientsBalances(){
        DB::transaction(function(){
            $paymentsSum = PolicyPayment::select('client_id', DB::raw('SUM(amount_paid) as total_paid'))
                                ->groupBy('client_id')
                                ->get();

            foreach ($paymentsSum as $payment) {
                // Fetch the client's original policy amount
                $client = Client::find($payment->client_id);
                if (!$client) {
                    continue; // Skip if client not found (just to be safe)
                }
                
                // Calculate the new balance
                $newBalance = $client->policy_amount - $payment->total_paid;
                
                // Update the client's balance
                $client->policy_balance = $newBalance;
                $client->save();
            }
        });
    }

    public function addClientPayment(Request $request){
        if( empty($request) || $request === null ){
            abort(404);
        } else {
            $amount = $request->input('amount');
            $clientID = $request->input('client_id');

            try{
                $_client_id = Client::where('_uid', $clientID)->get()[0]->id;

                try{
                    Policypayment::create([
                        '_uid' => Str::uuid(),
                        'client_id' => $_client_id,
                        'amount_paid' => $amount,
                        'paid_at' => Carbon::now(),
                    ]);

                    return response()->json([
                        'success' => true
                    ]);
                } catch(QueryException $e){
                    return response()->json([
                        'success' => false
                    ]);
                }

            } catch(QueryException $e){
                return response()->json([
                    'success' => false
                ]);
            }
        }
    }

    public function importClients(){

        if (! Gate::allows('import-clients', Auth::user())) {
            Log::warning('User : ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' tried to view ' . __FUNCTION__ . ' from ' . __CLASS__);
            abort(401);
        }
        Log::info('User : ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' accessed the import clients function');
        $roleSlug = User::getRoleSlugForUser();

        $data = array(
            'viewTitle' => 'Import Clients',
            'role_slug' => $roleSlug,
        );

        return view('clients.import', $data);
    }

    public function doImportClients(Request $request){

        if (! Gate::allows('import-clients', Auth::user())) {
            Log::warning('User : ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' tried to view ' . __FUNCTION__ . ' from ' . __CLASS__);
            abort(401);
        }

        $request->validate([
            'importFile' => 'required|file|mimes:xlsx,xls',
        ]);

        Log::info('User : ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' imported clients');
        if ($request->hasFile('importFile')) {
            $file = $request->file('importFile');
            $path = 'client-imports';
            $filePath = $file->storeAs($path, $file->getClientOriginalName(), 'public');

            try{
                Excel::import(new ClientsImport(), storage_path('app/public/' . $filePath));

                return back()->with('success', 'File has been uploaded and data imported successfully!');
            } catch(Exception $e){
                Log::error('Exception occurred in ' . __CLASS__ . ': ' . $e->getMessage(), ['exception' => $e, 'method' => __FUNCTION__]);
                return back()->with('error', 'Error importin file. ' . $e->getMessage());
            }
            //$filePath = $file->store($path, 'public');
        } else {
            Log::warning('No file was uploaded.');
            return back()->with('error', 'No file was uploaded.');
        }
    }

    public function deleteAll()
    {
        if (! Gate::allows('delete-all-client-data', Auth::user())) {
            abort(403);
        }
        Log::info('User : ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' accessed the import clients function');

        try {
            // Delete all clients for the logged-in user
            $deletedCount = Client::where('user_id', auth()->id())->delete();
            ScheduledSms::truncate();
            Log::info('User : ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' deleted all their client\'s data.');
            return redirect()->back()->with('success', "Successfully deleted {$deletedCount} clients.");
        } catch (\Exception $e) {
            Log::error('Error deleting all client data for: ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' -> ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting clients. Please try again.');
        }
    }

    /**
     * Get SMS template for preview
     */
    public function getSmsTemplate(Request $request)
    {
        try {
            $status = $request->get('status', 'policy-expiring-no-date');
            
            $template = Smstemplate::where('slug', $status)->first();
            
            if (!$template) {
                return response()->json([
                    'success' => false,
                    'message' => 'SMS template not found for status: ' . $status
                ]);
            }
            
            return response()->json([
                'success' => true,
                'template' => $template
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get SMS Template Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving SMS template'
            ], 500);
        }
    }
    
    /**
     * Send bulk lapse pending SMS to selected clients
     */
    public function sendBulkLapseSms(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'client_ids' => 'required|array|min:1',
                'client_ids.*' => 'required|string'
            ]);

            $clientIds = $request->client_ids;
            
            // Get clients with their details
            $clients = Client::whereIn('_uid', $clientIds)
                ->select('id', '_uid', 'first_name', 'last_name', 'policy_no', 'policy_type', 'phone_no') // Adjust field names as needed
                ->get();

// return response()->json([
//                     'success' => true,
//                     'message' => json_decode($clients)
//                 ], 200);
            if ($clients->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid clients found.'
                ], 400);
            }

            // Get the lapse-pending SMS template
            $smsTemplate = Smstemplate::where('slug', 'policy-expiring-no-date')->first();
            
            if (!$smsTemplate) {
                return response()->json([
                    'success' => false,
                    'message' => 'SMS template for lapse-pending status not found.'
                ], 400);
            }

            $successCount = 0;
            $failedCount = 0;
            $errors = [];

            foreach ($clients as $client) {
                // Get phone number (prioritize mobile over phone)
                $phoneNumber = $client->phone_no;
                
                if (empty($phoneNumber)) {
                    $failedCount++;
                    $errors[] = "No phone number for {$client->first_name} {$client->last_name}";
                    continue;
                }

                // Clean and format phone number
                //$phoneNumber = $this->formatPhoneNumber($phoneNumber);
                
                // if (!$this->isValidPhoneNumber($phoneNumber)) {
                //     $failedCount++;
                //     $errors[] = "Invalid phone number for {$client->first_name} {$client->last_name}";
                //     continue;
                // }

                // Format expiry date if needed
                // $expiryDate = $client->expiry_date;
                // if ($expiryDate) {
                //     $expiryDate = date('M d, Y', strtotime($expiryDate));
                // }

                // Send SMS using the existing SMSHelper model method pattern
                // $smsResult = SMSHelper::sendPolicyLapseUsingSMSHelper(
                //     $client->first_name,
                //     $client->policy_type,
                //     $client->policy_no,
                //     //$expiryDate,
                //     $phoneNumber,
                //     $smsTemplate->template_body
                // );

                $smsResult = true;
                
                if ($smsResult) {
                    $successCount++;
                    
                    // Log the SMS in database (optional)
                    $this->logSms($client->id, $phoneNumber, 'lapse-pending', 'sent');
                } else {
                    $failedCount++;
                    $errors[] = "Failed to send SMS to {$client->first_name} {$client->last_name}";
                    
                    // Log the failed SMS (optional)
                    $this->logSms($client->id, $phoneNumber, 'lapse-pending', 'failed');
                }
            }

            // Prepare response
            $response = [
                'success' => $successCount > 0,
                'message' => "SMS processing completed.",
                'successful_count' => $successCount,
                'failed_count' => $failedCount,
                'total_count' => count($clients)
            ];

            if (!empty($errors)) {
                $response['errors'] = $errors;
            }

            return response()->json($response);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Bulk Lapse SMS Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending SMS.'
            ], 500);
        }
    }

    private function logSms($clientId, $phoneNumber, $templateType, $status, $errorMessage = null)
    {
        SMSHelper::logSmsActivity($clientId, $phoneNumber, $templateType, $status, $errorMessage);
    }

    public function getClients(
        int $limit = 100,
        string $embed = 'accountSource,organizations',
        string $activeStatus = 'active,inactive'
    ): Response {
        return Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer ' . $this->bearerToken,
        ])->get($this->baseUrl . '/epic/client/v1/clients', [
            'limit' => $limit
            //'embed' => $embed,
            //'active_status' => $activeStatus,
        ]);
    }

    /**
     * Get clients and return the response data
     *
     * @param int $limit
     * @param string $embed
     * @param string $activeStatus
     * @return array|null
     */
    public function getClientsData(
        int $limit = 100,
        string $embed = 'accountSource,organizations',
        string $activeStatus = 'active,inactive'
    ): ?array {
        $response = $this->getClients($limit, $embed, $activeStatus);

        if ($response->successful()) {
            //dd('data: ' . $response->json());
            //Log::debug('data: ' . $response->json());
            //Log::debug('data 2: ' . print_r($response));
            return $response->json();
        }

        // Handle error cases
        Log::error('API call failed', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        return null;
    }
}
