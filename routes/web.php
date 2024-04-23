<?php

use App\Models\Post;
use Illuminate\Notifications\Console\NotificationTableCommand;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Frontend\CompanyTypeController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\UserController;
use Illuminate\Support\Facades\Artisan;


/* 
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Group Routing
Route::group(['middleware' => 'admin'], function () {

  Route::get('Dashboard', [DashboardController::class, 'dashboard'])->name('Dashboard');
  Route::post('FreeSubscription', [DashboardController::class, 'free_subscription']);
  Route::get('RemoveFreeSubscription', [DashboardController::class, 'remove_free_subscription'])->name('RemoveFreeSubscription');
  Route::post('FreeProjects', [DashboardController::class, 'free_projects']);
  Route::get('RemoveFreeProjects', [DashboardController::class, 'remove_free_projects'])->name('RemoveFreeProjects');

  Route::get('PrivateUser', [UserController::class, 'private_users'])->name('PrivateUser');
  Route::get('PrivateUsers', [UserController::class, 'getUsers'])->name('PrivateUsers');

  Route::get('UserDetail/{id}', [UserController::class, 'user_detail'])->name('UserDetail');
  Route::get('ProjectsAgaintsUser/{id}', [UserController::class, 'project_against_user_id'])->name('ProjectsAgaintsUser');
  Route::get('ProjectDetail/{id}', [UserController::class, 'project_by_project_id'])->name('ProjectDetail');
  Route::get('UserPayment/{id}', [UserController::class, 'payment_history'])->name('UserPayment');


  Route::get('CompanyUser', [UserController::class, 'company_users'])->name('CompanyUser');
  Route::get('CompanyUsers', [UserController::class, 'get_company_users'])->name('CompanyUsers');
  Route::get('CompanyDetail/{id}', [UserController::class, 'company_detail'])->name('CompanyDetail');
  Route::get('CompanyDetailProjects/{id}', [UserController::class, 'company_detail_projects'])->name('CompanyDetailProjects');
  Route::get('CompanyReviews/{id}', [UserController::class, 'company_reviews'])->name('CompanyReviews');
  Route::get('CompanyInCharges/{id}', [UserController::class, 'company_in_charges'])->name('CompanyInCharges');
  Route::get('CompanyPastProjects/{id}', [UserController::class, 'company_past_projects'])->name('CompanyPastProjects');
  Route::get('PastProjectDetail/{id}', [UserController::class, 'past_project_detail'])->name('PastProjectDetail');
  Route::get('CompanySubscription/{id}', [UserController::class, 'company_subscription'])->name('CompanySubscription');

  Route::get('DeleteUser/{id}', [UserController::class, 'delete_account'])->name('DeleteUser');


  Route::get('PaymentHistory', [ProjectController::class, 'subscription_payment'])->name('PaymentHistory');
  Route::get('SubscriptionPayments', [ProjectController::class, 'subscription_payments'])->name('SubscriptionPayments');
  Route::get('ProjectPayment', [ProjectController::class, 'project_payment'])->name('ProjectPayment');
  Route::get('ProjectPayments', [ProjectController::class, 'project_payments'])->name('ProjectPayments');

  Route::get('AllProjects', [ProjectController::class, 'company_projects'])->name('AllProjects');
  Route::get('CompanyProjects', [ProjectController::class, 'get_company_projects'])->name('CompanyProjects');
  Route::get('CompanyProjectDetail/{id}', [ProjectController::class, 'company_project_detail'])->name('CompanyProjectDetail');


  Route::get('UserProject', [ProjectController::class, 'user_projects'])->name('UserProjects');
  Route::get('UserProjects', [ProjectController::class, 'get_user_projects'])->name('UserProjects');
  Route::get('UserProjectDetail/{id}', [ProjectController::class, 'user_project_detail'])->name('UserProjectDetail');


  Route::get('CompanyTypes', [CompanyTypeController::class, 'category'])->name('CompanyTypes');
  Route::get('AddCompanyType', [CompanyTypeController::class, 'add_company_type'])->name('AddCompanyType');
  Route::post('company_type_update/{id}', [CompanyTypeController::class, 'company_type_update'])->name('company_type_update');
  Route::get('category_delete/{id}', [CompanyTypeController::class, 'category_destroy']);
  Route::get('Services/{id}', [CompanyTypeController::class, 'service']);
  Route::get('Services/AddService/{id}', [CompanyTypeController::class, 'add_service'])->name('AddService');
  Route::post('service_update/{id}', [CompanyTypeController::class, 'service_update'])->name('service_update');
  Route::get('Services/service_destroy/{id}', [CompanyTypeController::class, 'service_destroy']);

  Route::get('Mail', [DashboardController::class, 'mail']);
  Route::post('sendEmail', [DashboardController::class, 'send_email']);


  Route::get('ContactUS', [DashboardController::class, 'contact_us'])->name('ContactUS');
  Route::get('ContactList', [DashboardController::class, 'get_contact_list'])->name('ContactList');

  Route::get('Requests', [DashboardController::class, 'delete_account_requests'])->name('Requests');
  Route::get('GetRequests', [DashboardController::class, 'get_delete_account_requests'])->name('GetRequests');
  Route::get('DeleteRequestDetail/{email}', [DashboardController::class, 'delete_request_detail'])->name('DeleteRequestDetail');


});

Route::post('/contactus', [DashboardController::class, 'contact_us_form']);
Route::post('/deleteAccount', [DashboardController::class, 'delete_account_form']);



Route::get('/', [AdminController::class, 'login'])->name('login')->middleware('admin');
Route::post('loginn', [AdminController::class, 'loginn']);
Route::get('logout', [AdminController::class, 'flush']);
Route::get('ForgotPassword', [AdminController::class, 'forgot_password']);
Route::post('SendOtp', [AdminController::class, 'send_otp']);
Route::post('VerifyOtp', [AdminController::class, 'verify_otp']);
Route::get('ChangePassword', [AdminController::class, 'change_password']);
Route::post('ResetPassword', [AdminController::class, 'reset_password']);



//For Route Clear
Route::get('/clear', function () {

  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('optimize');
  Artisan::call('route:cache');
  Artisan::call('route:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');

  return "Cleared!";
});

// Privacy links

Route::view('/Contact', 'ContactUs');
Route::view('/Privacy', 'privacy');
Route::view('/Terms', 'Terms');
Route::view('/Request', 'DeleteAccount');

