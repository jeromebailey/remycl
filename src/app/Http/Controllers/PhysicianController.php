<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Bpreading;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PhysicianController extends Controller
{
    //

    public function getBPReadingsForAllPhysiciansPatients()
    {
        if (! Gate::allows('view-bp-readings-for-physicians-patients', Auth::user())) {
            abort(403);
        }

        $id = Auth::user()->id;
        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $myPatientsBPReadings = Bpreading::getBPReadingsForPhysiciansPatients($id);
        // $averageReadingsForPatient = Bpreading::getAverageBPReadingForPatientByYear($id, Carbon::now()->format('Y'));
        //dd($myPatientsBPReadings);

        $data = array(
            'viewTitle' => 'My Patients Readings',
            'patients_readings' => $myPatientsBPReadings
        );
        return view('patients.list-physicians-patients-bp-readings', $data);
    }
}
