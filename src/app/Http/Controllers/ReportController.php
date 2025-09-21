<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Patient;
use App\Models\Bpreading;
use App\Models\Physician;
use App\Models\SMSHelper;
use App\Models\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    public function getSMSSentByAnAgent()
    {
        if (!Gate::allows('view-reports', Auth::user()) && !Gate::allows('view-sms-sent-by-an-agent-report', Auth::user())) {
            abort(403);
        }

        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $roleSlug = ($slug == 'super-admin') ? 'admin' : $slug;

        switch($roleSlug)
        {
            case 'admin':
                $smsSent = SMSHelper::getAllSMSSentByAnAgent(null, null);
                break;

            // case 'sales-executive':
            //     $patients = Patient::getPhysiciansPatientsDDL(Auth::user()->id);
            //     break;
        }

        $agents = User::getAllAgents(1);

        $breadcrumbs = array(
            ['path' => $roleSlug . '/reports', 'crumb' => 'All Reports'],
            ['path' => $roleSlug . '/reports/sms-sent-by-agent', 'crumb' => 'SMS Sent By Agent']
        );

        $data = array(
            'role_slug' => $roleSlug,
            'breadcrumbs' => $breadcrumbs,
            'smsSent' => $smsSent,
            'agents' => $agents,
            'agent_id' => null,
            'status' => null
        );

        return view('reports.sms-sent-by-agent', $data);
    }


    public function getSMSSentReport(Request $request)
    {
        if (!Gate::allows('view-reports', Auth::user()) && !Gate::allows('view-sms-sent-report', Auth::user())) {
            abort(403);
        }

        $role = Auth::user()->roles;
        $slug = $role[0]->slug;
        $roleSlug = ($slug == 'super-admin') ? 'admin' : $slug;

        // Get filter parameters
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $agentId = $request->get('agent_id');
        $templateType = $request->get('template_type');
        $status = $request->get('status');

        // Build query
        $query = DB::table('sms_logs')
            ->leftJoin('clients', 'sms_logs.client_id', '=', 'clients.id')
            ->leftJoin('users', 'sms_logs.sent_by', '=', 'users.id')
            ->select(
                'sms_logs.*',
                'clients.first_name as client_first_name',
                'clients.last_name as client_last_name',
                'users.first_name as agent_first_name',
                'users.last_name as agent_last_name'
            );

        // Apply filters based on role
        switch($roleSlug) {
            case 'admin':
                // Admin can see all SMS logs
                break;
            case 'sales-executive':
                // Sales executive can only see their own SMS
                $query->where('sms_logs.sent_by', Auth::user()->id);
                break;
            default:
                // Other roles see their own SMS
                $query->where('sms_logs.sent_by', Auth::user()->id);
        }

        // Apply date filters
        if ($dateFrom) {
            $query->whereDate('sms_logs.created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('sms_logs.created_at', '<=', $dateTo);
        }

        // Apply agent filter (only for admin)
        if ($agentId && $roleSlug == 'admin') {
            $query->where('sms_logs.sent_by', $agentId);
        }

        // Apply template type filter
        if ($templateType) {
            $query->where('sms_logs.template_type', $templateType);
        }

        // Apply status filter
        if ($status) {
            $query->where('sms_logs.status', $status);
        }

        // Get paginated results
        $smsLogs = $query->orderBy('sms_logs.created_at', 'desc')
            ->paginate(25)
            ->withQueryString();

        // Add relationships to the paginated results
        $smsLogs->getCollection()->transform(function ($log) {
            // Create objects for easier access in blade
            $log->client = null;
            if ($log->client_first_name || $log->client_last_name) {
                $log->client = (object) [
                    'first_name' => $log->client_first_name,
                    'last_name' => $log->client_last_name,
                    'id' => $log->client_id
                ];
            }

            $log->sentBy = null;
            if ($log->agent_first_name || $log->agent_last_name) {
                $log->sentBy = (object) [
                    'first_name' => $log->agent_first_name,
                    'last_name' => $log->agent_last_name,
                    'id' => $log->sent_by
                ];
            }

            // Convert created_at to Carbon instance
            $log->created_at = $log->created_at ? Carbon::parse($log->created_at) : null;

            return $log;
        });

        // Get summary statistics
        $summaryQuery = DB::table('sms_logs')
            ->leftJoin('clients', 'sms_logs.client_id', '=', 'clients.id');

        // Apply same role-based filtering for summary
        switch($roleSlug) {
            case 'admin':
                break;
            case 'sales-executive':
                $summaryQuery->where('sms_logs.sent_by', Auth::user()->id);
                break;
            default:
                $summaryQuery->where('sms_logs.sent_by', Auth::user()->id);
        }

        // Apply same filters for summary
        if ($dateFrom) {
            $summaryQuery->whereDate('sms_logs.created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $summaryQuery->whereDate('sms_logs.created_at', '<=', $dateTo);
        }
        if ($agentId && $roleSlug == 'admin') {
            $summaryQuery->where('sms_logs.sent_by', $agentId);
        }
        if ($templateType) {
            $summaryQuery->where('sms_logs.template_type', $templateType);
        }
        if ($status) {
            $summaryQuery->where('sms_logs.status', $status);
        }

        $summary = [
            'total' => $summaryQuery->count(),
            'sent' => $summaryQuery->where('sms_logs.status', 'sent')->count(),
            'failed' => $summaryQuery->where('sms_logs.status', 'failed')->count(),
            'pending' => $summaryQuery->where('sms_logs.status', 'pending')->count(),
        ];

        // Get agents list (for admin only)
        $agents = collect();
        if ($roleSlug == 'admin') {
            // $agents = User::whereHas('roles', function($q) {
            //     $q->whereIn('name', ['sales-executive', 'admin']);
            // })->select('id', 'first_name', 'last_name')->get();
            $agents = User::getAllAgents(1);
        }

        $breadcrumbs = [
            ['path' => $roleSlug . '/reports', 'crumb' => 'All Reports'],
            ['path' => $roleSlug . '/reports/sms-sent-report', 'crumb' => 'SMS Report']
        ];

        $data = [
            'role_slug' => $roleSlug,
            'breadcrumbs' => $breadcrumbs,
            'smsLogs' => $smsLogs,
            'agents' => $agents,
            'summary' => $summary,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'agent_id' => $agentId,
                'template_type' => $templateType,
                'status' => $status
            ]
        ];

        return view('reports.sms-sent-by-agent', $data);
    }
}