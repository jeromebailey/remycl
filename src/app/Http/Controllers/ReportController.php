<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Bpreading;
use App\Models\Client;
use App\Models\Physician;
use App\Models\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    //

    public function index()
    {
        if (! Gate::allows('view-reports', Auth::user())) {
            abort(403);
        }

        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = ($slug == 'super-admin') ? 'admin' : $slug;

        $data = array(
            'role_slug' => $roleSlug
        );
        
        return view('reports.reports-list', $data);
    }

    public function getClientsWithPoliciesExpiring()
    {
        if (!Gate::allows('view-reports', Auth::user()) && !Gate::allows('view-policies-expiring-report', Auth::user())) {
            abort(403);
        }

        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = User::getRoleSlugForUser();

        $records = Client::getClientsWithPoliciesExpiring(null);

        $breadcrumbs = array(
            ['path' => $roleSlug . '/reports', 'crumb' => 'All Reports'],
            ['path' => $roleSlug . '/reports/policies-expiring', 'crumb' => 'Clients with expiring Policies']
        );

        $data = array(
            'records' => $records,
            'role_slug' => $roleSlug,
            'breadcrumbs' => $breadcrumbs,
            'selected_days' => null
        );
        
        return view('reports.clients-with-policies-expiring', $data);
    }

    public function doGetClientsWithPoliciesExpiring(Request $request)
    {
        if (!Gate::allows('view-reports', Auth::user()) && !Gate::allows('view-policies-expiring-report', Auth::user())) {
            abort(403);
        }

        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = User::getRoleSlugForUser();

        $days = $request->input('expires-in');

        $records = Client::getClientsWithPoliciesExpiring($days);

        $breadcrumbs = array(
            ['path' => $roleSlug . '/reports', 'crumb' => 'All Reports'],
            ['path' => $roleSlug . '/reports/policies-expiring', 'crumb' => 'Clients with expiring Policies']
        );

        $data = array(
            'records' => $records,
            'role_slug' => $roleSlug,
            'breadcrumbs' => $breadcrumbs,
            'selected_days' => $days
        );
        
        return view('reports.clients-with-policies-expiring', $data);
    }

    public function getAverageMonthlyBPReadingsForAPatient()
    {
        if (!Gate::allows('view-reports', Auth::user()) && !Gate::allows('view-avg-monthly-bp-reading-for-a-patient-report', Auth::user())) {
            abort(403);
        }

        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = ($slug == 'super-admin') ? 'admin' : $slug;

        switch($roleSlug)
        {
            case 'admin':
            case 'nurse':
                $patients = Patient::getAllPatients();
                break;

            case 'physician':
                $patients = Patient::getPhysiciansPatientsDDL(Auth::user()->id);
                break;
        }

        
        $breadcrumbs = array(
            ['path' => $roleSlug . '/reports', 'crumb' => 'All Reports'],
            ['path' => $roleSlug . '/reports/avg-monthly-bp-reading-for-a-patient', 'crumb' => 'Avg Monthly BP Readings For A Patient']
        );

        $data = array(
            'records' => null,
            'role_slug' => $roleSlug,
            'breadcrumbs' => $breadcrumbs,
            'patients' => $patients,
            'graph_data' => null,
            'patient_id' => null,
            'selected_year' => 0,
            'yearsDDL' => null
        );

        return view('reports.avg-monthly-bp-reading-for-a-patient', $data);
    }

    public function doGetAverageMonthlyBPReadingsForAPatient(Request $request)
    {
        if (!Gate::allows('view-reports', Auth::user()) && !Gate::allows('view-avg-monthly-bp-reading-for-a-patient-report', Auth::user())) {
            abort(403);
        }

        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = ($slug == 'super-admin') ? 'admin' : $slug;

        $breadcrumbs = array(
            ['path' => $roleSlug . '/reports', 'crumb' => 'All Reports'],
            ['path' => $roleSlug . '/reports/avg-monthly-bp-reading-for-a-patient', 'crumb' => 'Avg Monthly BP Readings For A Patient']
        );

        $patient = User::where('_uid', $request->input('patient-name'))->get()[0];
        $patient_id = $patient->id;

        $yearsDDL = Patient::getBPDataYearsDDL($patient_id);
        $records = Bpreading::getAverageMonthlyBPReadingByYearForAPatient($patient_id, $request->input('year'));

        $graph_data = StringHelper::formatBarGraphStringForAvgBPMonthlyReadingByYear($records);
        $patients = Patient::getPhysiciansPatientsDDL(Auth::user()->id);

        $data = array(
            'records' => $records,
            'role_slug' => $roleSlug,
            'breadcrumbs' => $breadcrumbs,
            'patients' => $patients,
            'graph_data' => $graph_data,
            'patient_id' => $request->input('patient-name'),
            'selected_year' => $request->input('year'),
            'yearsDDL' => $yearsDDL
        );

        return view('reports.avg-monthly-bp-reading-for-a-patient', $data);
    }
}