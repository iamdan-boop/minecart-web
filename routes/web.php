<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'signUp'])->name('register.sign-up');
});


Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');


    Route::put('/updateToUser/{account}', [\App\Http\Controllers\AccountController::class, 'updateToUserRole'])->name('account.toUserRole');
    Route::put('/updateToBantay/{account}', [\App\Http\Controllers\AccountController::class, 'updateToBantayRole'])->name('account.toBantayRole');
    Route::resources([
        'accounts' => \App\Http\Controllers\AccountController::class,
        'items' => \App\Http\Controllers\ItemController::class,
        'announcements' => \App\Http\Controllers\AnnouncementController::class,
    ]);


    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        auth()->logout();
        $request->session()->regenerate();
        return redirect()->route('login.index');
    })->name('logout');
});
