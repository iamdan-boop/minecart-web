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

Route::redirect('/', 'login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'signUp'])->name('register.sign-up');
});


Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'admin', 'middleware' => 'is_admin'], function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');


        // Accounts
        Route::put('/updateToUser/{account}', [\App\Http\Controllers\AccountController::class, 'updateToUserRole'])->name('account.toUserRole');
        Route::put('/updateToBantay/{account}', [\App\Http\Controllers\AccountController::class, 'updateToBantayRole'])->name('account.toBantayRole');


        // Items
        Route::group(['prefix' => 'items', 'controller' => \App\Http\Controllers\ItemController::class], function () {
            Route::get('/for-approval', 'approvalItemsView')->name('items.for-approval.index');
            Route::get('/for-claiming', 'claimingItemsView')->name('items.for-claiming.index');
            Route::get('/claimed', 'claimedItemsView')->name('items.claimed.index');
            Route::get('/pullouts', 'pulloutItemsView')->name('items.pullout.index');
            Route::put('/{item}/approve', 'updateApprove')->name('items.update-approve');
            Route::put('/{item}/moveToPullout', 'updateMoveToPullout')->name('items.update-moveToPullout');
            Route::put('/{item}/claim', 'updateItemClaim')->name('items.claim.update');
            Route::put('/{item}/update-claim', 'updateItemClaimed')->name('items.update-claimed');
            Route::put('/{item}/return', 'updateItemReturn')->name('items.update-return');
        });


        // Cashouts
        Route::group(['prefix' => 'cashouts', 'controller' => \App\Http\Controllers\CashoutController::class], function () {
            Route::get('/', 'index')->name('cashouts.index');
            Route::get('/to-claim', 'toClaimCashoutsView')->name('cashouts.claim.index');
            Route::get('/cashout-logs', 'cashoutLogsView')->name('cashouts.logs.index');
            Route::put('/{cashout}/approve', 'approveCashout')->name('cashouts.approve');
            Route::put('/{cashout}/decline', 'declineCashout')->name('cashouts.decline');
            Route::put('/{cashout}/approveClaim', 'approveCashoutClaimed')->name('cashouts.approved.claim');
        });


        Route::get('/transactions', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index.filter');
        Route::get('/transactions-income', [\App\Http\Controllers\TransactionController::class, 'incomeLogView'])->name('transactions.income.index');
        Route::post('/transactions-income', [\App\Http\Controllers\TransactionController::class, 'incomeLogView'])->name('transactions.income.filter');
        Route::get('/transactions-income-user', [\App\Http\Controllers\TransactionController::class, 'userIncomeLogView'])->name('transactions.income-user.index');
        Route::put('/transaction/{user}', [\App\Http\Controllers\TransactionController::class, 'resetWallet'])->name('transaction.reset-wallet');

        Route::resources([
            'accounts' => \App\Http\Controllers\AccountController::class,
            'items' => \App\Http\Controllers\ItemController::class,
            'announcements' => \App\Http\Controllers\AnnouncementController::class,
        ]);
    });


    Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
        Route::get('/dashboard', [\App\Http\Controllers\Customer\CustomerDashboardController::class, 'index'])->name('dashboard.index');


        // items
        Route::get('/items/pull-out', [\App\Http\Controllers\Customer\CustomerItemController::class, 'pulloutItemsView'])->name('items.pull-out.index');

        Route::resources([
            'items' => \App\Http\Controllers\Customer\CustomerItemController::class,
            'cashouts' => \App\Http\Controllers\Customer\CustomerCashoutController::class,
        ]);
    });


    Route::post('/logout', \App\Http\Controllers\LogoutController::class)
        ->withoutMiddleware('is_admin')
        ->name('logout');

    Route::put('/update/profile', \App\Http\Controllers\ProfileController::class)->name('update.profile');
});
