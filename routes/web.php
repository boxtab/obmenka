<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Route::get('/access-denied', function () {
    return view('access-denied');
})->name('access-denied');

Auth::routes([
    'login' => true,
    'logout' => true,
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('table-list', function () {
        return view('pages.table_list');
    })->name('table');

    Route::get('typography', function () {
        return view('pages.typography');
    })->name('typography');

    Route::get('icons', function () {
        return view('pages.icons');
    })->name('icons');

    Route::get('map', function () {
        return view('pages.map');
    })->name('map');

    Route::get('notifications', function () {
        return view('pages.notifications');
    })->name('notifications');

    Route::get('rtl-support', function () {
        return view('pages.language');
    })->name('language');

    Route::get('upgrade', function () {
        return view('pages.upgrade');
    })->name('upgrade');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::any('/test', 'App\Http\Controllers\TestController@index');
});

Route::group(['prefix' => 'currency', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'currency.index', 'uses' => 'App\Http\Controllers\Books\CurrencyController@index']);
    Route::post('', ['as' => 'currency.store', 'uses' => 'App\Http\Controllers\Books\CurrencyController@store']);
    Route::get('/create', ['as' => 'currency.create', 'uses' => 'App\Http\Controllers\Books\CurrencyController@create']);
    Route::get('/{currency}/edit', ['as' => 'currency.edit', 'uses' => 'App\Http\Controllers\Books\CurrencyController@edit']);
    Route::post('/{currency}', ['as' => 'currency.destroy', 'uses' => 'App\Http\Controllers\Books\CurrencyController@destroy']);
});

Route::group(['prefix' => 'payment-system', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'payment-system.index', 'uses' => 'App\Http\Controllers\Books\PaymentSystemController@index']);
    Route::post('', ['as' => 'payment-system.store', 'uses' => 'App\Http\Controllers\Books\PaymentSystemController@store']);
    Route::get('/create', ['as' => 'payment-system.create', 'uses' => 'App\Http\Controllers\Books\PaymentSystemController@create']);
    Route::get('/{paymentSystem}/edit', ['as' => 'payment-system.edit', 'uses' => 'App\Http\Controllers\Books\PaymentSystemController@edit']);
    Route::post('/{paymentSystem}', ['as' => 'payment-system.destroy', 'uses' => 'App\Http\Controllers\Books\PaymentSystemController@destroy']);
});

Route::group(['prefix' => 'box', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'box.index', 'uses' => 'App\Http\Controllers\Books\BoxController@index']);
    Route::post('', ['as' => 'box.store', 'uses' => 'App\Http\Controllers\Books\BoxController@store']);
    Route::get('/create', ['as' => 'box.create', 'uses' => 'App\Http\Controllers\Books\BoxController@create']);
    Route::get('/{box}/edit', ['as' => 'box.edit', 'uses' => 'App\Http\Controllers\Books\BoxController@edit']);
    Route::post('/{box}', ['as' => 'box.destroy', 'uses' => 'App\Http\Controllers\Books\BoxController@destroy']);
});

Route::group(['prefix' => 'partners', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'partners.index', 'uses' => 'App\Http\Controllers\Books\PartnersController@index']);
    Route::post('', ['as' => 'partners.store', 'uses' => 'App\Http\Controllers\Books\PartnersController@store']);
    Route::get('/create', ['as' => 'partners.create', 'uses' => 'App\Http\Controllers\Books\PartnersController@create']);
    Route::get('/{partners}/edit', ['as' => 'partners.edit', 'uses' => 'App\Http\Controllers\Books\PartnersController@edit']);
    Route::post('/{partners}', ['as' => 'partners.destroy', 'uses' => 'App\Http\Controllers\Books\PartnersController@destroy']);
});

Route::group(['prefix' => 'dds', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'dds.index', 'uses' => 'App\Http\Controllers\Books\DDSController@index']);
    Route::post('', ['as' => 'dds.store', 'uses' => 'App\Http\Controllers\Books\DDSController@store']);
    Route::get('/create', ['as' => 'dds.create', 'uses' => 'App\Http\Controllers\Books\DDSController@create']);
    Route::get('/{dds}/edit', ['as' => 'dds.edit', 'uses' => 'App\Http\Controllers\Books\DDSController@edit']);
    Route::post('/{dds}', ['as' => 'dds.destroy', 'uses' => 'App\Http\Controllers\Books\DDSController@destroy']);
});

Route::group(['prefix' => 'top-destinations', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'top-destinations.index', 'uses' => 'App\Http\Controllers\Books\TopDestinationsController@index']);
    Route::post('', ['as' => 'top-destinations.store', 'uses' => 'App\Http\Controllers\Books\TopDestinationsController@store']);
    Route::get('/create', ['as' => 'top-destinations.create', 'uses' => 'App\Http\Controllers\Books\TopDestinationsController@create']);
    Route::get('/{topDestinations}/edit', ['as' => 'top-destinations.edit', 'uses' => 'App\Http\Controllers\Books\TopDestinationsController@edit']);
    Route::post('/{topDestinations}', ['as' => 'top-destinations.destroy', 'uses' => 'App\Http\Controllers\Books\TopDestinationsController@destroy']);
});

Route::group(['prefix' => 'top-destinations-group', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'top-destinations-group.index', 'uses' => 'App\Http\Controllers\Books\TopDestinationsGroupController@index']);
    Route::post('', ['as' => 'top-destinations-group.store', 'uses' => 'App\Http\Controllers\Books\TopDestinationsGroupController@store']);
    Route::get('/create', ['as' => 'top-destinations-group.create', 'uses' => 'App\Http\Controllers\Books\TopDestinationsGroupController@create']);
    Route::get('/{topDestinationsGroup}/edit', ['as' => 'top-destinations-group.edit', 'uses' => 'App\Http\Controllers\Books\TopDestinationsGroupController@edit']);
    Route::post('/{topDestinationsGroup}', ['as' => 'top-destinations-group.destroy', 'uses' => 'App\Http\Controllers\Books\TopDestinationsGroupController@destroy']);
});


Route::group(['prefix' => 'income-expense', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::match(['GET', 'POST'], '', ['as' => 'income-expense.index', 'uses' => 'App\Http\Controllers\IncomeExpenseController@index']);
    Route::post('/list', ['as' => 'income-expense.list', 'uses' => 'App\Http\Controllers\IncomeExpenseController@getList']);
    Route::get('/reset-filter', ['as' => 'income-expense.reset-filter', 'uses' => 'App\Http\Controllers\IncomeExpenseController@resetFilter']);
    Route::post('/store', ['as' => 'income-expense.store', 'uses' => 'App\Http\Controllers\IncomeExpenseController@store']);
    Route::get('/create/{type}', ['as' => 'income-expense.create', 'uses' => 'App\Http\Controllers\IncomeExpenseController@create']);
    Route::get('/{incomeExpense}/edit', ['as' => 'income-expense.edit', 'uses' => 'App\Http\Controllers\IncomeExpenseController@edit']);
    Route::post('/{incomeExpense}', ['as' => 'income-expense.destroy', 'uses' => 'App\Http\Controllers\IncomeExpenseController@destroy']);
    Route::get('/export', ['as' => 'income-expense.export', 'uses' => 'App\Http\Controllers\IncomeExpenseController@export']);
    //Route::get('/export-test', ['as' => 'income-expense.export-test', 'uses' => 'App\Http\Controllers\IncomeExpenseController@exportTest']);
});

Route::group(['prefix' => 'bid', 'middleware' => ['auth', 'role:admin/economist/manager']], function () {
    Route::match(['GET', 'POST'], '', ['as' => 'bid.index', 'uses' => 'App\Http\Controllers\BidController@index']);
    Route::post('/list', ['as' => 'bid.list', 'uses' => 'App\Http\Controllers\BidController@getBidList']);
    Route::post('/add-offer', ['as' => 'bid.add-offer', 'uses' => 'App\Http\Controllers\BidController@addOffer']);
    Route::get('/reset-filter', ['as' => 'bid.reset-filter', 'uses' => 'App\Http\Controllers\BidController@resetFilter']);
    Route::post('/store', ['as' => 'bid.store', 'uses' => 'App\Http\Controllers\BidController@store']);
    Route::get('/create', ['as' => 'bid.create', 'uses' => 'App\Http\Controllers\BidController@create']);
    Route::get('/{bid}/edit', ['as' => 'bid.edit', 'uses' => 'App\Http\Controllers\BidController@edit']);
    Route::post('/{bid}', ['as' => 'bid.destroy', 'uses' => 'App\Http\Controllers\BidController@destroy']);
    Route::get('/export', ['as' => 'bid.export', 'uses' => 'App\Http\Controllers\BidController@export']);
});

Route::group(['prefix' => 'average-rate', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'average-rate.index', 'uses' => 'App\Http\Controllers\AverageRateController@index']);
    Route::post('/clear', ['as' => 'average-rate.clear', 'uses' => 'App\Http\Controllers\AverageRateController@clear']);
    Route::post('/build', ['as' => 'average-rate.build', 'uses' => 'App\Http\Controllers\AverageRateController@build']);
});

Route::group(['prefix' => 'role', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('', ['as' => 'role.index', 'uses' => 'App\Http\Controllers\Books\RoleController@index']);
    Route::post('', ['as' => 'role.store', 'uses' => 'App\Http\Controllers\Books\RoleController@store']);
    Route::get('/create', ['as' => 'role.create', 'uses' => 'App\Http\Controllers\Books\RoleController@create']);
    Route::get('/{role}/edit', ['as' => 'role.edit', 'uses' => 'App\Http\Controllers\Books\RoleController@edit']);
    Route::post('/{role}', ['as' => 'role.destroy', 'uses' => 'App\Http\Controllers\Books\RoleController@destroy']);
});

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('', ['as' => 'user.index', 'uses' => 'App\Http\Controllers\UserController@index']);
    Route::post('', ['as' => 'user.store', 'uses' => 'App\Http\Controllers\UserController@store']);
    Route::get('/create', ['as' => 'user.create', 'uses' => 'App\Http\Controllers\UserController@create']);
    Route::get('/{user}/edit', ['as' => 'user.edit', 'uses' => 'App\Http\Controllers\UserController@edit']);
    Route::post('/{user}', ['as' => 'user.destroy', 'uses' => 'App\Http\Controllers\UserController@destroy']);
});


Route::group(['prefix' => 'direction', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'direction.index', 'uses' => 'App\Http\Controllers\Books\DirectionController@index']);
    Route::post('', ['as' => 'direction.store', 'uses' => 'App\Http\Controllers\Books\DirectionController@store']);
    Route::get('/create', ['as' => 'direction.create', 'uses' => 'App\Http\Controllers\Books\DirectionController@create']);
    Route::get('/{direction}/edit', ['as' => 'direction.edit', 'uses' => 'App\Http\Controllers\Books\DirectionController@edit']);
    Route::post('/{direction}', ['as' => 'direction.destroy', 'uses' => 'App\Http\Controllers\Books\DirectionController@destroy']);
});


Route::group(['prefix' => 'offer', 'middleware' => ['auth', 'role:admin/economist/manager']], function () {
    Route::post('/destroy/{offer}', ['as' => 'offer.destroy', 'uses' => 'App\Http\Controllers\BidController@destroyOffer']);
//    Route::post('/update/', ['as' => 'offer.update', 'uses' => 'App\Http\Controllers\BidController@updateOffer']);
});

Route::group(['prefix' => 'box-balance', 'middleware' => ['auth', 'role:admin/economist/manager']], function () {
    Route::match(['GET', 'POST'], '', ['as' => 'box-balance.index', 'uses' => 'App\Http\Controllers\BoxBalanceController@index']);
//    Route::post('/list', ['as' => 'box-balance.list', 'uses' => 'App\Http\Controllers\BoxBalanceController@getList']);
    Route::get('/reset-filter', ['as' => 'box-balance.reset-filter', 'uses' => 'App\Http\Controllers\BoxBalanceController@resetFilter']);
    Route::post('/store', ['as' => 'box-balance.store', 'uses' => 'App\Http\Controllers\BoxBalanceController@store']);
    Route::get('/create', ['as' => 'box-balance.create', 'uses' => 'App\Http\Controllers\BoxBalanceController@create']);
    Route::get('/{boxBalance}/edit', ['as' => 'box-balance.edit', 'uses' => 'App\Http\Controllers\BoxBalanceController@edit']);
    Route::post('/destroy/{boxBalance}', ['as' => 'box-balance.destroy', 'uses' => 'App\Http\Controllers\BoxBalanceController@destroy']);
    Route::post('/duplicate', ['as' => 'box-balance.duplicate', 'uses' => 'App\Http\Controllers\BoxBalanceController@duplicate']);
    Route::post('/update-amount', ['as' => 'box-balance.update-amount', 'uses' => 'App\Http\Controllers\BoxBalanceController@updateAmount']);
    Route::get('/export', ['as' => 'box-balance.export', 'uses' => 'App\Http\Controllers\BoxBalanceController@export']);
});

Route::group(['prefix' => 'client', 'middleware' => ['auth', 'role:admin/economist/manager']], function () {
    Route::get('', ['as' => 'client.index', 'uses' => 'App\Http\Controllers\Books\ClientController@index']);
    Route::post('', ['as' => 'client.store', 'uses' => 'App\Http\Controllers\Books\ClientController@store']);
    Route::get('/create', ['as' => 'client.create', 'uses' => 'App\Http\Controllers\Books\ClientController@create']);
    Route::get('/{client}/edit', ['as' => 'client.edit', 'uses' => 'App\Http\Controllers\Books\ClientController@edit']);
    Route::post('/{client}', ['as' => 'client.destroy', 'uses' => 'App\Http\Controllers\Books\ClientController@destroy']);
});

Route::group(['prefix' => 'initial-rate', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'initial-rate.index', 'uses' => 'App\Http\Controllers\InitialRateController@index']);
    Route::post('/update', ['as' => 'initial-rate.update', 'uses' => 'App\Http\Controllers\InitialRateController@update']);
});

Route::group(['prefix' => 'initial-box', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::get('', ['as' => 'initial-box.index', 'uses' => 'App\Http\Controllers\InitialBoxController@index']);
    Route::post('/update', ['as' => 'initial-box.update', 'uses' => 'App\Http\Controllers\InitialBoxController@update']);
});

/**
 * Отчеты.
 */
Route::group(['prefix' => 'reports', 'middleware' => ['auth', 'role:admin/economist']], function () {
    Route::match(['GET', 'POST'], '/profit-day', ['as' => 'reports.profit-day.index', 'uses' => 'App\Http\Controllers\Reports\ProfitDayController@index']);
    Route::match(['GET', 'POST'],'/profit-month', ['as' => 'reports.profit-month.index', 'uses' => 'App\Http\Controllers\Reports\ProfitMonthController@index']);
    Route::match(['GET', 'POST'], '/profit-direction', ['as' => 'reports.profit-direction.index', 'uses' => 'App\Http\Controllers\Reports\ProfitDirectionController@index']);
    Route::match(['GET', 'POST'], '/profit-source', ['as' => 'reports.profit-source.index', 'uses' => 'App\Http\Controllers\Reports\ProfitSourceController@index']);
});
