<?php

use App\Http\Controllers\bloodTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\MainController;
use App\Http\Controllers\GovernorateController;
use App\Http\Middleware\AutoCheckPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;

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
Route::group(['namespace'=>'Front'] , function(){
    Route::get('/',[MainController::class,'home'] )->name('front.home');
    Route::get('about',[MainController::class,'about'] );
    Route::get('who-are-us',[MainController::class,'whoAreUs'] )->name('who-are-us.whoAreUs');
    Route::get('register-client',[AuthController::class,'register'])->name('register-client');
    Route::post('register-client',[AuthController::class,'registerSave'])->name('register-client.registerSave');
    Route::get('login-client',[AuthController::class,'login'])->name('login-client');
    Route::post('login-client',[AuthController::class,'loginSave'])->name('login-client.loginSave');
    Route::get('contact-us',[MainController::class,'contactUs'])->name('contact-us.contactUs');
    Route::post('contact-us',[MainController::class,'contact'])->name('contact-us.contact');
    Route::get('posts',[MainController::class,'posts'])->name('postst.posts');
    Route::get('resset-password',[AuthController::class,'ressetPassword'])->name('resset-password.ressetPassword');
    Route::post('resset-password',[AuthController::class,'Password'])->name('resset-password.Password');
    Route::get('new-password',[AuthController::class,'thePassword'])->name('new-password.thePassword');
    Route::post('new-password',[AuthController::class,'newPassword'])->name('new-password.newPassword');
    Route::get('posts/postMore/{id}',[MainController::class,'postMore'])->name('postst.postMore');
    Route::get('donation-requests',[MainController::class,'donationRequests'])->name('donation-requests.donationRequests');
    Route::get('donation-requests/donationInformation/{id}',[MainController::class,'donationInformation'])->name('donation-requests.donationInformation');

});

Route::group(['namespace'=>'Front','middleware'=>'auth:client-web'],function(){
    Route::post('toggle-favourite', [MainController::class, 'toggleFavourite']);
    Route::get('logout-client',[AuthController::class,'logout'])->name('logout-client.logout');
    Route::get('profile',[AuthController::class,'profile'])->name('profile.profile');
    Route::post('profile',[AuthController::class,'profileSave'])->name('profile.profileSave');
    Route::get('donation-create',[MainController::class,'donation_request_create'])->name('donation-create.donation_request_create');
    Route::post('donation-create',[MainController::class,'donation_request_create_save'])->name('donation-create.donation_request_create_save');
});
Auth::routes();

//
Route::group(['middleware' => ['auth',AutoCheckPermission::class] ,'prefix' => 'admin'], function(){
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::resource('governorate',GovernorateController::class);
    Route::resource('categories',CategoryController::class);
    Route::resource('posts',PostsController::class);
    Route::resource('cities',CitiesController::class);
    Route::resource('clients',ClientsController::class);
    Route::resource('contacts',ContactController::class);
    Route::resource('donationRequests',DonationRequestController::class);
    Route::resource('bloodTypes',bloodTypeController::class);
    Route::resource('role',RoleController::class);
    Route::resource('user',UserController::class);
    Route::get('change-password', [ChangePasswordController::class,'index'])->name('change-password');
    Route::post('change-password',[ChangePasswordController::class,'update'])->name('change-password.update');
    Route::get('settings',[SettingsController::class,'index'])->name('settings');
    Route::post('settings',[SettingsController::class,'store'])->name('settings.store');
});
