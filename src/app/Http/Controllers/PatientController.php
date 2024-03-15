<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Device;
use App\Models\Genders;
use App\Models\Patient;
use App\Models\ErrorLog;
use App\Models\RoleUser;
use App\Models\AppMailer;
use App\Models\Bgreading;
use App\Models\Bpreading;
use App\Models\Caregiver;
use App\Models\Onboarded;
use App\Models\PatientPRN;
use App\Models\RPMService;
use App\Models\AppSettings;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Maritalstatus;
use App\Models\Assigneddevice;
use App\Models\Personaldetail;
use Illuminate\Support\Carbon;
use App\Models\Bpreadingstatus;
use App\Models\PatientBpTarget;
use App\Models\ServiceDuration;
use App\Models\PatientCaregiver;
use App\Models\PhysicianPatient;
use App\Models\PatientRpmService;
use App\Models\Contactinformation;
use Illuminate\Support\Facades\DB;
use App\Models\Onboardingchecklist;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use App\Http\Requests\SignupPatientRequest;
use App\Models\PatientsBPReadingsBoundaries;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\OnboardingChecklistRequest;
use App\Models\Invalidatebpreason;
use App\Models\Invalidatebpreasonaction;
use App\Models\Physician;
use App\Models\StringHelper;
use ErrorException;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['patientsBPReadings', 'patientsBGReadings']);
    }
    
    //
    public function index()
    {
        if (! Gate::allows('view-all-patients', Auth::user())) {
            abort(403);
        }

        $id = Auth::user()->id;
        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = ($slug == 'super-admin') ? 'admin' : $slug;

        switch($slug)
        {
            case 'super-admin':
            case 'nurse':
                $allPatients = Patient::getAllPatients(1);

                $breadcrumbs = array(
                    ['path' => $roleSlug . '/patients', 'crumb' => 'Patients'],
                    ['path' => $roleSlug . '/patients', 'crumb' => 'All Patients']
                );

                $data = array(
                    'viewTitle' => 'All Patients',
                    'patients' => $allPatients,
                    'role_slug' => $roleSlug,
                    'breadcrumbs' => $breadcrumbs
                );
                return view('patients.list-patients', $data);
                break;

            case 'physician':
                    $allPatients = Patient::getAllPatientsByPhysicianId($id);
    
                    $data = array(
                        'viewTitle' => 'My Patients',
                        'patients' => $allPatients,
                        'role_slug' => $roleSlug
                    );
                    return view('patients.list-patients', $data);
                    break;
        }
    }

    public function getBPReadingsForAllPatients()
    {
        if (! Gate::allows('view-bp-readings-for-all-patients', Auth::user())) {
            abort(403);
        }

        $id = Auth::user()->id;
        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = ($slug == 'super-admin') ? 'admin' : $slug;

        $myPatientsBPReadings = Bpreading::getBPReadingsForAllPatients($id);

        $breadcrumbs = array(
            ['path' => $roleSlug . '/all-patients-bp-readings', 'crumb' => 'BP Readings'],
            ['path' => $roleSlug . '/all-patients-bp-readings', 'crumb' => 'Patients BP Reason']
        );

        $data = array(
            'viewTitle' => 'All Patients Readings',
            'patients_readings' => $myPatientsBPReadings,
            'breadcrumbs' => $breadcrumbs
        );
        return view('patients.list-all-patients-bp-readings', $data);
    }

    public function viewPatient($_uid)
    {
        if (! Gate::allows('view-patient-information', Auth::user())) {
            abort(403);
        }

        $id = Auth::user()->id;
        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        if( empty($_uid) )
        {
            abort(403);
        } else {
            try
            {
                $patient_id = User::where('_uid', $_uid)->get()[0]->id;
//dd($patient_id);
                try {
                    $patientDetails = Patient::getPatientInformation($patient_id);
                    $marital_statuses = Maritalstatus::all()->sortBy('marital_status');
                    $genders = Genders::all()->sortBy('gender');
                    $rpm_services = RPMService::all()->sortBy('rpm_service');
                    $service_duration = ServiceDuration::all();

                    $data = array(
                        'viewTitle' => 'View Patient Information',
                        'marital_statuses' => $marital_statuses,
                        'genders' => $genders,
                        'rpm_services' => $rpm_services,
                        'service_duration' => $service_duration,
                        'patients_details' => $patientDetails[0]
                    );
//dd($patientDetails);
                   
                    return view('patients.view-patient', $data);
                } catch (Exception $e) {
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error getting patient information: " . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    Log::error("Error getting patient information: " . $e->getMessage());
                }
            } catch(Exception $e)
            {
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error getting patient id from uid: " . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
                Log::error("Error getting patient id from uid: " . $e->getMessage());
            }
        }

        
    }

    // public function patientsBPReadings(Request $request)
    // {
    //     // try{
            
    //     //     // Validate the payload
    //     //     $data = $request->validate([
    //     //         'deviceId' => 'required|integer',
    //     //         'readingType' => 'required|string|in:BloodPressure',
    //     //         'time' => 'required|numeric',
    //     //         'data.systolic' => 'required|integer|min:0',
    //     //         'data.diastolic' => 'required|integer|min:0',
    //     //         'data.pulse' => 'required|integer|min:0',
    //     //         'data.arrhythmia' => 'required|integer|in:0,1',
    //     //     ]);
            
    //         try{
    //             Bpreading::create([
    //                 '_uid' => Str::uuid(),
    //                 'patient_id' => 101,
    //                 'device_id' => $request->input('deviceId'),
    //                 'systolic' => $request->input('data.systolic'),
    //                 'diastolic' => $request->input('data.diastolic'),
    //                 'pulse' => $request->input('data.pulse'),
    //                 'arrhythmia' => $request->input('data.arrhythmia'),
    //             ]);

    //             return response()->json(['message' => 'Reading saved successfully']);
    //         } catch(ValidationException $e)
    //         {
    //             return response()->json($e->errors(), 422);
    //         }

    //         // } catch(ValidationException $e)
    //         // {
    //         //     return response()->json($e->errors(), 422);
    //         // }
    //     // } catch(ValidationException $e)
    //     // {
    //     //     return response()->json($e->errors(), 422);
    //     // }
    // }

    public function patientsBPReadings(Request $request)
    {
        // $patient_name = '';
        // $reading = 'Systolic: ' . 110 . ', 
        // Diastolic: ' . 59 . ', Pulse: ' . 68;

        
        //     $patient_name = 'Jerome Bailey';
        //     dd(AppMailer::sendCriticalBPReadingEmail(array('bailey.jerome@gmail.com'), $patient_name, $reading));
        //Log::info($request);
        //Log::info('Request method: ' . $request->method());
        //Log::info('Request URI: ' . $request->getRequestUri());
        //Log::info('Request Headers:', $request->headers->all());
        Log::info('Request Data:', $request->all());

        //Log::info('request', print_r($request));
        //Log::error('request', print_r($request));

        try{
            // $this->validate($request, [
            //     'deviceId' => 'required|uuid',
            //     'readingType' => 'required|string',
            //     'time' => 'required|numeric',
            //     'data.systolic' => 'required|numeric',
            //     'data.diastolic' => 'required|numeric',
            //     'data.pulse' => 'required|numeric',
            //     'data.arrhythmia' => 'required|integer',
            // ]);
            
            // Validate the payload
            $data = $request->validate([
                'deviceId' => 'required|integer',
                'readingType' => 'required|string|in:BloodPressure',
                'time' => 'required|string',
                'data.systolic' => 'required|integer|min:0',
                'data.diastolic' => 'required|integer|min:0',
                'data.pulse' => 'required|integer|min:0',
                'data.arrhythmia' => 'integer|in:0,1',
            ]);

            try{
                $assignedDevice = Assigneddevice::where('device_unique_id', $request->input('deviceId'))->get();
                //dd($assignedDevice[0]->patient_user_id);
                try{
                    $patientId = $assignedDevice[0]->patient_user_id;

                    $timestampInMilliseconds = $request->input('time');
                    $timestampInSeconds = $timestampInMilliseconds / 1000;
                    // $date = Carbon::createFromTimestampMs($timestampInMilliseconds);

                    $systolic_value = $request->input('data.systolic');
                    $diastolic_value = $request->input('data.diastolic');

                    $systolic_status = $diastolic_status = $boundaries = '';
                    $reading_is_critical = false;
                    try{
                        $target = User::find($patientId)->bptarget;
//dd($target);
                        if( $target !== null )
                        {
                            $systolic_range = $target->systolic_range;
                            list($systolic_low_target, $systolic_high_target) = explode('-', $systolic_range);
                            $systolic_low_target = (int)$systolic_low_target;
                            $systolic_high_target = (int)$systolic_high_target;

                            $diastolic_range = $target->diastolic_range;
                            list($diastolic_low_target, $diastolic_high_target) = explode('-', $diastolic_range);
                            $diastolic_low_target = (int)$diastolic_low_target;
                            $diastolic_high_target = (int)$diastolic_high_target;

                            try{
                                $boundaries = User::find($patientId)->bpboundaries;
                                //dd($boundaries);
                                $systolic_low_critical_boundary = (int)$boundaries->systolic_low_critical;
                                list($systolic_low_range_1, $systolic_low_range_2) = explode('-', $boundaries->systolic_low);
                                $systolic_low_range_1 = (int)$systolic_low_range_1;
                                $systolic_low_range_2 = (int)$systolic_low_range_2;

                                list($systolic_high_range_1, $systolic_high_range_2) = explode('-', $boundaries->systolic_high);
                                $systolic_high_range_1 = (int)$systolic_high_range_1;
                                $systolic_high_range_2 = (int)$systolic_high_range_2;
                                $systolic_high_critical_boundary = (int)$boundaries->systolic_high_critical;

                                $diastolic_low_critical_boundary = (int)$boundaries->diastolic_low_critical;
                                list($diastolic_low_range_1, $diastolic_low_range_2) = explode('-', $boundaries->diastolic_low);
                                $diastolic_low_range_1 = (int)$diastolic_low_range_1;
                                $diastolic_low_range_2 = (int)$diastolic_low_range_2;

                                list($diastolic_high_range_1, $diastolic_high_range_2) = explode('-', $boundaries->diastolic_high);
                                $diastolic_high_range_1 = (int)$diastolic_high_range_1;
                                $diastolic_high_range_2 = (int)$diastolic_high_range_2;
                                $diastolic_high_critical_boundary = (int)$boundaries->diastolic_high_critical;
                                
                                if( $systolic_value < $systolic_low_critical_boundary )
                                {
                                    $systolic_status = Bpreadingstatus::where('slug', 'low-critical')->get()[0]->id;
                                    $reading_is_critical = true;
                                } elseif($systolic_value > $systolic_low_range_1 && $systolic_value < $systolic_low_range_2)
                                {
                                    $systolic_status = Bpreadingstatus::where('slug', 'low')->get()[0]->id;
                                } elseif( $systolic_value > $systolic_low_target && $systolic_value < $systolic_high_target )
                                {
                                    $systolic_status = Bpreadingstatus::where('slug', 'within-range')->get()[0]->id;
                                } elseif($systolic_value > $systolic_high_range_1 && $systolic_value < $systolic_high_range_2)
                                {
                                    $systolic_status = Bpreadingstatus::where('slug', 'high')->get()[0]->id;
                                } elseif( $systolic_value > $systolic_high_critical_boundary )
                                {
                                    $systolic_status = Bpreadingstatus::where('slug', 'high-critical')->get()[0]->id;
                                    $reading_is_critical = true;
                                }

                                if( $diastolic_value < $diastolic_low_critical_boundary )
                                {
                                    $diastolic_status = Bpreadingstatus::where('slug', 'low-critical')->get()[0]->id;
                                    $reading_is_critical = true;
                                } elseif($diastolic_value > $diastolic_low_range_1 && $diastolic_value < $diastolic_low_range_2)
                                {
                                    $diastolic_status = Bpreadingstatus::where('slug', 'low')->get()[0]->id;
                                } elseif( $diastolic_value > $diastolic_low_target && $diastolic_value < $diastolic_high_target )
                                {
                                    $diastolic_status = Bpreadingstatus::where('slug', 'within-range')->get()[0]->id;
                                } elseif($diastolic_value > $diastolic_high_range_1 && $diastolic_value < $diastolic_high_range_2)
                                {
                                    $diastolic_status = Bpreadingstatus::where('slug', 'high')->get()[0]->id;
                                } elseif( $diastolic_value > $diastolic_high_critical_boundary )
                                {
                                    $diastolic_status = Bpreadingstatus::where('slug', 'high-critical')->get()[0]->id;
                                    $reading_is_critical = true;
                                }

                                try{
                                    Bpreading::create([
                                        '_uid' => Str::uuid(),
                                        'patient_id' => $patientId,
                                        'device_id' => $request->input('deviceId'),
                                        'time' => Carbon::createFromTimestamp($timestampInSeconds)->toDateTimeString(),
                                        'systolic' => $systolic_value, //$request->input('data.systolic'),
                                        'diastolic' => $diastolic_value, //$request->input('data.diastolic'),
                                        'pulse' => $request->input('data.pulse'),
                                        'arrhythmia' => $request->input('data.arrhythmia'),
                                        'systolic_status_id' => $systolic_status,
                                        'diastolic_status_id' => $diastolic_status,
                                    ]);

                                    $patient_name = '';
                                    $reading = 'Systolic: ' . $systolic_value . ', 
                                    Diastolic: ' . $diastolic_value . ', Pulse: ' . $request->input('data.pulse');

                                    try{
                                        $patient = User::find($patientId);
                                        $patient_name = $patient->first_name . ' ' . $patient->last_name;
                                        try{
                                            AppMailer::sendCriticalBPReadingEmail(array('bailey.jerome@gmail.com','khimanie@yahoo.com'), $patient_name, $reading);
                                        } catch(Exception $e)
                                        {
                                            $data = [
                                                'controller' => __CLASS__,
                                                'function' => __FUNCTION__,
                                                'message' => "Error sending critical bp mail: " . $e->getMessage(),
                                                'stack_trace' => $e,
                                            ];
                                            ErrorLog::logError($data);
                                            Log::error("Error sending critical bp mail: " . $e->getMessage());
                                        }
                                    } catch(QueryException $e)
                                    {
                                        $data = [
                                            'controller' => __CLASS__,
                                            'function' => __FUNCTION__,
                                            'message' => "Error getting patient data: " . $e->getMessage(),
                                            'stack_trace' => $e,
                                        ];
                                        ErrorLog::logError($data);
                                        Log::error("Error getting patient data: " . $e->getMessage());
                                    }

                                    return response()->json(['message' => 'Reading saved successfully']);
                                } catch(ValidationException $e)
                                {
                                    $data = [
                                        'controller' => __CLASS__,
                                        'function' => __FUNCTION__,
                                        'message' => "Error running query to insert reading: " . $e->getMessage(),
                                        'stack_trace' => $e,
                                    ];
                                    ErrorLog::logError($data);
                                    Log::error("Error running query to insert reading: " . $e->getMessage());
                                    return response()->json($e->errors(), 422);
                                }
                            } catch( QueryException $e )
                            {
                                $data = [
                                    'controller' => __CLASS__,
                                    'function' => __FUNCTION__,
                                    'message' => "Error getting BP Target for patient:" . $e->getMessage(),
                                    'stack_trace' => $e,
                                ];
                                ErrorLog::logError($data);
                                Log::error("Error getting BP Target for patient: " . $e->getMessage());
                                return response()->json($e->getMessage(), 422);
                            }
                        }
                    } catch( QueryException $e )
                    {
                        $data = [
                            'controller' => __CLASS__,
                            'function' => __FUNCTION__,
                            'message' => "Error getting BP Target for patient:" . $e->getMessage(),
                            'stack_trace' => $e,
                        ];
                        ErrorLog::logError($data);
                        Log::error("Error getting BP Target for patient: " . $e->getMessage());
                        return response()->json($e->getMessage(), 422);
                    }
                } catch(Exception $e)
                {
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error running query to get patient id from assigned devices: " . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    //ErrorLog::logError(__CLASS__, __FUNCTION__, "Error running query to insert reading: " . $e->getMessage(),$e);
                    Log::error("Error running query to get patient id from assigned devices: " . $e->getMessage());
                    //return response()->json($e->errors(), 422);
                }
                 catch(ValidationException $e)
                {
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error running query to get patient id from assigned devices: " . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    Log::error("Error running query to get patient id from assigned devices: " . $e->getMessage());
                    return response()->json($e->errors(), 422);
                }
            } catch(ValidationException $e)
            {
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error running query to get assigned device: " . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
                Log::error("Error running query to get assigned device: " . $e->getMessage());
                return response()->json($e->errors(), 422);
            }
        } catch(ValidationException $e)
        {
            $data = [
                'controller' => __CLASS__,
                'function' => __FUNCTION__,
                'message' => "Error validating post request: " . $e->getMessage(),
                'stack_trace' => $e,
            ];
            ErrorLog::logError($data);
            Log::error("Error validating post request: " . $e->getMessage());
            return response()->json($e->errors(), 422);
        }
    }

    public function patientsBGReadings(Request $request)
    {
        Log::info('Request Data:', $request->all());

        // try{
        //     // Validate the payload
        //     $data = $request->validate([
        //         'deviceId' => 'required|integer',
        //         'readingType' => 'required|string|in:BloodGlucose',
        //         'time' => 'required|numeric',
        //         'data.glucose' => 'required|integer|min:0',
        //         'data.readingPeriod' => 'required|string|in:before,after',
        //     ]);

        $timestampInMilliseconds = $request->input('time');
        $timestampInSeconds = $timestampInMilliseconds / 1000;

            try{
                Bgreading::create([
                    '_uid' => Str::uuid(),
                    'patient_id' => 102,
                    'device_id' => $request->input('deviceId'),
                    'glucose' => $request->input('data.glucose'),
                    'readingPeriod' => $request->input('data.readingPeriod'),
                    'time' => Carbon::createFromTimestamp($timestampInSeconds)->toDateTimeString(),
                ]);

                return response()->json(['message' => 'Reading saved successfully']);
            } catch(ValidationException $e)
            {
                return response()->json($e->errors(), 422);
            }
        // } catch(ValidationException $e)
        // {
        //     return response()->json($e->errors(), 422);
        // }
    }

    // public function patientsBGReadings(Request $request)
    // {
    //     try{
    //         // Validate the payload
    //         $data = $request->validate([
    //             'deviceId' => 'required|uuid',
    //             'readingType' => 'required|string',
    //             'time' => 'required|numeric',
    //             'data.glucose' => 'required|numeric',
    //             'data.readingPeriod' => 'required|string',
    //         ]);

    //         try{
    //             $assignedDevice = Assigneddevice::where('device_unique_id', $request->deviceId)->get();
    //             $patientId = $assignedDevice[0]->patient_user_id;

    //             try{
    //                 Bgreading::create([
    //                     '_uid' => Str::uuid(),
    //                     'patient_id' => $patientId,
    //                     'device_id' => $request->deviceId,
    //                     'glucose' => $request->data['glucose'],
    //                     'readingPeriod' => $request->data['readingPeriod'],
    //                 ]);

    //                 return response()->json(['message' => 'Reading saved successfully']);
    //             } catch(ValidationException $e)
    //             {
    //                 return response()->json($e->errors(), 422);
    //             }

    //         } catch(ValidationException $e)
    //         {
    //             return response()->json($e->errors(), 422);
    //         }
    //     } catch(ValidationException $e)
    //     {
    //         return response()->json($e->errors(), 422);
    //     }
    // }

    public function getPatientsOwnBPReadings()
    {
        // if (! Gate::allows('view-all-patients', Auth::user())) {
        //     abort(403);
        // }

        //dd(auth()->user()->id);

        try{
            $readings = Bpreading::getBPReadingsForPatient(auth()->user()->id);
            //dd($readings);
            $data = array(
                'viewTitle' => 'My Readings',
                'readings' => $readings
            );
            return view('patients.list-patients-own-bp-readings', $data);
        } catch(Exception $e)
        {
            dd('cant get readings: ' . $e->getMessage());
        }
    }

    public function signupPatient()
    {
        if (! Gate::allows('sign-up-patient', Auth::user())) {
            abort(403);
        }
        
        $marital_statuses = Maritalstatus::all()->sortBy('marital_status');
        $genders = Genders::all()->sortBy('gender');
        $rpm_services = RPMService::all()->sortBy('rpm_service');
        $service_duration = ServiceDuration::all();
        $physicians = Physician::getPhysiciansDDL();

        $data = array(
            'viewTitle' => 'Sign up Patient',
            'marital_statuses' => $marital_statuses,
            'genders' => $genders,
            'rpm_services' => $rpm_services,
            'service_duration' => $service_duration,
            'physicians' => $physicians
        );
        return view('patients.signup-patient', $data);
    }

    public function doSignUpPatient(SignupPatientRequest $request)
    {
        if (! Gate::allows('sign-up-patient', Auth::user())) {
            abort(403);
        }

        try{
            $service = RPMService::where('slug', $request->input('rpm_service'))->first();

            if( $service->slug === "bpm" )
            {
                $service_id = $service->id;
                //validate for blood pressure
                // $request->validate([
                //     'first_name' => 'required|string|max:255',
                //     'last_name' => 'required|string|max:255',
                //     'date_of_birth' => 'date',
                //     'gender' => 'required',
                //     'primary_phone_no' => 'required',
                //     'secondary_phone_no' => 'nullable',
                //     'email_address' => 'required|email',
                //     'rpm_service' => 'required',
                //     'service_duration' => 'required',
                //     'systolic_lower' > 'required|integer',
                //     'systolic_upper' > 'required|integer',
                //     'diastolic_lower' > 'required|integer',
                //     'diastolic_upper' > 'required|integer',
                // ]);

                DB::beginTransaction();

                $patient_uid = Str::uuid()->toString();

                try{
                    $id = User::create([
                        '_uid' => $patient_uid,
                        'first_name' => $request->input('first_name'),
                        'last_name' => $request->input('last_name'),
                        'email' => $request->input('email_address'),
                    ])->id;

                    $gender_id = Genders::where('_uid', $request->input('gender'))->first()->id;

                    try{
                        Personaldetail::create([
                            'user_id' => $id,
                            'dob' => $request->input('dob'),
                            'gender_id' => $gender_id,
                        ]);

                        try{
                            Contactinformation::create([
                                'patient_id' => $id,
                                'primary_phone_no' => $request->input('primary_phone_no'),
                                'secondary_phone_no' => $request->input('secondary_phone_no'),
                                //'email_address' => $request->input('gender'),
                            ]);

                            $duration_id = ServiceDuration::where('_uid', $request->input('service_duration'))->first()->id;

                            try{
                                PatientRpmService::create([
                                    'patient_id' => $id,
                                    'rpm_service_id' => $service_id,
                                    'service_duration_id' => $duration_id,
                                    'patient_give_consent' => $request->input('patient_give_consent')
                                ]);

                                $systolic_lower = $request->input('systolic_lower');
                                $systolic_upper = $request->input('systolic_upper');
                                $systolic_range = $systolic_lower . '-' . $systolic_upper;

                                $diastolic_lower = $request->input('diastolic_lower');
                                $diastolic_upper = $request->input('diastolic_upper');
                                $diastolic_range = $diastolic_lower . '-' . $diastolic_upper;

                                try{
                                    PatientBpTarget::create([
                                        'patient_id' => $id,
                                        'systolic_range' => $systolic_range,
                                        'diastolic_range' => $diastolic_range,
                                        'additional_comments' => $request->input('bp_comments')
                                    ]);

                                    $systolic_low_differential_value = (int)AppSettings::where('slug', 'systolic-low-differential-value')->first()->settings_value;
                                    $systolic_high_differential_value = (int)AppSettings::where('slug', 'systolic-high-differential-value')->first()->settings_value;
                                    $systolic_high_critical_differential_value = $systolic_high_differential_value + 10;

                                    $diastolic_low_differential_value = (int)AppSettings::where('slug', 'diastolic-low-differential-value')->first()->settings_value;

                                    try{
                                        PatientsBPReadingsBoundaries::create([
                                            'patient_id' => $id,
                                            'systolic_low_critical' => $systolic_lower - $systolic_low_differential_value,
                                            'systolic_low' => ($systolic_lower - $systolic_low_differential_value) . '-' . $systolic_lower,
                                            'systolic_high' => $systolic_upper . '-' . ($systolic_upper + $systolic_high_differential_value),
                                            'systolic_high_critical' => $systolic_upper + $systolic_high_critical_differential_value,
                                            'diastolic_low_critical' => $diastolic_lower - $diastolic_low_differential_value, 
                                            'diastolic_low' => ($diastolic_lower - $diastolic_low_differential_value) . '-' . $diastolic_lower,
                                            'diastolic_high' => $diastolic_lower . '-' . ($diastolic_lower + $diastolic_low_differential_value),
                                            'diastolic_high_critical' => $diastolic_lower + $diastolic_low_differential_value,
                                        ]);

                                        try{
                                            $user_prn = PatientPRN::generatePRNCode();
                                            $full_prn = date('y') . '-' . $user_prn;
    
                                            PatientPRN::create([
                                                'patient_id' => $id,
                                                'prn' => $full_prn
                                            ]);
    
                                            try{
                                                PhysicianPatient::create([
                                                    'physician_id' => auth()->user()->id,
                                                    'patient_id' => $id
                                                ]);

                                                $role_id = Role::where('slug', 'patient')->first()->id;

                                                try{
                                                    RoleUser::create([
                                                        'user_id' => $id,
                                                        'role_id' => $role_id
                                                    ]);

                                                    try{
                                                        Onboarded::create([
                                                            '_uid' => Str::uuid()->toString(),
                                                            'patient_id' => $id,
                                                            'onboarded' => false,
                                                            'date_added_to_queue' => Carbon::now()->format('Y-m-d')
                                                        ]);

                                                        try{
                                                            DB::commit();
                                                            //session()->put('can_add_other_employee_info', true);
                                                            //session()->put('_id', $id);
                                                            $request->flash();
                                                            $request->session()->flash('success', 'Patient was successfully signed up for Blood Pressure Monitoring Service.');
                                                            //dd('success');
                                                            //return redirect()->route('add-employee', ['id' => $employee_uid]);
                                                            return redirect()->back();
                                                        } catch(QueryException $e)
                                                        {
                                                            //dd('didnt commit changes: ' . $e);
                                                            DB::rollBack();
                                                            $data = [
                                                                'controller' => __CLASS__,
                                                                'function' => __FUNCTION__,
                                                                'message' => "Error committing patient information:" . $e->getMessage(),
                                                                'stack_trace' => $e,
                                                            ];
                                                            ErrorLog::logError($data);
                                                            $request->session()->flash('error', 'Patient information was not created.');
                                                            return redirect()->back();
                                                        }
                                                    } catch(QueryException $e)
                                                    {
                                                        //dd('link patient: ' . $e);
                                                        DB::rollBack();
                                                        $data = [
                                                            'controller' => __CLASS__,
                                                            'function' => __FUNCTION__,
                                                            'message' => "Error adding patient to Onboarded queue: " . $e->getMessage(),
                                                            'stack_trace' => $e,
                                                        ];
                                                        ErrorLog::logError($data);
                                                        $request->session()->flash('error', 'Patient information was not created (Code: POQ-01).'); //Patient Onboarding Queue
                                                        return redirect()->back();
                                                    }
                                                } catch(QueryException $e)
                                                {
                                                    //dd('link patient: ' . $e);
                                                    DB::rollBack();
                                                    $data = [
                                                        'controller' => __CLASS__,
                                                        'function' => __FUNCTION__,
                                                        'message' => "Error creating patient's role: " . $e->getMessage(),
                                                        'stack_trace' => $e,
                                                    ];
                                                    ErrorLog::logError($data);
                                                    $request->session()->flash('error', 'Patient information was not created (Code: PRI-01).'); //Patient Role Information
                                                    return redirect()->back();
                                                }
                                            } catch(QueryException $e)
                                            {
                                                //dd('link patient: ' . $e);
                                                DB::rollBack();
                                                $data = [
                                                    'controller' => __CLASS__,
                                                    'function' => __FUNCTION__,
                                                    'message' => "Error linking patient to physician: " . $e->getMessage(),
                                                    'stack_trace' => $e,
                                                ];
                                                ErrorLog::logError($data);
                                                $request->session()->flash('error', 'Patient information was not created (Code: PPL-01).'); //Patient Physician Link
                                                return redirect()->back();
                                            }
                                        } catch(QueryException $e)
                                        {
                                            //dd('prn patient: ' . $e);
                                            DB::rollBack();
                                            $data = [
                                                'controller' => __CLASS__,
                                                'function' => __FUNCTION__,
                                                'message' => "Error generating prn for patient: " . $e->getMessage(),
                                                'stack_trace' => $e,
                                            ];
                                            ErrorLog::logError($data);
                                            $request->session()->flash('error', 'Patient information was not created (Code: PRN-01).'); //Patient's Registration Number
                                            return redirect()->back();
                                        }
                                    } catch(QueryException $e)
                                    {
                                        //dd('boundaries patient: ' . $e);
                                        DB::rollBack();
                                        $data = [
                                            'controller' => __CLASS__,
                                            'function' => __FUNCTION__,
                                            'message' => "Error creating bp boundaries for patient:" . $e->getMessage(),
                                            'stack_trace' => $e,
                                        ];
                                        ErrorLog::logError($data);
                                        $request->session()->flash('error', 'Patient information was not created (BPB-01).'); //bp boundaries
                                        return redirect()->back();
                                    }
                                } catch(QueryException $e)
                                {
                                    //dd('patient bp target: ' . $e);
                                    DB::rollBack();
                                    $data = [
                                        'controller' => __CLASS__,
                                        'function' => __FUNCTION__,
                                        'message' => "Error saving patient's bp target information to table: " . $e->getMessage(),
                                        'stack_trace' => $e,
                                    ];
                                    ErrorLog::logError($data);
                                    $request->session()->flash('error', 'Patient information was not created (Code: BPT-01).'); //Patient BP Target
                                    return redirect()->back();
                                }
                            } catch(QueryException $e)
                            {
                                //dd('patient service: ' . $e);
                                DB::rollBack();
                                $data = [
                                    'controller' => __CLASS__,
                                    'function' => __FUNCTION__,
                                    'message' => "Error saving patient service information to table: " . $e->getMessage(),
                                    'stack_trace' => $e,
                                ];
                                ErrorLog::logError($data);
                                $request->session()->flash('error', 'Patient information was not created (Code: PRS-01).'); //Patient RPM Service
                                return redirect()->back();
                            }
                        } catch(QueryException $e)
                        {
                            //dd('patient contact information: ' . $e);
                            DB::rollBack();
                            $data = [
                                'controller' => __CLASS__,
                                'function' => __FUNCTION__,
                                'message' => "Error saving patient's contact information to table: " . $e->getMessage(),
                                'stack_trace' => $e,
                            ];
                            ErrorLog::logError($data);
                            $request->session()->flash('error', 'Patient information was not created (Code: PCI-01).'); //Patient Contact Information
                            return redirect()->back();
                        }
                    } catch(QueryException $e)
                    {
                        //dd('patient personal details: ' . $e);
                        DB::rollBack();
                        $data = [
                            'controller' => __CLASS__,
                            'function' => __FUNCTION__,
                            'message' => "Error saving patient's personal details information to table: " . $e->getMessage(),
                            'stack_trace' => $e,
                        ];
                        ErrorLog::logError($data);
                        $request->session()->flash('error', 'Patient information was not created (Code: PDT-01).'); //Patient Personal Details
                        return redirect()->back();
                    }
                } catch(QueryException $e)
                {
                    //dd('didnt set user info: ' . $e);
                    //user error
                    DB::rollBack();
                    
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error saving user information to table: " . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    $request->session()->flash('error', 'Patient information was not created (Code: USI-01).'); //User Information
                    return redirect()->back();
                }

            } else if( $request->input('rpm_service') === 'bgm' ) {
                //validate for blood glucose
                $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'date_of_birth' => 'date',
                    'gender' => 'required',
                    'primary_phone_no' => 'required',
                    'secondary_phone_no' => 'nullable',
                    'email_address' => 'required|email',
                    'rpm_service' => 'required',
                    'service_duration' => 'required',
                    'before_meals_lower' > 'required|integer',
                    'before_meals_upper' > 'required|integer',
                    'after_meals' > 'required|integer',
                ]);
            } else {
                //invalid value passed for rpm service
                dd($service->slug);
                $request->session()->flash('error', 'Invalid option selected for RPM Service');
                return redirect()->back();
            }
        } catch(Exception $e)
        {
            $data = [
                'controller' => __CLASS__,
                'function' => __FUNCTION__,
                'message' => "Error getting service from slug: " . $e->getMessage(),
                'stack_trace' => $e,
            ];
            ErrorLog::logError($data);
            Log::error("Error getting service from slug: " . $e->getMessage());
            $request->session()->flash('error', 'Invalid option selected for RPM Service');
            return redirect()->back();
        }
    }

    public function onboardPatient(Request $request, $id)
    {
        if (! Gate::allows('onboard-patient', Auth::user())) {
            abort(403);
        }

        if( $id == null || $id === '' )
        {
            abort(404);
        } else {
            $role = Auth::user()->roles;
            $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

            try{
                $patient = User::where('_uid', $id)->get()[0];
                $patient_id = $patient->id;
                
                try{
                    $personal_info = User::getPatientOnboardingInformation($patient_id);
                    $assigned_device = Patient::getDeviceAssignedToPatient($patient_id);
                    $genders = Genders::all()->sortBy('gender');
                    $patientCaregivers = Patient::getPatientCaregivers($patient_id);
//dd($assigned_device);
                    $data = array(
                        'patient_info' => $personal_info[0],
                        'id' => $id,
                        'assigned_device' => $assigned_device,
                        'genders' => $genders,
                        'role_slug' => $roleSlug,
                        'caregivers' => $patientCaregivers
                    );

                    return view('patients.onboard-patient', $data);
                } catch(QueryException $e)
                {
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error getting id of patient:" . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    Log::error("Error getting BP Target for patient: " . $e->getMessage());
                    $request->session()->flash('error', 'Error retrieving Patient information (Code: PID-01).'); //Patient ID not found
                    return redirect()->back();
                }
            } catch( QueryException $e )
            {
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error getting id of patient:" . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
                Log::error("Error getting BP Target for patient: " . $e->getMessage());
                $request->session()->flash('error', 'Error retrieving Patient information (Code: PID-01).'); //Patient ID not found
                return redirect()->back();
            }
        }
    }

    public function addCaregiverForPatient(Request $request, $id)
    {
        if (! Gate::allows('add-caregiver-for-patient', Auth::user())) {
            abort(403);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'date',
            'gender' => 'required',
            'primary_phone_no' => 'required',
            'secondary_phone_no' => 'nullable',
            'email_address' => 'required|email',
            'is_primary_caregiver' => 'required',
            'is_next_of_kin' => 'required',
        ]);

        DB::beginTransaction();

        try{
            $role = Auth::user()->roles;
            $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

            $patient_id = User::where('_uid', $id)->get()[0]->id;

            $caregiver_uid = Str::uuid()->toString();

            try{
                $caregiver_id = User::create([
                    '_uid' => $caregiver_uid,
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email_address'),
                ])->id;

                $gender_id = Genders::where('_uid', $request->input('gender'))->first()->id;

                try{
                    Personaldetail::create([
                        'user_id' => $caregiver_id,
                        'dob' => $request->input('dob'),
                        'gender_id' => $gender_id,
                    ]);

                    try{
                        Contactinformation::create([
                            'patient_id' => $caregiver_id,
                            'primary_phone_no' => $request->input('primary_phone_no'),
                            'secondary_phone_no' => $request->input('secondary_phone_no'),
                        ]);

                            $role_id = Role::where('slug', 'caregiver')->first()->id;

                            try{
                                RoleUser::create([
                                    'user_id' => $caregiver_id,
                                    'role_id' => $role_id
                                ]);

                                try{
                                    Caregiver::create([
                                        'user_id' => $caregiver_id,
                                        'is_primary_caregiver' => false,
                                        'is_next_of_kin' => false,
                                        'date_added_to_queue' => Carbon::now()->format('Y-m-d')
                                    ]);

                                    try{
                                        PatientCaregiver::create([
                                            'patient_id' => $patient_id,
                                            'caregiver_id' => $caregiver_id
                                        ]);

                                        try{
                                            DB::commit();
                                            //session()->put('can_add_other_employee_info', true);
                                            //session()->put('_id', $id);
                                            $request->flash();
                                            $request->session()->flash('success', 'Caregiver was successfully added to patient.');
                                            //dd('success');
                                            //return redirect()->route('add-employee', ['id' => $employee_uid]);
                                            //return redirect()->back();
                                            return redirect()->route($roleSlug.'/onboard-patient', $id);
                                        } catch(QueryException $e)
                                        {
                                            //dd('didnt commit changes: ' . $e);
                                            DB::rollBack();
                                            $data = [
                                                'controller' => __CLASS__,
                                                'function' => __FUNCTION__,
                                                'message' => "Error committing caregiver information:" . $e->getMessage(),
                                                'stack_trace' => $e,
                                            ];
                                            ErrorLog::logError($data);
                                            $request->session()->flash('error', 'Caregiver information was not created.');
                                            return redirect()->back();
                                        }
                                    } catch(QueryException $e)
                                    {
                                        //dd('link patient: ' . $e);
                                        DB::rollBack();
                                        $data = [
                                            'controller' => __CLASS__,
                                            'function' => __FUNCTION__,
                                            'message' => "Error creating caregiver giver link: " . $e->getMessage(),
                                            'stack_trace' => $e,
                                        ];
                                        ErrorLog::logError($data);
                                        $request->session()->flash('error', 'Caregiver information was not created (Code: PCG-01).'); //Patient Onboarding Queue
                                        return redirect()->back();
                                    }
                                } catch(QueryException $e)
                                {
                                    //dd('link patient: ' . $e);
                                    DB::rollBack();
                                    $data = [
                                        'controller' => __CLASS__,
                                        'function' => __FUNCTION__,
                                        'message' => "Error adding patient to Onboarded queue: " . $e->getMessage(),
                                        'stack_trace' => $e,
                                    ];
                                    ErrorLog::logError($data);
                                    $request->session()->flash('error', 'Caregiver information was not created (Code: POQ-01).'); //Patient Onboarding Queue
                                    return redirect()->back();
                                }
                            } catch(QueryException $e)
                            {
                                //dd('link patient: ' . $e);
                                DB::rollBack();
                                $data = [
                                    'controller' => __CLASS__,
                                    'function' => __FUNCTION__,
                                    'message' => "Error creating caregiver's role: " . $e->getMessage(),
                                    'stack_trace' => $e,
                                ];
                                ErrorLog::logError($data);
                                $request->session()->flash('error', 'Caregiver information was not created (Code: PRI-01).'); //Patient Role Information
                                return redirect()->back();
                            }
                    } catch(QueryException $e)
                    {
                        //dd('patient contact information: ' . $e);
                        DB::rollBack();
                        $data = [
                            'controller' => __CLASS__,
                            'function' => __FUNCTION__,
                            'message' => "Error saving caregiver's contact information to table: " . $e->getMessage(),
                            'stack_trace' => $e,
                        ];
                        ErrorLog::logError($data);
                        $request->session()->flash('error', 'Caregiver information was not created (Code: PCI-01).'); //Patient Contact Information
                        return redirect()->back();
                    }
                } catch(QueryException $e)
                {
                    //dd('patient personal details: ' . $e);
                    DB::rollBack();
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error saving caregiver's personal details information to table: " . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    $request->session()->flash('error', 'Caregiver information was not created (Code: PDT-01).'); //Patient Personal Details
                    return redirect()->back();
                }
            } catch(QueryException $e)
            {
                //dd('didnt set user info: ' . $e);
                //user error
                DB::rollBack();
                
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error saving user information to table: " . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
                $request->session()->flash('error', 'Caregiver information was not created (Code: USI-01).'); //User Information
                return redirect()->back();
            }
        } catch(QueryException $e)
        {
            //dd('didnt commit changes: ' . $e);
            DB::rollBack();
            $data = [
                'controller' => __CLASS__,
                'function' => __FUNCTION__,
                'message' => "Error getting user id from uuid:" . $e->getMessage(),
                'stack_trace' => $e,
            ];
            ErrorLog::logError($data);
            $request->session()->flash('error', 'Caregiver information was not created. (Code: PID-01)');
            return redirect()->back();
        }
    }

    public function assignBPDeviceToPatient(Request $request, $id)
    {
        if (! Gate::allows('assign-bp-device-to-patient', Auth::user())) {
            abort(403);
        }

        if( empty($id) )
        {
            abort(404);
        } else {
            try{
                DB::beginTransaction();

                $role = Auth::user()->roles;
                $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

                $patient = User::where('_uid', $id)->get()[0];
                $patient_id = $patient->id;

                try{
                    $deviceToAssign = Device::getRandomUnassignedDevice(1);
                    //$deviceUUID = $deviceToAssign[0]->uid;
                    $deviceIMEI = $deviceToAssign[0]->imei;

                    $assignedDeviceRowUUID = Str::uuid();
                    try{
                        Assigneddevice::create([
                            '_uid' => $assignedDeviceRowUUID,
                            'device_unique_id' => $deviceIMEI,
                            'patient_user_id' => $patient_id,
                            'assigned_by_user_id' => Auth::user()->id
                        ]);

                        try{
                            DB::commit();
                            //session()->put('can_add_other_employee_info', true);
                            //session()->put('_id', $id);
                            $request->flash();
                            $request->session()->flash('success', 'Device was successfully assigned to patient.');
                            //dd('success');
                            //return redirect()->route('add-employee', ['id' => $employee_uid]);
                            return redirect()->route($roleSlug.'/onboard-patient', $id);
                            //return response()->json(['message' => 'Device was successfully assigned to patient.']);
                        } catch(QueryException $e)
                        {
                            //dd('didnt commit changes: ' . $e);
                            DB::rollBack();
                            $data = [
                                'controller' => __CLASS__,
                                'function' => __FUNCTION__,
                                'message' => "Error committing device assignment information:" . $e->getMessage(),
                                'stack_trace' => $e,
                            ];
                            ErrorLog::logError($data);
                            $request->session()->flash('error', 'Device assignment was not completed.');
                            return redirect()->back();
                            //return response()->json(['error' => 'Device assignment was not completed (Code: ADC-01).'], 422);
                        }
                    } catch( QueryException $e )
                    {
                        DB::rollBack();
                        $data = [
                            'controller' => __CLASS__,
                            'function' => __FUNCTION__,
                            'message' => "Error assigning device to patient:" . $e->getMessage(),
                            'stack_trace' => $e,
                        ];
                        ErrorLog::logError($data);
                        Log::error("Error assigning device to patient: " . $e->getMessage());
                        $request->session()->flash('error', 'Error assigning device to Patient (Code: ADP-01).'); //Assign device to Patient
                        return redirect()->back();
                        //return response()->json(['error' => 'Error assigning device to Patient (Code: ADP-01).'], 422);
                    }

                } catch( QueryException $e )
                {
                    DB::rollBack();
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error getting device to assign for patient:" . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    Log::error("Error getting device to assign for patient: " . $e->getMessage());
                    $request->session()->flash('error', 'Error retrieving Device to assign to Patient (Code: GDP-01).'); //Error getting device to assign to Patient
                    return redirect()->back();
                    //return response()->json(['error' => 'Error retrieving Device to assign to Patient (Code: GDP-01).'], 422);
                }

            } catch( QueryException $e )
            {
                DB::rollBack();
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error getting id of patient:" . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
                Log::error("Error getting patient id: " . $e->getMessage());
                $request->session()->flash('error', 'Error retrieving Patient information (Code: PID-01).'); //Patient ID not found
                return redirect()->back();
                //return response()->json(['error' => 'Error retrieving Patient information (Code: PID-01).'], 422);
            }
        }
    }

    public function insertOnboardingChecklistResponsesForPatient(OnboardingChecklistRequest $request, $id)
    {
        if (! Gate::allows('insert-onboarding-checklist-responses', Auth::user())) {
            abort(403);
        }

        if( empty($id) )
        {
            abort(404);
        } else {
            try{
                DB::beginTransaction();

                $role = Auth::user()->roles;
                $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

                $patient = User::where('_uid', $id)->get()[0];
                $patient_id = $patient->id;

                //dd($request->input());
                $submittedFields = $request->input();
                unset($submittedFields['_token']);
                $totalFields = count($submittedFields);
                $totalYes = 0;
                $completionPercentage = 0;
                foreach ($submittedFields as $key => $value) {
                    if( $value === "1" )
                        $totalYes++;
                }

                if( $totalFields === $totalYes )
                    $completionPercentage = 100;
                else{
                    $completionPercentage = ($totalYes/$totalFields)*100;
                }

                //dd($completionPercentage);

                try{
                    Onboardingchecklist::create([
                        'patient_contacted' => $request->input('patient_contacted'),
                        'service_explained_to_patient' => $request->input('service_explained_to_patient'),
                        'patient_user_id' => $patient_id,
                        'device_assigned_to_patient' => $request->input('device_assigned_to_patient'),
                        'patient_have_device' => $request->input('patient_have_device'),
                        'device_usage_explained_to_patient' => $request->input('device_usage_explained_to_patient'),
                    ]);

                    if( $completionPercentage === 100 ){
                        try{
                            $recordToUpdate = Onboarded::where('patient_id', $patient_id)->get();

                            try{
                                $recordToUpdate[0]->update([
                                    'onboarded' => 1,
                                    'date_onboarded' => Carbon::now(),
                                    'onboarded_by_user_id' => Auth::user()->id
                                ]);

                                try{
                                    DB::commit();
                                    //session()->put('can_add_other_employee_info', true);
                                    //session()->put('_id', $id);
                                    $request->flash();
                                    $request->session()->flash('success', 'Onboarding responses were successfully saved.');
                                    //dd('success');
                                    //return redirect()->route('add-employee', ['id' => $employee_uid]);
                                    return redirect()->route($roleSlug.'/onboard-patient', $id);
                                } catch(QueryException $e)
                                {
                                    DB::rollBack();
                                    $data = [
                                        'controller' => __CLASS__,
                                        'function' => __FUNCTION__,
                                        'message' => "Error committing onboarding responses:" . $e->getMessage(),
                                        'stack_trace' => $e,
                                    ];
                                    ErrorLog::logError($data);
                                    $request->session()->flash('error', 'Onboarding responses were not saved.');
                                    return redirect()->back();
                                }
                            } catch(QueryException $e)
                            {
                                DB::rollBack();
                                $data = [
                                    'controller' => __CLASS__,
                                    'function' => __FUNCTION__,
                                    'message' => "Error getting onboarded record:" . $e->getMessage(),
                                    'stack_trace' => $e,
                                ];
                                ErrorLog::logError($data);
                                Log::error("Error getting onboarded record: " . $e->getMessage());
                                $request->session()->flash('error', 'Error creating onboarding responses (Code: OPR-01).'); //Onboarded Response Error.
                                return redirect()->back();
                            }
                            
                        } catch(QueryException $e)
                        {
                            DB::rollBack();
                            $data = [
                                'controller' => __CLASS__,
                                'function' => __FUNCTION__,
                                'message' => "Error getting onboarded record:" . $e->getMessage(),
                                'stack_trace' => $e,
                            ];
                            ErrorLog::logError($data);
                            Log::error("Error getting onboarded record: " . $e->getMessage());
                            $request->session()->flash('error', 'Error creating onboarding responses (Code: OPR-01).'); //Onboarded Response Error.
                            return redirect()->back();
                        }
                    } else {
                        try{
                            DB::commit();
                            //session()->put('can_add_other_employee_info', true);
                            //session()->put('_id', $id);
                            $request->flash();
                            $request->session()->flash('success', 'Onboarding responses were successfully saved.');
                            //dd('success');
                            //return redirect()->route('add-employee', ['id' => $employee_uid]);
                            return redirect()->route($roleSlug.'/onboard-patient', $id);
                        } catch(QueryException $e)
                        {
                            DB::rollBack();
                            $data = [
                                'controller' => __CLASS__,
                                'function' => __FUNCTION__,
                                'message' => "Error committing onboarding responses:" . $e->getMessage(),
                                'stack_trace' => $e,
                            ];
                            ErrorLog::logError($data);
                            $request->session()->flash('error', 'Onboarding responses were not saved.');
                            return redirect()->back();
                        }
                    }
                } catch( QueryException $e )
                {
                    DB::rollBack();
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error creating onboarding responses:" . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    Log::error("Error creating onboarding responses: " . $e->getMessage());
                    $request->session()->flash('error', 'Error creating onboarding responses (Code: ORE-01).'); //Onboarding Response Error
                    return redirect()->back();
                }
            } catch( QueryException $e )
            {
                DB::rollBack();
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error getting id of patient:" . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
                Log::error("Error getting patient id: " . $e->getMessage());
                $request->session()->flash('error', 'Error retrieving Patient information (Code: PID-01).'); //Patient ID not found
                return redirect()->back();
            }
        }
    }

    public function getBPReadingsForAPatient($id)
    {
        if (! Gate::allows('view-bp-readings-for-a-patient', Auth::user())) {
            abort(403);
        }

        if( empty($id) )
        {
            abort(404);
        } else {
            try{
                DB::beginTransaction();

                $role = Auth::user()->roles;
                $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

                $patient = User::where('_uid', $id)->get()[0];
                $patient_id = $patient->id;
                $patient_name = $patient->first_name . " " . $patient->last_name;

                $bpStatuses = Bpreadingstatus::all();
                $lowCriticalUUID = $lowUUID = $withinRangeUUID = $highUUID = $highCriticalUUID = "";

                foreach ($bpStatuses as $key => $value) {
                    $_id = $value->id;
                    
                    if($_id === 1)
                        $lowCriticalUUID = $value->_uid;
                    
                    if($_id === 2)
                        $lowUUID = $value->_uid;
                    
                    if($_id === 3)
                        $withinRangeUUID = $value->_uid;
                    
                    if($_id === 4)
                        $highUUID = $value->_uid;
                    
                    if($_id === 5)
                        $highCriticalUUID = $value->_uid;
                }

                //$startDate = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()->format('Y-m-d')));
                $startDate = date('Y-m-d', strtotime('-1 month'));
                $endDate = Carbon::now()->toDateString();

                //$patientsBPReadings = Bpreading::getBPReadingsForPatient($patient_id);
                $mtdBpReadings = Bpreading::getBpReadingsForPatientByDateRange($patient_id, $startDate, $endDate );
                //dd($mtdBpReadings);
                $averageBPReading = Bpreading::getAverageBPReadingForAPatientByDateRange($patient_id, $startDate, $endDate);
                
                $lineGraphString = StringHelper::formatDataForLineGraphByDate($mtdBpReadings, $startDate, $endDate);
                //$lineGraphString2 = StringHelper::formatDataForLineGraphByDate2($mtdBpReadings, date('Y-m-d', strtotime('-1 month')), Carbon::now()->toDateString());
                //dd($mtdBpReadings);
                $hc = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 5, Carbon::now()->format('Y'));
                $h = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 4, Carbon::now()->format('Y'));
                $normal = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 3, Carbon::now()->format('Y'));
                $low = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 2, Carbon::now()->format('Y'));

                $average_bp_reading = number_format($averageBPReading[0]->average_systolic,0) .'/' . number_format($averageBPReading[0]->average_diastolic,0);
                $firstBPReading = Bpreading::getFirstBPReadingForAPatient($patient_id);

                $firstWeekBPAvg = 0;
                if( $firstBPReading !== null )
                {
                    $givenDate = Carbon::parse(date('Y-m-d', strtotime($firstBPReading[0]->first_reading_date)));
                    $dateOneWeekLater = $givenDate->addWeek();
                    $firstWeekBPAvg = Bpreading::getAverageBPReadingForAPatientByDateRange($patient_id, $givenDate->format('Y-m-d'), $dateOneWeekLater->format('Y-m-d'));
                }

                $levelOfControl = Patient::calculateLOCForAPatient($patient_id, 3, $startDate, $endDate);
                $adherenceRate = Patient::calculatePatienceAdherenceRate($patient_id, 3, $startDate, $endDate);
//dd($adherenceRate);
                $data = array(
                    'id' => $id,
                    'role_slug' => $roleSlug,
                    'viewTitle' => 'My Patients Readings',
                    'readings' => $mtdBpReadings,
                    //'line_graph_points' => $lineGraphString2[0],
                    'days' => $lineGraphString['days'],
                    'systolic_points' => $lineGraphString['systolic_values'],
                    'diastolic_points' => $lineGraphString['diastolic_values'],
                    'systolic_fill_colours' => $lineGraphString['systolic_fill_colours'],
                    'diastolic_fill_colours' => $lineGraphString['diastolic_fill_colours'],
                    'high_critical_readings' => $hc[0]->amount,
                    'high_readings' => $h[0]->amount,
                    'normal_readings' => $normal[0]->amount,
                    'low_readings' => $low[0]->amount,
                    'low_critical_uuid' => $lowCriticalUUID,
                    'low_uuid' => $lowUUID,
                    'within_range_uuid' => $withinRangeUUID,
                    'high_uuid' => $highUUID,
                    'high_critical_uuid' => $highCriticalUUID,
                    'patient_name' => $patient_name,
                    'average_bp_reading' => $average_bp_reading,
                    'average_bp_reading_text' => '30 day',
                    'time_period' => '30 days',
                    'firstWkBPAvg' => $firstWeekBPAvg,
                    'levelOfControlValue' => $levelOfControl['levelOfControlValue'],
                    'levelOfControlStatus' => $levelOfControl['levelOfControlStatus'],
                    'adherenceRate' => $adherenceRate
                );
                return view('patients.list-patients-bp-readings', $data);

            }catch(QueryException $e)
            {

            }
        }
    }

    public function getBPReadingDetailsForAPatient($id, $rID)
    {
        if (! Gate::allows('view-bp-reading-details-for-a-patient', Auth::user())) {
            abort(403);
        }

        if( empty($id) || empty($rID) )
        {
            abort(404);
        } else {
            try{

                $role = Auth::user()->roles;
                $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

                $patient = User::where('_uid', $id)->get()[0];
                $patient_id = $patient->id;
                $patient_name = $patient->first_name . " " . $patient->last_name;

                $bpStatuses = Bpreadingstatus::all();
                $lowCriticalUUID = $lowUUID = $withinRangeUUID = $highUUID = $highCriticalUUID = "";

                foreach ($bpStatuses as $key => $value) {
                    $_id = $value->id;
                    
                    if($_id === 1){
                        $lowCriticalUUID = $value->_uid;
                    }
                    
                    if($_id === 2){
                        $lowUUID = $value->_uid;
                    }
                    
                    if($_id === 3){
                        $withinRangeUUID = $value->_uid;
                    }
                    
                    if($_id === 4){
                        $highUUID = $value->_uid;
                    }
                    
                    if($_id === 5){
                        $highCriticalUUID = $value->_uid;
                    }
                }

                try{
                    $personal_info = User::getPatientOnboardingInformation($patient_id);
                } catch(QueryException $e)
                {
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error getting id of patient:" . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    Log::error("Error getting BP Target for patient: " . $e->getMessage());
                    $request->session()->flash('error', 'Error retrieving Patient information (Code: PID-01).'); //Patient ID not found
                    return redirect()->back();
                }

                try{
                    $specificReading = Bpreading::getSpecificReadingForAPatient($patient_id, $rID);
                    try{
                        $readingDetails = $specificReading[0];

                        $hc = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 5, Carbon::now()->format('Y'));
                        $h = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 4, Carbon::now()->format('Y'));
                        $normal = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 3, Carbon::now()->format('Y'));
                        $low = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 2, Carbon::now()->format('Y'));
                        $invalidatingReasons = Invalidatebpreason::get();
                        $invalidateActions = Invalidatebpreasonaction::get();
                        //dd($invalidatingReasons);
                        $data = array(
                            'id' => $id,
                            'role_slug' => $roleSlug,
                            'viewTitle' => 'Patient\'s Reading Details',
                            'high_critical_readings' => $hc[0]->amount,
                            'high_readings' => $h[0]->amount,
                            'normal_readings' => $normal[0]->amount,
                            'low_readings' => $low[0]->amount,
                            'low_critical_uuid' => $lowCriticalUUID,
                            'low_uuid' => $lowUUID,
                            'within_range_uuid' => $withinRangeUUID,
                            'high_uuid' => $highUUID,
                            'high_critical_uuid' => $highCriticalUUID,
                            'patient_name' => $patient_name,
                            'specific_reading' => $readingDetails,
                            'invalidingReasongs' => $invalidatingReasons,
                            'invalidate_reason_id' => null,
                            'invalidateActions' => $invalidateActions
                        );
                        return view('patients.bp-reading-details', $data);
                        
                    } catch(Exception $e)
                    {
                        
                        $data = [
                            'controller' => __CLASS__,
                            'function' => __FUNCTION__,
                            'message' => "Error getting reading for patient:" . $e->getMessage(),
                            'stack_trace' => $e,
                        ];
                        ErrorLog::logError($data);
                        Log::error("Error getting reading for patient: " . $e->getMessage());
                        //$request->session()->flash('error', 'Error retrieving reading for Patient (Code: PRD-01).'); //Patient's reading details
                        return back()->withErrors('Error retrieving reading for Patient (Code: SRD-01).'); //specific reading details
                    }
                    
                }catch(QueryException $e)
                {
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error getting reading for patient:" . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    Log::error("Error getting reading for patient: " . $e->getMessage());
                    //$request->session()->flash('error', 'Error retrieving reading for Patient (Code: PRD-01).'); //Patient's reading details
                    return back()->withErrors('Error retrieving reading for Patient (Code: PRD-01).');
                }
            }catch(QueryException $e)
            {
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error getting reading for patient:" . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
                Log::error("Error getting reading for patient: " . $e->getMessage());
                //$request->session()->flash('error', 'Error retrieving reading for Patient (Code: PRD-01).'); //Patient's reading details
                return back()->withErrors('Error retrieving reading for Patient (Code: PRD-01).');
            }
        }
    }

    public function updatePatientBPGraph($id, Request $request)
    {
        if (! Gate::allows('update-patients-bp-graph', Auth::user())) {
            abort(403);
        }

        if( empty($id) )
        {
            abort(404);
        } else {
            try{
                DB::beginTransaction();

                $role = Auth::user()->roles;
                $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

                $patient = User::where('_uid', $id)->get()[0];
                $patient_id = $patient->id;
                $patient_name = $patient->first_name . " " . $patient->last_name;

                $bpStatuses = Bpreadingstatus::all();
                $lowCriticalUUID = $lowUUID = $withinRangeUUID = $highUUID = $highCriticalUUID = "";

                foreach ($bpStatuses as $key => $value) {
                    $_id = $value->id;
                    
                    if($_id === 1)
                        $lowCriticalUUID = $value->_uid;
                    
                    if($_id === 2)
                        $lowUUID = $value->_uid;
                    
                    if($_id === 3)
                        $withinRangeUUID = $value->_uid;
                    
                    if($_id === 4)
                        $highUUID = $value->_uid;
                    
                    if($_id === 5)
                        $highCriticalUUID = $value->_uid;
                }

                $option = $request->input('option');
                $today = Carbon::now();

                switch ($option) {
                    case '1w':
                        $startDate = date('Y-m-d', strtotime('-1 week'));
                        $endDate = Carbon::now()->toDateString();
                        $noOfDays = '7 days'; //Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime('-1 week')))->diffInDays($endDate);
                        $average_bp_reading_text = '7 day';
                        break;

                    case 'mtd':
                        $startDate = date('Y-m-d', strtotime($today->startOfMonth()->format('Y-m-d')));
                        $endDate = Carbon::now()->toDateString();
                        $_noOfDays = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($today->startOfMonth()->format('Y-m-d'))))->diffInDays($endDate);
                        $noOfDays = $_noOfDays . ' days';
                        $average_bp_reading_text = $_noOfDays.' day';
                        break;

                    case '1m':
                        $startDate = date('Y-m-d', strtotime('-1 month'));
                        $endDate = Carbon::now()->toDateString();
                        $noOfDays = '30 days';
                        $average_bp_reading_text = '30 day';
                        break;

                    case '3m':
                        $startDate = date('Y-m-d', strtotime('-3 month'));
                        $endDate = Carbon::now()->toDateString();
                        $noOfDays =  ' 3 mths';
                        $average_bp_reading_text = ' 3 mth';
                        break;

                    // case '6m':
                    //     $startDate = date('Y-m-d', strtotime('-6 month'));
                    //     $endDate = Carbon::now()->toDateString();
                    //     $noOfDays =  ' 6 mths';
                    //     $average_bp_reading_text = ' 6 mth';
                    //     break;

                    // case 'ytd':
                    //     $startDate = date('Y-m-d', strtotime($today->startOfYear()));
                    //     $endDate = Carbon::now()->toDateString();
                    //     $_noOfDays = Carbon::createFromFormat('Y-m-d', $startDate)->diffInDays($endDate);
                    //     $noOfDays = $_noOfDays . ' days';
                    //     $average_bp_reading_text = $_noOfDays.' day';
                    //     break;

                    // case '1y':
                    //     $startDate = date('Y-m-d', strtotime('-1 year'));
                    //     $endDate = Carbon::now()->toDateString();
                    //     $noOfDays = ' year';
                    //     $average_bp_reading_text = '1 year';
                    //     break;
                    
                    default:
                        # code...
                        break;
                }

                //$patientsBPReadings = Bpreading::getBPReadingsForPatient($patient_id);
                $mtdBpReadings = Bpreading::getBpReadingsForPatientByDateRange($patient_id, $startDate, $endDate );
                $averageBPReading = Bpreading::getAverageBPReadingForAPatientByDateRange($patient_id, $startDate, $endDate);
                
                $updatedData = StringHelper::formatDataForLineGraphByDate($mtdBpReadings, $startDate, $endDate);
                //$lineGraphString2 = StringHelper::formatDataForLineGraphByDate2($mtdBpReadings, date('Y-m-d', strtotime($timePeriod)), Carbon::now()->toDateString());
                //dd($lineGraphString[0]);
                $hc = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 5, Carbon::now()->format('Y'));
                $h = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 4, Carbon::now()->format('Y'));
                $normal = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 3, Carbon::now()->format('Y'));
                $low = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 2, Carbon::now()->format('Y'));
//dd($mtdBpReadings);
                $average_bp_reading = number_format($averageBPReading[0]->average_systolic,0) .'/' . number_format($averageBPReading[0]->average_diastolic,0);
                
                
                $updatedData['readings'] = $mtdBpReadings;
                $updatedData['average_bp_reading'] = $average_bp_reading;
                $updatedData['average_bp_reading_text'] = $average_bp_reading_text;
                $updatedData['no_of_days'] = $noOfDays;

                return response()->json($updatedData);
                //echo "<pre>";print_r($mtdBpReadings);exit;

            }catch(QueryException $e)
            {

            }
        }
    }

    public function getBPReadingsForAPatientByStatusId($id, $status)
    {
        if (! Gate::allows('view-bp-readings-for-a-patient-by-status', Auth::user())) {
            abort(403);
        }

        if( empty($id) || empty($status) )
        {
            abort(404);
        } else {
            try{
                DB::beginTransaction();

                $role = Auth::user()->roles;
                $roleSlug = ($role[0]->slug == 'super-admin') ? 'admin' : $role[0]->slug;

                try{
                    $patient = User::where('_uid', $id)->get()[0];
                    $patient_id = $patient->id;
                    $patient_name = $patient->first_name . " " . $patient->last_name;

                    try{
                        $statusRow = Bpreadingstatus::where('_uid', $status)->get()[0];
                        $statusId = $statusRow->id;

                        $bpStatuses = Bpreadingstatus::all();
                        $lowCriticalUUID = $lowUUID = $withinRangeUUID = $highUUID = $highCriticalUUID = "";

                        foreach ($bpStatuses as $key => $value) {
                            $_id = $value->id;
                            
                            if($_id === 1)
                                $lowCriticalUUID = $value->_uid;
                            
                            if($_id === 2)
                                $lowUUID = $value->_uid;
                            
                            if($_id === 3)
                                $withinRangeUUID = $value->_uid;
                            
                            if($_id === 4)
                                $highUUID = $value->_uid;
                            
                            if($_id === 5)
                                $highCriticalUUID = $value->_uid;
                        }

                        try{
                            $patientsBPReadings = Bpreading::getBPReadingsForPatient($patient_id, $statusId);
    
                            $hc = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 5, Carbon::now()->format('Y'));
                            $h = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 4, Carbon::now()->format('Y'));
                            $normal = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 3, Carbon::now()->format('Y'));
                            $low = Patient::countSystolicBPReadingsByStatusForPatient($patient_id, 2, Carbon::now()->format('Y'));
            //dd($patientsBPReadings);
                            $data = array(
                                'id' => $id,
                                'viewTitle' => 'My Patients Readings',
                                'readings' => $patientsBPReadings,
                                'high_critical_readings' => $hc[0]->amount,
                                'high_readings' => $h[0]->amount,
                                'normal_readings' => $normal[0]->amount,
                                'low_readings' => $low[0]->amount,
                                'low_critical_uuid' => $lowCriticalUUID,
                                'low_uuid' => $lowUUID,
                                'within_range_uuid' => $withinRangeUUID,
                                'high_uuid' => $highUUID,
                                'high_critical_uuid' => $highCriticalUUID,
                                'patient_name' => $patient_name
                            );
                            return view('patients.list-patients-bp-readings-by-status', $data);
                        } catch(QueryException $e)
                        {
            
                        }
                    } catch(QueryException $e)
                    {
        
                    }
                } catch(QueryException $e)
                {
    
                }
            }catch(QueryException $e)
            {

            }
        }
    }

    public function getBPDataDDLYearsForPatient(Request $request)
    {
        if (! Gate::allows('get-years-from-patient-data', Auth::user())) {
            abort(403);
        }

        if( empty($request) )
        {
            abort(404);
        } else {

            $patient = User::where('_uid', $request->input('_patient_id'))->get()[0];
            $patient_id = $patient->id;

            $yearsDDL = Patient::getBPDataYearsDDL($patient_id);

            return response()->json([
                'success' => true,
                'data' => $yearsDDL
            ]);
        }
    }
}
