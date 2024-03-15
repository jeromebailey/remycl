<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\ErrorLog;
use Illuminate\Support\Str;
use App\Models\StringHelper;
use Illuminate\Http\Request;
use App\Models\Useraccesslog;
use App\Models\DatabaseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('view-all-health-e-users', Auth::user())) {
            abort(403);
        }

        $allUsers = User::getAllHealthEUsers();

        // $currentPage = Paginator::resolveCurrentPage();
        // $perPage = env('DEFAULT_PAGINATION_AMOUNT');

        // $allUsers = collect(User::getAllUsers());

        // $paginatedUsers = new LengthAwarePaginator(
        //     $allUsers->forPage($currentPage, $perPage),
        //     $allUsers->count(),
        //     $perPage,
        //     $currentPage,
        //     ['path' => Paginator::resolveCurrentPath()]
        // );

        $data = array(
            'viewTitle' => 'All Users',
            'all_users' => $allUsers
        );
        return view('users.all_users', $data);
    }

    public function add_user(){
        //abort_unless(\Gate::allows('add-user'), code:403);
        //DatabaseHelper::insert_row_identifier_for_table('roles');
        if (! Gate::allows('add-user', Auth::user())) {
            abort(403);
        }

        Useraccesslog::logUserAction(Auth::user()->id, 'viewed', 'add users page');

        $roles = Role::all();

        $data = array(
            'viewTitle' => 'Add User',
            'roles' => $roles
        );
        return view('users.add-user', $data);
    }

    public function do_add_user(Request $request){

        if (! Gate::allows('add-user', Auth::user())) {
            abort(403);
        }
        
        $this->validate($request, [
            'role_id' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed'
        ]);
        //dd($request);
        //dd(DatabaseHelper::generate_row_identifier_for_table('users'));
        //creates a new instance of the UserModel Object and saves the data
        DB::beginTransaction();
        try{
            $user_object = User::create([
                '_uid' => Str::uuid()->toString(),
                'first_name' => StringHelper::sanitizeString($request->first_name),
                'last_name' => StringHelper::sanitizeString($request->last_name),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'active' => 1,
            ]);

            Useraccesslog::logUserAction(Auth::user()->id, 'added', 'user: ' . $request->first_name . ' ' . $request->last_name . ' ' . $request->email);

            try{
                $role_id = DatabaseHelper::getTableKeyFromRowIdentifier('roles', $request->role_id);

                try{
                    $user_object->roles()->attach($role_id);
                    DB::commit();
                    return redirect()->route('users')->with('success', 'User was successfully created!');
                } catch(QueryException $e){
                    DB::rollBack();
                    $data = [
                        'controller' => __CLASS__,
                        'function' => __FUNCTION__,
                        'message' => "Error attaching role to user:" . $e->getMessage(),
                        'stack_trace' => $e,
                    ];
                    ErrorLog::logError($data);
                    return back()->with('error', 'Error creating user (Code: URE -01)'); //Error attaching role to user
                }
            } catch(QueryException $e){
                DB::rollBack();
                $data = [
                    'controller' => __CLASS__,
                    'function' => __FUNCTION__,
                    'message' => "Error getting PK from uid (role):" . $e->getMessage(),
                    'stack_trace' => $e,
                ];
                ErrorLog::logError($data);
                return back()->with('error', 'Error creating user (Code: RIE-01)'); //Error getting id from uid for role
            }
        } catch(QueryException $e){
            DB::rollBack();
            //add code for logging exceptions
            $data = [
                'controller' => __CLASS__,
                'function' => __FUNCTION__,
                'message' => "Error creating user:" . $e->getMessage(),
                'stack_trace' => $e,
            ];
            ErrorLog::logError($data);
            return back()->with('error', 'Error creating user (Code: UEC-01)'); //Error creating user
        }
    }

    // public function edit_user($key){
    //     Gate::define('edit-user', function($user){
    //         return $user->roleHasPermission('edit-user');
    //     });

    //     Useraccesslog::logUserAction(Auth::user()->id, 'viewed', 'update users page');

    //     if( $key != null ){
    //         $record = User::where('row_identifier', $key)->firstorfail();
    //         $roles = Role::all();
    //         $user_object = User::find($record->id);
    //         //dd($user_object->roles()->get()[0]->row_identifier);
    //         $data = array(
    //             'user' => $record,
    //             'viewTitle' => 'Edit User',
    //             'roles' => $roles,
    //             'assigned_role_id_hash' => (count($user_object->roles()->get()) == 0) ? null : $user_object->roles()->get()[0]->row_identifier
    //         );

    //         return view('admin.users.edit-user', $data);
    //     } else {
    //         AppException::logException(get_class($this), __METHOD__, 'Row identifer -- ' . $key . ' -- doesnt exist');
    //         return redirect()->route('users')->with('error', 'Error retrieving record!');
    //     } 
        
    // }

    // public function do_edit_user($key, Request $request){
    //     Gate::define('edit-user', function($user){
    //         return $user->roleHasPermission('edit-user');
    //     });

    //     $this->validate($request, [
    //         'first_name' => 'required|max:255',
    //         'last_name' => 'required|max:255',
    //         'email' => 'required|email|max:255'
    //     ]);

    //     //dd($key);
    //     DB::beginTransaction();
    //     if( $key != null && $request != null ){
    //         $record = User::where('row_identifier', $key)->firstorfail();

    //         $record->first_name = StringHelper::sanitizeString($request->first_name);
    //         $record->last_name = StringHelper::sanitizeString($request->last_name);
    //         $record->email = $request->email;

    //         try{
    //             $record->save();

    //             Useraccesslog::logUserAction(Auth::user()->id, 'updated', 'user: ' . $request->first_name . ' ' . $request->last_name . ' ' . $request->email . '. The role may have been changed');

    //             $user_object = User::find($record->id);
    //             $old_role_id = (count($user_object->roles()->get()) == 0) ? null : $user_object->roles()->get()[0]->id;

    //             if( $old_role_id == null ){
    //                     try{
    //                         $role_id = DatabaseHelper::getTableKeyFromRowIdentifier('roles', $request->role_id);
            
    //                         try{
    //                             $user_object->roles()->attach($role_id);
    //                             DB::commit();
    //                             return redirect()->route('users')->with('success', 'User was successfully updated!');
    //                         } catch(QueryException $e){
    //                             DB::rollBack();
    //                             AppException::logException(get_class($this), __METHOD__, $e);
    //                             return back()->with('error', 'Error updating user!');
    //                         }
    //                     } catch(QueryException $e){
    //                         DB::rollBack();
    //                         AppException::logException(get_class($this), __METHOD__, $e);
    //                         return back()->with('error', 'Error updating user!');
    //                     }
    //             } else {
    //                 try{
    //                     $user_object->roles()->detach($old_role_id);
    
    //                     try{
    //                         $role_id = DatabaseHelper::getTableKeyFromRowIdentifier('roles', $request->role_id);
            
    //                         try{
    //                             $user_object->roles()->attach($role_id);
    //                             DB::commit();
    //                             return redirect()->route('users')->with('success', 'User was successfully updated!');
    //                         } catch(QueryException $e){
    //                             DB::rollBack();
    //                             AppException::logException(get_class($this), __METHOD__, $e);
    //                             return back()->with('error', 'Error updating user!');
    //                         }
    //                     } catch(QueryException $e){
    //                         DB::rollBack();
    //                         AppException::logException(get_class($this), __METHOD__, $e);
    //                         return back()->with('error', 'Error updating user!');
    //                     }
    //                 } catch(QueryException $e){
    //                     AppException::logException(get_class($this), __METHOD__, $e);
    //                     return back()->with('error', 'Error updating user!');
    //                 }
    //             }
    //         } catch(QueryException $e){
    //             //add code for logging exceptions
    //             AppException::logException(get_class($this), __METHOD__, $e);
    //             return back()->with('error', 'Error updating user!');
    //         }
    //     } else {
    //         AppException::logException(get_class($this), __METHOD__, 'Row identifer -- ' . $key . ' -- doesnt exist');
    //         return redirect()->route('users')->with('error', 'Error retrieving record!');
    //     } 
        
    // }

    // public function change_user_password($key){
    //     Gate::define('change-user-password', function($user){
    //         return $user->roleHasPermission('change-user-password');
    //     });

    //     if( $key != null ){
    //         $record = User::where('row_identifier', $key)->firstorfail();
    //         //dd($record);
    //         $data = array(
    //             'viewTitle' => 'Change User Password',
    //             'user' => $record
    //         );

    //         return view('admin.users.change-user-password', $data);
    //     } else {
    //         AppException::logException(get_class($this), __METHOD__, 'Row identifer -- ' . $key . ' -- doesnt exist');
    //         return redirect()->route('users')->with('error', 'Error retrieving record!');
    //     }
    // }

    // public function do_change_user_password($key, Request $request){
    //     Gate::define('change-user-password', function($user){
    //         return $user->roleHasPermission('change-user-password');
    //     });

    //     $this->validate($request, [
    //         'password' => 'required|confirmed'
    //     ]);

    //     //dd($key);

    //     if( $key != null && $request != null ){
    //         $record = User::where('row_identifier', $key)->firstorfail();

    //         $record->password = Hash::make($request->password);

    //         try{
    //             $record->save();
    //             return redirect()->route('users')->with('success', 'User\'s password was successfully updated!');
    //         } catch(QueryException $e){
    //             //add code for logging exceptions
    //             AppException::logException(get_class($this), __METHOD__, $e);
    //             return back()->with('error', 'Error updating user\'s password!');
    //         }
    //     } else {
    //         AppException::logException(get_class($this), __METHOD__, 'Row identifer -- ' . $key . ' -- doesnt exist');
    //         return redirect()->route('users')->with('error', 'Error retrieving record!');
    //     } 
        
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
