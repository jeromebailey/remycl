<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Client;
use App\Models\SMSHelper;
use App\Models\Smstemplate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Policypayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;

class ClientController extends Controller
{
    //

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
}
