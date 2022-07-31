<?php

use Illuminate\Support\Facades\Redirect;
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
    return Redirect::to('/admin');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('branches')->name('branches/')->group(static function() {
            Route::get('/',                                             'BranchesController@index')->name('index');
            Route::get('/create',                                       'BranchesController@create')->name('create');
            Route::post('/',                                            'BranchesController@store')->name('store');
            Route::get('/{branch}/edit',                                'BranchesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BranchesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{branch}',                                    'BranchesController@update')->name('update');
            Route::delete('/{branch}',                                  'BranchesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('agents')->name('agents/')->group(static function() {
            Route::get('/',                                             'AgentsController@index')->name('index');
            Route::get('/create',                                       'AgentsController@create')->name('create');
            Route::post('/',                                            'AgentsController@store')->name('store');
            Route::get('/{agent}/edit',                                 'AgentsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AgentsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{agent}',                                     'AgentsController@update')->name('update');
            Route::delete('/{agent}',                                   'AgentsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('partners')->name('partners/')->group(static function() {
            Route::get('/',                                             'PartnersController@index')->name('index');
            Route::get('/create',                                       'PartnersController@create')->name('create');
            Route::post('/',                                            'PartnersController@store')->name('store');
            Route::get('/{partner}/edit',                               'PartnersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PartnersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{partner}',                                   'PartnersController@update')->name('update');
            Route::delete('/{partner}',                                 'PartnersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('pay-statuses')->name('pay-statuses/')->group(static function() {
            Route::get('/',                                             'PayStatusesController@index')->name('index');
            Route::get('/create',                                       'PayStatusesController@create')->name('create');
            Route::post('/',                                            'PayStatusesController@store')->name('store');
            Route::get('/{payStatus}/edit',                             'PayStatusesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PayStatusesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{payStatus}',                                 'PayStatusesController@update')->name('update');
            Route::delete('/{payStatus}',                               'PayStatusesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('pay-types')->name('pay-types/')->group(static function() {
            Route::get('/',                                             'PayTypesController@index')->name('index');
            Route::get('/create',                                       'PayTypesController@create')->name('create');
            Route::post('/',                                            'PayTypesController@store')->name('store');
            Route::get('/{payType}/edit',                               'PayTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PayTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{payType}',                                   'PayTypesController@update')->name('update');
            Route::delete('/{payType}',                                 'PayTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('contract-lists')->name('contract-lists/')->group(static function() {
            Route::get('/',                                             'ContractListsController@index')->name('index');
            Route::get('/create',                                       'ContractListsController@create')->name('create');
            Route::post('/',                                            'ContractListsController@store')->name('store');
            Route::get('/{contractList}/edit',                          'ContractListsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ContractListsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{contractList}',                              'ContractListsController@update')->name('update');
            Route::delete('/{contractList}',                            'ContractListsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('contract-list-months')->name('contract-list-months/')->group(static function() {
            Route::get('/{contractList}/month',                         'ContractListMonthsController@index')->name('index');
            Route::get('/create',                                       'ContractListMonthsController@create')->name('create');
            Route::post('/',                                            'ContractListMonthsController@store')->name('store');
            Route::get('/{contractListMonth}/edit',                     'ContractListMonthsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ContractListMonthsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{contractListMonth}',                         'ContractListMonthsController@update')->name('update');
            Route::delete('/{contractListMonth}',                       'ContractListMonthsController@destroy')->name('destroy');
            Route::get('/{contractListMonth}/download',                 'ContractListMonthsController@download')->name('download');
        });
    });
});

