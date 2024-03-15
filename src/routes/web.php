<?php

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Admin\Applications;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SeafarersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ApplicationsController;
use App\Http\Controllers\FileController;
use App\Models\Applications as ModelsApplications;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Welcome Route
Route::get('/', function () {
    return view('auth.login');
}
)->name('login');

Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'do_login'])->name('login');
Route::get('logout', [App\Http\Controllers\Auth\LogoutController::class, 'do_logout'])->name('logout');

    // Route::view('/', 'call');
    // Route::post('/call', 'App\Http\Controllers\VoiceController@initiateCall')->name('initiate_call');
    // //Route::post('/voice.xml', 'App\Http\Controllers\VoiceController@generateTwiml');
    // Route::get('/twiml-response', 'App\Http\Controllers\VoiceController@generateTwiml');

/////////////// ADMIN ////////////////
Route::prefix('/admin')->group(function () {
    // Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('/admin/login');
    // Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'do_login']);
    Route::get('/my-dashboard', [App\Http\Controllers\DashboardController::class, 'adminDashboard'])->name('admin/my-dashboard');

    Route::get('/client/{id}', [App\Http\Controllers\ClientController::class, 'showClientDetails'])->name('admin/client');
    Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('admin/permissions');
    Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('admin/clients');
    Route::get('/patient-onboarding', [App\Http\Controllers\PatientController::class, 'index'])->name('admin/patient-onboarding');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin/users');
    Route::get('/devices', [App\Http\Controllers\DeviceController::class, 'index'])->name('admin/devices');
    Route::get('/device-details/{id}', [App\Http\Controllers\DeviceController::class, 'deviceDetails'])->name('admin/device-details');
    Route::get('/view-patient/{id}', [App\Http\Controllers\PatientController::class, 'viewPatient'])->name('admin/view-patient');
    Route::get('/device-stock', [App\Http\Controllers\DeviceController::class, 'deviceStock'])->name('admin/device-stock');
    Route::get('/all-patients-bp-readings', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAllPatients'])->name('admin/all-patients-bp-readings');

    Route::get('/add-user', [App\Http\Controllers\UserController::class, 'add_user'])->name('admin/add-user');
    Route::post('/add-user', [App\Http\Controllers\UserController::class, 'do_add_user']);
    Route::get('/edit-user', [App\Http\Controllers\UserController::class, 'edit_user'])->name('admin/edit-user');
    Route::get('/edit-user/{key}', [App\Http\Controllers\UserController::class, 'edit_user'])->name('admin/edit-user');
    Route::post('/edit-user/{key}', [App\Http\Controllers\UserController::class, 'do_edit_user']);

    Route::get('/change-user-password/{key}', [App\Http\Controllers\UserController::class, 'change_user_password'])->name('admin/change-user-password');
    Route::post('/change-user-password/{key}', [App\Http\Controllers\UserController::class, 'do_change_user_password']);

    Route::get('/onboard-patient/{id}', [App\Http\Controllers\PatientController::class, 'onboardPatient'])->name('admin/onboard-patient');
    Route::post('/onboard-patient/{id}', [App\Http\Controllers\PatientController::class, 'onboardPatient']);
    Route::post('/assign-bp-device-to-patient/{id}', [App\Http\Controllers\PatientController::class, 'assignBPDeviceToPatient'])->name('admin/assign-bp-device-to-patient');
    Route::post('/insert-onboarding-checklist-responses-for-patient/{id}', [App\Http\Controllers\PatientController::class, 'insertOnboardingChecklistResponsesForPatient'])->name('admin/insert-onboarding-checklist-responses-for-patient');

    // In routes/web.php or routes/api.php
    Route::get('/insert-readings/{patientId}/{year}/{month}', [App\Http\Controllers\BpreadingsController::class, 'insertRandomReadings'])->name('admin/insert-readings');
    Route::get('/patient-bp-reading/{id}', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAPatient'])->name('admin/patient-bp-reading');
    Route::get('/patients-bp-readings-by-status/{id}/{statusId}', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAPatientByStatusId'])->name('admin/patients-bp-readings-by-status');
    Route::get('/patients-reading-details/{id}/{rID}', [App\Http\Controllers\PatientController::class, 'getBPReadingDetailsForAPatient'])->name('admin/patients-reading-details');
    Route::post('/update-patients-bp-graph/{id}', [App\Http\Controllers\PatientController::class, 'updatePatientBPGraph'])->name('admin/update-patients-bp-graph');

    Route::get('/reports/index', [App\Http\Controllers\ReportController::class, 'index'])->name('admin/reports');
    Route::get('/reports/all-clients', [App\Http\Controllers\ReportController::class, 'getNoOfPatientsForPhysicians'])->name('admin/reports/all-clients');
    Route::get('/reports/policies-expiring', [App\Http\Controllers\ReportController::class, 'getClientsWithPoliciesExpiring'])->name('admin/reports/policies-expiring');
    Route::post('/reports/policies-expiring', [App\Http\Controllers\ReportController::class, 'doGetClientsWithPoliciesExpiring'])->name('admin/reports/policies-expiring');
    
    Route::get('/reports/expired-policies', [App\Http\Controllers\ReportController::class, 'getNoOfPatientsForPhysicians'])->name('admin/reports/expired-policies');

    Route::get('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'signupPatient'])->name('admin/sign-up-patient');
    Route::post('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'doSignUpPatient'])->name('admin/sign-up-patient');
    Route::post('/get-years-from-patient-data', [App\Http\Controllers\PatientController::class, 'getBPDataDDLYearsForPatient'])->name('admin/get-years-from-patient-data');
    Route::post('/send-sms-to-clients-with-expiring-policies', [App\Http\Controllers\ClientController::class, 'sendSMSToClientsWithExpiringPolicies'])->name('admin/send-sms-to-clients-with-expiring-policies');
    Route::get('/update-clients-balances', [App\Http\Controllers\ClientController::class, 'updateClientsBalances'])->name('admin/update-clients-balances');
    //Route::get('/add-client-payment', [App\Http\Controllers\ClientController::class, 'addClientPayment'])->name('admin/add-client-payment');
    Route::post('/add-client-payment', [App\Http\Controllers\ClientController::class, 'addClientPayment'])->name('admin/add-client-payment');
});

/////////////// NURSE ////////////////
Route::prefix('/nurse')->group(function () {
    // Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('/admin/login');
    // Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'do_login']);
    Route::get('/my-dashboard', [App\Http\Controllers\DashboardController::class, 'nurseDashboard'])->name('nurse/my-dashboard');

    Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('nurse/permissions');
    Route::get('/patients', [App\Http\Controllers\PatientController::class, 'index'])->name('nurse/patients');
    Route::get('/patient-onboarding', [App\Http\Controllers\PatientController::class, 'index'])->name('nurse/patient-onboarding');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('nurse/users');
    Route::get('/devices', [App\Http\Controllers\DeviceController::class, 'index'])->name('nurse/devices');
    Route::get('/device-details/{id}', [App\Http\Controllers\DeviceController::class, 'deviceDetails'])->name('nurse/device-details');
    Route::get('/view-patient/{id}', [App\Http\Controllers\PatientController::class, 'viewPatient'])->name('nurse/view-patient');
    Route::get('/device-stock', [App\Http\Controllers\DeviceController::class, 'deviceStock'])->name('nurse/device-stock');
    Route::get('/all-patients-bp-readings', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAllPatients'])->name('nurse/all-patients-bp-readings');

    Route::get('/add-user', [App\Http\Controllers\UserController::class, 'add_user'])->name('nurse/add-user');
    Route::post('/add-user', [App\Http\Controllers\UserController::class, 'do_add_user']);
    Route::get('/edit-user', [App\Http\Controllers\UserController::class, 'edit_user'])->name('nurse/edit-user');
    Route::get('/edit-user/{key}', [App\Http\Controllers\UserController::class, 'edit_user'])->name('nurse/edit-user');
    Route::post('/edit-user/{key}', [App\Http\Controllers\UserController::class, 'do_edit_user']);

    Route::get('/change-user-password/{key}', [App\Http\Controllers\UserController::class, 'change_user_password'])->name('nurse/change-user-password');
    Route::post('/change-user-password/{key}', [App\Http\Controllers\UserController::class, 'do_change_user_password']);

    Route::get('/onboard-patient/{id}', [App\Http\Controllers\PatientController::class, 'onboardPatient'])->name('nurse/onboard-patient');
    Route::post('/assign-bp-device-to-patient/{id}', [App\Http\Controllers\PatientController::class, 'assignBPDeviceToPatient'])->name('nurse/assign-bp-device-to-patient');
    Route::post('/add-caregiver-for-patient/{id}', [App\Http\Controllers\PatientController::class, 'addCaregiverForPatient'])->name('nurse/add-caregiver-for-patient');
    Route::post('/insert-onboarding-checklist-responses-for-patient/{id}', [App\Http\Controllers\PatientController::class, 'insertOnboardingChecklistResponsesForPatient'])->name('nurse/insert-onboarding-checklist-responses-for-patient');
    Route::get('/patients-bp-readings/{id}', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAPatient'])->name('nurse/patients-bp-readings');
    Route::get('/patients-bp-readings-by-status/{id}/{statusId}', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAPatientByStatusId'])->name('nurse/patients-bp-readings-by-status');
    Route::get('/patients-reading-details/{id}/{rID}', [App\Http\Controllers\PatientController::class, 'getBPReadingDetailsForAPatient'])->name('nurse/patients-reading-details');
    Route::post('/update-patients-bp-graph/{id}', [App\Http\Controllers\PatientController::class, 'updatePatientBPGraph'])->name('nurse/update-patients-bp-graph');

    Route::get('/reports/index', [App\Http\Controllers\ReportController::class, 'index'])->name('nurse/reports');
    Route::get('/reports/avg-monthly-bp-readings', [App\Http\Controllers\ReportController::class, 'getAverageMonthlyBPReadingsForAPatient'])->name('nurse/reports/avg-monthly-bp-readings');
    Route::post('/reports/avg-monthly-bp-readings', [App\Http\Controllers\ReportController::class, 'doGetAverageMonthlyBPReadingsForAPatient']);

    Route::get('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'signupPatient'])->name('nurse/sign-up-patient');
    Route::post('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'doSignUpPatient'])->name('nurse/sign-up-patient');

    Route::post('/get-years-from-patient-data', [App\Http\Controllers\PatientController::class, 'getBPDataDDLYearsForPatient'])->name('nurse/get-years-from-patient-data');
    Route::post('/get-invalidating-reason-specifics', [App\Http\Controllers\InvalidatebpreasonController::class, 'getInvalidateBPReasonSpecifics'])->name('nurse/get-invalidating-reason-specifics');
    Route::get('/reports/physician-patient-count', [App\Http\Controllers\ReportController::class, 'getNoOfPatientsForPhysicians'])->name('nurse/reports/physician-patient-count');
});

/////////////// PHYSICIAN ////////////////
Route::prefix('/physician')->group(function () {
    Route::get('/my-dashboard', [App\Http\Controllers\DashboardController::class, 'physicianDashboard'])->name('physician/my-dashboard');
    Route::get('/patients', [App\Http\Controllers\PatientController::class, 'index'])->name('physician/patients');
    Route::get('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'signupPatient'])->name('physician/sign-up-patient');
    Route::post('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'doSignUpPatient'])->name('physician/sign-up-patient');
    Route::get('/my-patients-bp-readings', [App\Http\Controllers\PhysicianController::class, 'getBPReadingsForAllPhysiciansPatients'])->name('physician/my-patients-bp-readings');
    Route::get('/view-patient/{id}', [App\Http\Controllers\PatientController::class, 'viewPatient'])->name('physician/view-patient');
    Route::get('/patients-bp-readings/{id}', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAPatient'])->name('physician/patients-bp-readings');
    Route::get('/patients-reading-details/{id}/{rID}', [App\Http\Controllers\PatientController::class, 'getBPReadingDetailsForAPatient'])->name('physician/patients-reading-details');
    Route::post('/update-patients-bp-graph/{id}', [App\Http\Controllers\PatientController::class, 'updatePatientBPGraph'])->name('physician/update-patients-bp-graph');
    Route::get('/patients-bp-readings-by-status/{id}/{statusId}', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAPatientByStatusId'])->name('physician/patients-bp-readings-by-status');
    Route::get('/reports/index', [App\Http\Controllers\ReportController::class, 'index'])->name('physician/reports');
    Route::get('/reports/avg-monthly-bp-readings', [App\Http\Controllers\ReportController::class, 'getAverageMonthlyBPReadingsForAPatient'])->name('physician/reports/avg-monthly-bp-readings');
    Route::post('/reports/avg-monthly-bp-readings', [App\Http\Controllers\ReportController::class, 'doGetAverageMonthlyBPReadingsForAPatient']);
    Route::post('/get-years-from-patient-data', [App\Http\Controllers\PatientController::class, 'getBPDataDDLYearsForPatient'])->name('physician/get-years-from-patient-data');
});

// /////////////// PATIENT READINGS ////////////////
Route::prefix('/patient')->group(function () {
    Route::post('/readings/bp', [App\Http\Controllers\PatientController::class, 'patientsBPReadings'])->name('patient/readings/bp');
    Route::post('/readings/bg', [App\Http\Controllers\PatientController::class, 'patientsBGReadings'])->name('patient/readings/bg');
});

// /////////////// PATIENT ////////////////
Route::prefix('/patient')->group(function () {
    Route::get('/my-dashboard', [App\Http\Controllers\DashboardController::class, 'adminDashboard'])->name('patient/my-dashboard');
    Route::get('/my-readings/bp', [App\Http\Controllers\PatientController::class, 'getPatientsOwnBPReadings'])->name('patient/my-readings/bp');
    Route::get('/my-readings/bg', [App\Http\Controllers\PatientController::class, 'getPatientsOwnBGReadings'])->name('patient/my-readings/bg');
});

/////////////// REPORTS ////////////////
Route::prefix('/reports')->group(function () {
    Route::get('/index', [App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::get('/physician-patient-count', [App\Http\Controllers\ReportController::class, 'getNoOfPatientsForPhysicians'])->name('reports/physician-patient-count');
// Route::get('/admin/reports/unique-references', [ReportsController::class, 'unique_references'])->name('reports/unique-references');
});


/////////////// PERMISSIONS ////////////////

// Route::get('/admin/add-permission', [App\Http\Controllers\Admin\PermissionController::class, 'add_permission'])->name('add-permission');
// Route::post('/admin/add-permission', [App\Http\Controllers\Admin\PermissionController::class, 'do_add_permission']);
// Route::get('/admin/assign-permissions', [App\Http\Controllers\Admin\PermissionController::class, 'assign_permissions'])->name('assign-permissions');
// Route::get('/admin/assign-permissions/{slug?}', [App\Http\Controllers\Admin\PermissionController::class, 'assign_permissions'])
//     ->where('slug', '[a-z\-]+');
// Route::post('/admin/assign-permissions/{slug?}', [App\Http\Controllers\Admin\PermissionController::class, 'do_assign_permissions']);

/*Route::get('/admin/add-user', [App\Http\Controllers\Admin\UserController::class, 'add_user'])->name('add-user');
Route::post('/admin/add-user', [App\Http\Controllers\Admin\UserController::class, 'do_add_user']);
Route::get('/admin/edit-user', [App\Http\Controllers\Admin\UserController::class, 'edit_user'])->name('edit-user');
Route::get('/admin/edit-user/{key}', [App\Http\Controllers\Admin\UserController::class, 'edit_user'])->name('edit-user');
Route::post('/admin/edit-user/{key}', [App\Http\Controllers\Admin\UserController::class, 'do_edit_user']);*/


/*Route::get('/admin', function () { 
    if( Auth::user() )
        //return view('admin.applications.list-applications');
        return redirect()->route('list-applications');
    else
        return view('admin.auth.login'); 
})->name("admin");*/

/*Route::get('/apply', function () {
    ModelsApplications::clearApplicationDataFromSession(); 
    return redirect()->route('nau-application-form-1');
}
)->name('apply');

Route::post('delete-file', ['as'=>'delete-file', 'uses'=>'App\Http\Controllers\ApplicationController@deleteUploadedFile']);

//Route::get('/admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::get('/admin/login', function () { 
        return redirect('/admin'); 
})->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'do_login']);*/

// Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

// Route::get('/admin/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
// Route::post('/admin/register', [App\Http\Controllers\Auth\RegisterController::class, 'do_register']);

/*Route::get('/admin/applications', [App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('list-applications');
Route::get('/admin/processed-applications', [App\Http\Controllers\Admin\ApplicationController::class, 'processedApplications'])->name('show-processed-applications');
Route::get('/admin/application/{key}', [App\Http\Controllers\Admin\ApplicationController::class, 'view_application'])->name('view-application');

Route::post('do-process-application', ['as'=>'do-process-application','uses'=>'App\Http\Controllers\Admin\ApplicationController@doProcessApplication']);
Route::post('do-reverse-application', ['as'=>'do-reverse-application','uses'=>'App\Http\Controllers\Admin\ApplicationController@doReverseApplication']);

Route::get('/admin/search-incomplete-applications', [App\Http\Controllers\Admin\ApplicationController::class, 'findIncompleteApplication'])->name('search-incomplete-applications');
Route::post('/admin/search-incomplete-applications', [App\Http\Controllers\Admin\ApplicationController::class, 'doFindIncompleteApplication'])->name('search-incomplete-applications');

Route::get('/full-application/{key}', [App\Http\Controllers\Admin\ApplicationController::class, 'full_application'])->name('full-application');

Route::get('/application-to-pdf/{key}', [App\Http\Controllers\Admin\ApplicationController::class, 'application_to_pdf'])->name('application-to-pdf');

Route::get('get/{filename}', [App\Http\Controllers\FileController::class, 'getUploadedApplicationFile'])->name('getfile');

/////////////// USERS ////////////////
Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
Route::get('/admin/add-user', [App\Http\Controllers\Admin\UserController::class, 'add_user'])->name('add-user');
Route::post('/admin/add-user', [App\Http\Controllers\Admin\UserController::class, 'do_add_user']);
Route::get('/admin/edit-user', [App\Http\Controllers\Admin\UserController::class, 'edit_user'])->name('edit-user');
Route::get('/admin/edit-user/{key}', [App\Http\Controllers\Admin\UserController::class, 'edit_user'])->name('edit-user');
Route::post('/admin/edit-user/{key}', [App\Http\Controllers\Admin\UserController::class, 'do_edit_user']);

Route::get('/admin/change-user-password/{key}', [App\Http\Controllers\Admin\UserController::class, 'change_user_password'])->name('change-user-password');
Route::post('/admin/change-user-password/{key}', [App\Http\Controllers\Admin\UserController::class, 'do_change_user_password']);

/////////////// PERMISSIONS ////////////////
Route::get('/admin/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions');
Route::get('/admin/add-permission', [App\Http\Controllers\Admin\PermissionController::class, 'add_permission'])->name('add-permission');
Route::post('/admin/add-permission', [App\Http\Controllers\Admin\PermissionController::class, 'do_add_permission']);
Route::get('/admin/assign-permissions', [App\Http\Controllers\Admin\PermissionController::class, 'assign_permissions'])->name('assign-permissions');
Route::get('/admin/assign-permissions/{slug?}', [App\Http\Controllers\Admin\PermissionController::class, 'assign_permissions'])
    ->where('slug', '[a-z\-]+');
Route::post('/admin/assign-permissions/{slug?}', [App\Http\Controllers\Admin\PermissionController::class, 'do_assign_permissions']);

/////////////// ROLES ////////////////
Route::get('/admin/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles');
Route::get('/admin/add-role', [App\Http\Controllers\Admin\RoleController::class, 'add_role'])->name('add-role');
Route::post('/admin/add-role', [App\Http\Controllers\Admin\RoleController::class, 'do_add_role']);

/////////////// EMAILS ////////////////
// Route::get('/admin/emails', [EmailController::class, 'index'])->name('emails');
// Route::get('/admin/add-email', [EmailController::class, 'add_email'])->name('add-email');
// Route::post('/admin/add-email', [EmailController::class, 'do_add_email']);
// Route::get('/admin/edit-email', [EmailController::class, 'edit_email'])->name('edit-email');
// Route::get('/admin/edit-email/{slug}', [EmailController::class, 'edit_email'])->name('edit-email');
// Route::post('/admin/edit-email/{slug}', [EmailController::class, 'do_edit_email']);
//Route::post('/admin/edit-email/{slug}', [App\Http\Controllers\Admin\EmailController::class, 'do_edit_email']);
*/

