<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Bgreading;
use App\Models\Bpreading;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReadingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except(['patientsBPReadings', 'patientsBGReadings']);
    }

    public function patientsBPReadings(Request $request)
    {
        try{
            
            // Validate the payload
            $data = $this->validate($request, [
                'deviceId' => 'required|integer',
                'readingType' => 'required|string|in:BloodPressure',
                'time' => 'required|numeric',
                'data.systolic' => 'required|integer|min:0',
                'data.diastolic' => 'required|integer|min:0',
                'data.pulse' => 'required|integer|min:0',
                'data.arrhythmia' => 'required|integer|in:0,1',
            ]);
            
            try{
                Bpreading::create([
                    '_uid' => Str::uuid(),
                    'patient_id' => 103,
                    'device_id' => $request->input('deviceId'),
                    'time' => $request->input('time'),
                    'systolic' => $request->input('data.systolic'),
                    'diastolic' => $request->input('data.diastolic'),
                    'pulse' => $request->input('data.pulse'),
                    'arrhythmia' => $request->input('data.arrhythmia'),
                ]);

                return response()->json(['message' => 'Reading saved successfully']);
            } catch(ValidationException $e)
            {
                return response()->json($e->errors(), 422);
            }

        } catch(ValidationException $e)
        {
            return response()->json($e->errors(), 422);
        }
    }

//     public function patientsBPReadings(Request $request)
//     {
//         try{
//             // $this->validate($request, [
//             //     'deviceId' => 'required|uuid',
//             //     'readingType' => 'required|string',
//             //     'time' => 'required|numeric',
//             //     'data.systolic' => 'required|numeric',
//             //     'data.diastolic' => 'required|numeric',
//             //     'data.pulse' => 'required|numeric',
//             //     'data.arrhythmia' => 'required|integer',
//             // ]);
            
//             // Validate the payload
//             $data = $request->validate([
//                 'deviceId' => 'required|uuid',
//                 'readingType' => 'required|string',
//                 'time' => 'required|numeric',
//                 'data.systolic' => 'required|numeric',
//                 'data.diastolic' => 'required|numeric',
//                 'data.pulse' => 'required|numeric',
//                 'data.arrhythmia' => 'required|integer',
//             ]);

//             try{
//                 $assignedDevice = Assigneddevice::where('device_unique_id', $request->deviceId)->get();
//                 //dd($assignedDevice[0]->patient_user_id);
//                 $patientId = $assignedDevice[0]->patient_user_id;
// //dd($patientId);
//                 try{
//                     Bpreading::create([
//                         '_uid' => Str::uuid(),
//                         'patient_id' => $patientId,
//                         'device_id' => $request->deviceId,
//                         'systolic' => $request->data['systolic'],
//                         'diastolic' => $request->data['diastolic'],
//                         'pulse' => $request->data['pulse'],
//                         'arrhythmia' => $request->data['arrhythmia'],
//                     ]);

//                     return response()->json(['message' => 'Reading saved successfully']);
//                 } catch(ValidationException $e)
//                 {
//                     return response()->json($e->errors(), 422);
//                 }

//             } catch(ValidationException $e)
//             {
//                 return response()->json($e->errors(), 422);
//             }
//         } catch(ValidationException $e)
//         {
//             return response()->json($e->errors(), 422);
//         }
//     }

    public function patientsBGReadings(Request $request)
    {
        try{
            // Validate the payload
            $data = $this->validate($request, [
                'deviceId' => 'required|integer',
                'readingType' => 'required|string|in:BloodGlucose',
                'time' => 'required|numeric',
                'data.glucose' => 'required|integer|min:0',
                'data.readingPeriod' => 'required|string|in:before,after',
            ]);

            try{
                Bgreading::create([
                    '_uid' => Str::uuid(),
                    'patient_id' => 104,
                    'device_id' => $request->input('deviceId'),
                    'glucose' => $request->input('data.glucose'),
                    'readingPeriod' => $request->input('data.readingPeriod'),
                    'time' => $request->input('time'),
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

        dd(auth()->user()->id);

        try{
            $readings = Bpreading::getBPReadingsForPatient(auth()->user()->id);
            //dd($readings);
            $data = array(
                'viewTitle' => 'My Readings',
                'readings' => $readings
            );
            return view('patients.list-patients-own-br-readings', $data);
        } catch(Exception $e)
        {
            dd('cant get readings');
        }
    }
}
