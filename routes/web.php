<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\SwitchModeController;

use App\Http\Controllers\error\ErrorController;
use App\Http\Controllers\admins\AdminController;
use App\Http\Controllers\clients\HomeController;
use App\Http\Controllers\admins\BranchController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\admins\ProfileController;
use App\Http\Controllers\admins\VehicleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');

    Route::post('/login', [UserController::class, 'login'])->name('login');

    Route::get('/sign_up', [UserController::class, 'register'])->name('register');

    Route::post('/sign_up', [UserController::class, 'check_register'])->name('check_register');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/user_actived/{user}/{token}', [UserController::class, 'actived'])->name('user.actived');

    //Forgot Password
    Route::get('/forgot_password', [UserController::class, 'forgotPassowrd'])->name('forgot_password');

    Route::post('/forgot_password', [UserController::class, 'postForgetPassword'])->name('forgot_passowrd_mail');

    Route::get('/get_forgot_password/{user}/{token}', [UserController::class, 'getForgotPasword'])->name('get_forgot_password');

    Route::post('/get_forgot_password/{user}/{token}', [UserController::class, 'postForgotPasword'])->name('post_forgot_password');

    //Social login
    Route::get('/{provider}/redirect', [ProviderController::class, 'redirect'])->name('social_login');

    Route::get('/{provider}/callback', [ProviderController::class, 'callback']);


    // admin login
    Route::get('/admin_login', [UserController::class, 'admin_login'])->name('login_admin');

    Route::post('/admin_login', [UserController::class, 'check_admin_login'])->name('check_login_admin');

    //admin register
    Route::get('/admin_register', [UserController::class, 'register_admin'])->name('register_admin');

    Route::post('/admin_register', [UserController::class, 'check_register_admin'])->name('check_register_admin');

    Route::get('/admin_actived/{user}/{token}', [UserController::class, 'admin_actived'])->name('admin.actived');

    //Active account
    Route::get('/get_active', [UserController::class, 'getActive'])->name('get_active');

    Route::post('/get_active', [UserController::class, 'postActive'])->name('post_active');

});


//Route clients
Route::prefix('/user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Route::post();
});

// Route admin

Route::get('/admin/login_error', [AdminController::class, 'login_error'])->name('admin_login_error');


Route::prefix('/admin')->middleware('permission.checker:admin|Manager')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Profile

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');

    Route::post('/profile', [ProfileController::class, 'edit_profile'])->name('edit_profile');

    // Branch 
    Route::prefix('/branch')->group(function () {
        
        Route::get('/', [BranchController::class, 'index'])->name('branch.index');

        Route::post('/add-branch', [BranchController::class, 'addBranch'])->name('branch.add');

        Route::post('/update-branch', [BranchController::class, 'update'])->name('branch.update');

        Route::post('/testcai', [BranchController::class, 'testcart'])->name('test');

        Route::post('/delete', [BranchController::class, 'delete'])->name('branch.delete');

        Route::get('/search', [BranchController::class, 'searchBranch'])->name('branch.search');
    });

    //Model
    Route::prefix('/model')->group(function() {

        Route::get('/', [ModelController::class, 'index'])->name('model.index');

        Route::post('/add-model', [ModelController::class, 'addModel'])->name('model.add');
    });


    //Vehicle
    Route::get('/vehicle', [VehicleController::class, 'vehicle'])->name('vehicle');

    Route::post('/vehicle', [VehicleController::class, 'store_vehicle'])->name('store_vehicle');

   Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

});


//Route errors

Route::get('error_403', [ErrorController::class, 'error_403'])->name('403');


//Test view
Route::get('test_view', [UserController::class, 'test_view'])->name('test_view');

//Dark light mode
Route::get('switch-mode', [SwitchModeController::class, 'switch_mode'])->name('switch_mode');