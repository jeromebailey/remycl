<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Patient;
use App\Models\ErrorLog;
//use Illuminate\Foundation\Auth\User;
use DivisionByZeroError;
use App\Models\AppMailer;
use App\Models\Bgreading;
use App\Models\Bpreading;
use App\Models\Physician;
use App\Models\SMSHelper;
use App\Models\RPMService;
use App\Models\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Traits\HasRolesAndPermissions;
use App\Models\Client;
use App\Notifications\PolicyExpiringNotification;

class DashboardController extends Controller
{
    //use HasRolesAndPermissions;

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function adminDashboard()
    {
        if (! Gate::allows('view-admin-dashboard', Auth::user())) {
            abort(403);
        }

        // $role = Auth::user()->roles;
        // $roleSlug = $role[0]->slug;

        $client = Client::find(1);
        //dd($client[0]);
        // try{
        //     $client->notify(new PolicyExpiringNotification($client, 'test'));
        // } catch(Exception $e){
        //     dd($e->getMessage());
        // }
        
        $roleSlug = User::getRoleSlugForUser();

        $expiredPolicies = Client::expiredClientPoliciesForUser($roleSlug);

        $breadcrumbs = array([
            'path' => '',
            'crumb' => 'Dashboard'
            ]
        );
        
        //dd($maleServiceUsers);
        $data = array(
            'expired_policies' => $expiredPolicies,
            'role_slug' => $roleSlug,
            'breadcrumbs' => $breadcrumbs
        );

        return view('dashboard/dashboard', $data);
    }

    public function salesExecDashboard()
    {//dd(Auth::user()->roles->permissions);
        if (!Gate::allows('view-sales-exec-dashboard', Auth::user())) {
            abort(403);
        }     

        $role = Auth::user()->roles;
        $roleSlug = $role[0]->slug;

        $expiredPolicies = Client::expiredClientPolicies();

        $breadcrumbs = array([
            'path' => '',
            'crumb' => 'Dashboard'
            ]
        );
        
        //dd($maleServiceUsers);
        $data = array(
            'expired_policies' => $expiredPolicies,
            'role_slug' => $roleSlug,
            'breadcrumbs' => $breadcrumbs
        );

        return view('dashboard/dashboard', $data);
    }
}
