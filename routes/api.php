<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Auto-generated admin routes */
Route::prefix('branches')->namespace('App\Http\Controllers\Api')->name('branches/')->group(static function() {
    Route::get('/', 'ApiBranchesController@index')->name('index');
});

Route::prefix('partners')->namespace('App\Http\Controllers\Api')->name('partners/')->group(static function() {
    Route::get('/', 'ApiPartnersController@index')->name('index');
    Route::get('/getBin', 'ApiPartnersController@getAllBin')->name('getAllBin');
    Route::get('/getBin/{partnerId}', 'ApiPartnersController@getBin')->name('getBin');
});

Route::prefix('agents')->namespace('App\Http\Controllers\Api')->name('agents/')->group(static function() {
    Route::get('/', 'ApiAgentsController@index')->name('index');
    Route::get('/{contractId}', 'ApiAgentsController@getByContractId')->name('getByContractId');
});

Route::prefix('pay-statuses')->namespace('App\Http\Controllers\Api')->name('pay-statuses/')->group(static function() {
    Route::get('/', 'ApiPayStatusesController@index')->name('index');
});

Route::prefix('pay-types')->namespace('App\Http\Controllers\Api')->name('pay-types/')->group(static function() {
    Route::get('/', 'ApiPayTypesController@index')->name('index');
});

Route::prefix('contract-list')->namespace('App\Http\Controllers\Api')->name('contract-list/')->group(static function() {
    Route::get('/export/', 'ApiContractListsController@export')->name('export');
});

Route::prefix('contract-list-month')->namespace('App\Http\Controllers\Api')->name('contract-list-month/')->group(static function() {
    Route::get('/download-delete-doc-file/{fileName}', 'ApiContractListMonthsController@downloadAndDelete')->name('downloadAndDelete');
    Route::post('/download-doc', 'ApiContractListMonthsController@downloadDocx')->name('downloadDocx');
});


