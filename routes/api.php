<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Company\CompanyTypeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Company\EditProfileController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Auth Apis
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'sign_up')->name('register');
    Route::post('login', 'sign_in')->name('login');
    Route::post('socialLogin', 'social_login')->name('socialLogin');
    Route::post('deviceId', 'update_device_id');
    Route::post('firebaseId', 'update_firebase_id');
    Route::post('logout', 'logout');
});
// forgot password
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('generateOTP', 'generate_otp')->name('generateOTP');
    Route::post('verifyOTP', 'verify_otp')->name('verifyOTP');
    Route::post('resetPassword', 'reset_password')->name('resetPassword');
    Route::post('UpdatePassword', 'update_password')->middleware(['auth:sanctum']);
});

Route::group([
    'prefix' => 'profile',
    'middleware' => ['auth:sanctum'],

], function () {
    Route::post('/myProfile', [EditProfileController::class, 'my_profile']);
    Route::post('/inCharges', [EditProfileController::class, 'in_charges']);
    Route::post('/reviews', [EditProfileController::class, 'reviews']);
    Route::post('/projects', [EditProfileController::class, 'projects']);
    Route::put('/profileImage', [EditProfileController::class, 'edit_profile_image']);
    Route::post('/allCompanyUsers', [EditProfileController::class, 'get_company_users']);
    Route::post('/companyUsers', [EditProfileController::class, 'company_users']);
    Route::put('/editProfile', [EditProfileController::class, 'edit_profile']);
    Route::post('/addServiceAgainstCompanyType', [EditProfileController::class, 'service_against_company_type_add']);
    Route::post('/serviceAgainstCompanyTypeDelete', [EditProfileController::class, 'service_against_company_type_delete']);
    Route::post('/deleteCompanyUser', [EditProfileController::class, 'company_user_delete']);
    Route::post('/savedProject', [EditProfileController::class, 'saved_project']);
    Route::post('/delete', [EditProfileController::class, 'delete_account']);
    Route::post('/getCompanyById', [EditProfileController::class, 'company_by_company_id']);
    Route::post('/savedCompany', [EditProfileController::class, 'saved_company']);
    Route::post('/ongoingProjects', [EditProfileController::class, 'ongoing_projects']);
    Route::post('/myRequests', [EditProfileController::class, 'my_requests']);
    Route::post('/searchHistory', [EditProfileController::class, 'search_history']);
    Route::post('/deleteSearch', [SearchController::class, 'delete_search_history']);
    Route::post('/updateRange', [EditProfileController::class, 'update_range_for_notification']);
    Route::post('/addCompanyProject', [EditProfileController::class, 'add_company_project']);
    Route::put('/editCompanyProject', [EditProfileController::class, 'edit_company_project']);
    Route::post('/addCompanyProjectSubImages', [EditProfileController::class, 'add_company_project_sub_images']);
    Route::post('/deleteCompanyProjectSubImage', [EditProfileController::class, 'delete_company_project_sub_images']);
    Route::post('/companyProjects', [EditProfileController::class, 'company_personal_projects']);
    Route::post('/deleteCompanyProject', [EditProfileController::class, 'company_project_delete']);


    Route::post('/addCompanyType', [EditProfileController::class, 'company_type_add']);
    Route::post('/deleteCompanyType', [EditProfileController::class, 'company_type_delete']);

});


Route::group([
    'prefix' => 'project',
    'middleware' => ['auth:sanctum'],

], function () {
    Route::post('/create', [ProjectController::class, 'create_project']);
    Route::post('/myProjects', [ProjectController::class, 'my_projects']);
    Route::put('/myProject', [ProjectController::class, 'my_project']);
    Route::post('/addServiceAgainstCompanyType', [ProjectController::class, 'service_against_company_type_add']);
    Route::post('/serviceAgainstCompanyTypeDelete', [ProjectController::class, 'service_against_company_type_delete']);
    Route::post('/addCompanyType', [ProjectController::class, 'company_type_add']);
    Route::post('/companyTypeDelete', [ProjectController::class, 'company_type_delete']);
    Route::post('/delete', [ProjectController::class, 'delete_project']);
    Route::post('/review', [ProjectController::class, 'add_review']);
    Route::post('/requestList', [ProjectController::class, 'request_list']);
    Route::post('/undoRequest', [ProjectController::class, 'undo_request']);
    Route::post('/UpdateProjectStatus', [ProjectController::class, 'update_project_status']);
    Route::post('/requestRespond', [ProjectController::class, 'request_respond']);
    Route::post('/getProjectById', [ProjectController::class, 'project_by_project_id']);
    Route::post('/latestProject', [ProjectController::class, 'latest_project']);
    Route::post('/serviceStatus', [ProjectController::class, 'service_status']);

});

Route::group([
    'prefix' => 'home',
    'middleware' => ['auth:sanctum'],

], function () {
    Route::post('/companyHome', [HomeController::class, 'company_home']);
    Route::post('/saveProject', [HomeController::class, 'save_project']);
    Route::post('/projectRequest', [HomeController::class, 'project_request']);
    Route::post('/saveCompany', [HomeController::class, 'save_company']);
    Route::post('/userHome', [UserController::class, 'user_home']);

});

Route::group([
    'prefix' => 'User',
    'middleware' => ['auth:sanctum'],

], function () {
    Route::post('/projectCount', [UserController::class, 'project_count']);

});

Route::group([
    'prefix' => 'notification',
    'middleware' => ['auth:sanctum'],

], function () {
    Route::post('/notifications', [NotificationController::class, 'notification']);
    Route::post('/markRead', [NotificationController::class, 'mark_read']);
    Route::post('/readSingle', [NotificationController::class, 'read_single_notification']);
    Route::post('/delete', [NotificationController::class, 'delete_notification']);
});

Route::group([
    'prefix' => 'search',
    'middleware' => ['auth:sanctum'],

], function () {
    Route::post('/companySearch', [SearchController::class, 'company_search']);
    Route::post('/projectSearch', [SearchController::class, 'project_search']);
    Route::post('/recentSearch', [SearchController::class, 'recent_search']);
    Route::post('/myRecentSearch', [SearchController::class, 'get_recent_search']);
    Route::post('/deleteRecentSearch', [SearchController::class, 'delete_recent_search']);

});


Route::group([
    'prefix' => 'subscription',
    'middleware' => ['auth:sanctum'],

], function () {
    Route::post('/planDetail', [SubscriptionController::class, 'plan_detail']);
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::post('/change', [SubscriptionController::class, 'change']);
    Route::post('/active', [SubscriptionController::class, 'my_subscription']);
    Route::post('/projectPayment', [SubscriptionController::class, 'project_payment']);
});
// get comany list
Route::get('company/lists', [CompanyTypeController::class, 'company_list']);
Route::post('company/services', [CompanyTypeController::class, 'services']);
Route::put('/socailEditProfile', [EditProfileController::class, 'socail_edit_profile']);
Route::get('subscription/plans', [SubscriptionController::class, 'plans']);


// Form submissions for Contact us and Delete Account request 

Route::post('/contact', [UserController::class, 'contact_us_form']);
Route::post('/request', [UserController::class, 'delete_account_form']);