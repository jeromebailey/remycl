<?php

namespace App\Http\Controllers\Auth;

//use App\Models\AppException;
use App\Models\User;
//use App\Models\Useraccesslog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login() {

        if (Auth::user()) {
            dd('logged in');
            return redirect()->route('test-page');
        } else {
            return view('auth.login');
        }
        
        //dd($user->hasRole('author')); // will return true
        //dd($user->hasRole('project-manager'));// will return false
        //dd($user->givePermissionsTo('manage-users'));
        //dd($user->hasPermission('manage-users'));
        //dd('login');
        
    }

    public function do_login(Request $request)
    {
        

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($request->only('email', 'password'), $request->remember)){
            //Useraccesslog::logUserAction(Auth::user()->id, 'logged-in', 'attempted login');
            //AppException::logException(__CLASS__, __METHOD__, 'Invalid credentials entered for login: ' . $request->email . ' -- ' . $request->password);
            return back()->with('login-error', 'Invalid login credentials entered!');
        }

        $colourArray = array(
            'c8080c', '158538', '88e1f9', '0155dc', 'a7c49a', '8a5949', 'e82978', '5680ad', '6a3039', '7002af'
        );
        $randomIndex = array_rand($colourArray);
        $randomColor = '#' . $colourArray[$randomIndex];
        Session::put('emptyProfileImageBGColour', $randomColor);
        
        $role = Auth::user()->roles;
        $slug = $role[0]->slug;

        $dashboardRoute = User::determineDashboardFromRole($slug);
// dd($slug);
// dd($dashboardRoute);
        //Useraccesslog::logUserAction(Auth::user()->id, 'logged-in');
        return redirect()->route($dashboardRoute);
    }
}