
<?php

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
Route::resource('critiical', 'CritiicalController');
Route::resource('stock', 'StockController');
Route::resource('permission', 'PermissionController');
Route::resource('role', 'RoleController');
Route::resource('assignment', 'AssignmentController');
Route::resource('measure', 'MeasureController');
Route::resource('control', 'ControlController');