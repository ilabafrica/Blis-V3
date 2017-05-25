<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('patient', 'PatientController');
Route::resource('test', 'TestController');
Route::resource('specimen', 'SpecimenController');
Route::resource('testtype', 'TesttypeController');
Route::resource('report', 'ReportController');
Route::resource('inventory', 'InventoryController');
Route::resource('supplier', 'SupplierController');
Route::resource('item', 'ItemController');
Route::resource('facility', 'FacilityController');
Route::resource('drug', 'DrugController');
Route::resource('critical', 'CriticalController');
Route::resource('stock', 'StockController');
Route::resource('permission', 'PermissionController');
Route::resource('role', 'RoleController');
Route::resource('assignment', 'AssignmentController');
Route::resource('measure', 'MeasureController');
Route::resource('control', 'ControlController');