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

    Route::get('/import-clients', [App\Http\Controllers\ClientController::class, 'importClients'])->name('admin/import-clients');
    Route::post('/import-clients', [App\Http\Controllers\ClientController::class, 'doImportClients'])->name('admin/import-clients');

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
    Route::get('/reports/sms-sent-by-agent', [App\Http\Controllers\ReportController::class, 'getSMSSentReport'])->name('admin/reports/sms-sent-by-agent');

    Route::get('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'signupPatient'])->name('admin/sign-up-patient');
    Route::post('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'doSignUpPatient'])->name('admin/sign-up-patient');
    Route::post('/get-years-from-patient-data', [App\Http\Controllers\PatientController::class, 'getBPDataDDLYearsForPatient'])->name('admin/get-years-from-patient-data');
    Route::post('/send-sms-to-clients-with-expiring-policies', [App\Http\Controllers\ClientController::class, 'sendSMSToClientsWithExpiringPolicies'])->name('admin/send-sms-to-clients-with-expiring-policies');
    Route::get('/update-clients-balances', [App\Http\Controllers\ClientController::class, 'updateClientsBalances'])->name('admin/update-clients-balances');
    //Route::get('/add-client-payment', [App\Http\Controllers\ClientController::class, 'addClientPayment'])->name('admin/add-client-payment');
    Route::post('/add-client-payment', [App\Http\Controllers\ClientController::class, 'addClientPayment'])->name('admin/add-client-payment');

    Route::delete('/clients/delete-all', [App\Http\Controllers\ClientController::class, 'deleteAll'])->name('admin/clients.deleteAll');

    Route::get('/get-sms-template', [App\Http\Controllers\ClientController::class, 'getSmsTemplate'])->name('admin/get-sms-template');
    Route::post('/send-bulk-lapse-sms', [App\Http\Controllers\ClientController::class, 'sendBulkLapseSms'])->name('admin/send-bulk-lapse-sms');

    Route::get('/apiclients', [App\Http\Controllers\ClientController::class, 'getClientsData'])->name('admin/apiclients');
});

Route::prefix('/agent')->group(function () {
    // Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('/agent/login');
    // Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'do_login']);
    Route::get('/my-dashboard', [App\Http\Controllers\DashboardController::class, 'adminDashboard'])->name('agent/my-dashboard');

    Route::get('/import-clients', [App\Http\Controllers\ClientController::class, 'importClients'])->name('agent/import-clients');
    Route::post('/import-clients', [App\Http\Controllers\ClientController::class, 'doImportClients'])->name('agent/import-clients');

    Route::get('/client/{id}', [App\Http\Controllers\ClientController::class, 'showClientDetails'])->name('agent/client');
    Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('agent/permissions');
    Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('agent/clients');
    Route::get('/patient-onboarding', [App\Http\Controllers\PatientController::class, 'index'])->name('agent/patient-onboarding');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('agent/users');
    Route::get('/devices', [App\Http\Controllers\DeviceController::class, 'index'])->name('agent/devices');
    Route::get('/device-details/{id}', [App\Http\Controllers\DeviceController::class, 'deviceDetails'])->name('agent/device-details');
    Route::get('/view-patient/{id}', [App\Http\Controllers\PatientController::class, 'viewPatient'])->name('agent/view-patient');
    Route::get('/device-stock', [App\Http\Controllers\DeviceController::class, 'deviceStock'])->name('agent/device-stock');
    Route::get('/all-patients-bp-readings', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAllPatients'])->name('agent/all-patients-bp-readings');

    Route::get('/add-user', [App\Http\Controllers\UserController::class, 'add_user'])->name('agent/add-user');
    Route::post('/add-user', [App\Http\Controllers\UserController::class, 'do_add_user']);
    Route::get('/edit-user', [App\Http\Controllers\UserController::class, 'edit_user'])->name('agent/edit-user');
    Route::get('/edit-user/{key}', [App\Http\Controllers\UserController::class, 'edit_user'])->name('agent/edit-user');
    Route::post('/edit-user/{key}', [App\Http\Controllers\UserController::class, 'do_edit_user']);

    Route::get('/change-user-password/{key}', [App\Http\Controllers\UserController::class, 'change_user_password'])->name('agent/change-user-password');
    Route::post('/change-user-password/{key}', [App\Http\Controllers\UserController::class, 'do_change_user_password']);

    Route::get('/onboard-patient/{id}', [App\Http\Controllers\PatientController::class, 'onboardPatient'])->name('agent/onboard-patient');
    Route::post('/onboard-patient/{id}', [App\Http\Controllers\PatientController::class, 'onboardPatient']);
    Route::post('/assign-bp-device-to-patient/{id}', [App\Http\Controllers\PatientController::class, 'assignBPDeviceToPatient'])->name('agent/assign-bp-device-to-patient');
    Route::post('/insert-onboarding-checklist-responses-for-patient/{id}', [App\Http\Controllers\PatientController::class, 'insertOnboardingChecklistResponsesForPatient'])->name('agent/insert-onboarding-checklist-responses-for-patient');

    // In routes/web.php or routes/api.php
    Route::get('/insert-readings/{patientId}/{year}/{month}', [App\Http\Controllers\BpreadingsController::class, 'insertRandomReadings'])->name('agent/insert-readings');
    Route::get('/patient-bp-reading/{id}', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAPatient'])->name('agent/patient-bp-reading');
    Route::get('/patients-bp-readings-by-status/{id}/{statusId}', [App\Http\Controllers\PatientController::class, 'getBPReadingsForAPatientByStatusId'])->name('agent/patients-bp-readings-by-status');
    Route::get('/patients-reading-details/{id}/{rID}', [App\Http\Controllers\PatientController::class, 'getBPReadingDetailsForAPatient'])->name('agent/patients-reading-details');
    Route::post('/update-patients-bp-graph/{id}', [App\Http\Controllers\PatientController::class, 'updatePatientBPGraph'])->name('agent/update-patients-bp-graph');

    Route::get('/reports/index', [App\Http\Controllers\ReportController::class, 'index'])->name('agent/reports');
    Route::get('/reports/all-clients', [App\Http\Controllers\ReportController::class, 'getNoOfPatientsForPhysicians'])->name('agent/reports/all-clients');
    Route::get('/reports/policies-expiring', [App\Http\Controllers\ReportController::class, 'getClientsWithPoliciesExpiring'])->name('agent/reports/policies-expiring');
    Route::post('/reports/policies-expiring', [App\Http\Controllers\ReportController::class, 'doGetClientsWithPoliciesExpiring'])->name('agent/reports/policies-expiring');
    
    Route::get('/reports/expired-policies', [App\Http\Controllers\ReportController::class, 'getNoOfPatientsForPhysicians'])->name('agent/reports/expired-policies');
    Route::get('/reports/sms-sent-by-agent', [App\Http\Controllers\ReportController::class, 'getSMSSentReport'])->name('agent/reports/sms-sent-by-agent');

    Route::get('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'signupPatient'])->name('agent/sign-up-patient');
    Route::post('/sign-up-patient', [App\Http\Controllers\PatientController::class, 'doSignUpPatient'])->name('agent/sign-up-patient');
    Route::post('/get-years-from-patient-data', [App\Http\Controllers\PatientController::class, 'getBPDataDDLYearsForPatient'])->name('agent/get-years-from-patient-data');
    Route::post('/send-sms-to-clients-with-expiring-policies', [App\Http\Controllers\ClientController::class, 'sendSMSToClientsWithExpiringPolicies'])->name('agent/send-sms-to-clients-with-expiring-policies');
    Route::get('/update-clients-balances', [App\Http\Controllers\ClientController::class, 'updateClientsBalances'])->name('agent/update-clients-balances');
    //Route::get('/add-client-payment', [App\Http\Controllers\ClientController::class, 'addClientPayment'])->name('agent/add-client-payment');
    Route::post('/add-client-payment', [App\Http\Controllers\ClientController::class, 'addClientPayment'])->name('agent/add-client-payment');

    Route::delete('/clients/delete-all', [App\Http\Controllers\ClientController::class, 'deleteAll'])->name('agent/clients.deleteAll');

    Route::get('/get-sms-template', [App\Http\Controllers\ClientController::class, 'getSmsTemplate'])->name('agent/get-sms-template');
    Route::post('/send-bulk-lapse-sms', [App\Http\Controllers\ClientController::class, 'sendBulkLapseSms'])->name('agent/send-bulk-lapse-sms');

    Route::get('/apiclients', [App\Http\Controllers\ClientController::class, 'getClientsData'])->name('agent/apiclients');
});

/////////////// REPORTS ////////////////
Route::prefix('/reports')->group(function () {
    Route::get('/index', [App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    //Route::get('/sms-sent-by-agent', [App\Http\Controllers\ReportController::class, 'getSMSSentByAnAgent'])->name('reports/sms-sent-by-agent');
// Route::get('/admin/reports/unique-references', [ReportsController::class, 'unique_references'])->name('reports/unique-references');
});