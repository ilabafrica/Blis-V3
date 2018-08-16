<?php


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

Route::post('/register', 'Auth\APIController@register');
Route::post('/login', 'Auth\APIController@login');

Route::group(['prefix' => 'stats'], function () {
    Route::group(['prefix' => 'tests'], function () {
        Route::get('/totals', 'Statistics\TestStatisticsController@testsTotals');
        Route::get('/statuses', 'Statistics\TestStatisticsController@testStatuses');
        Route::get('/types', 'Statistics\TestStatisticsController@testTypes');
        Route::get('/type-categories', 'Statistics\TestStatisticsController@testTypeCategories');
    });
    Route::get('/logins', 'Statistics\UserStatisticsController@logins');
    Route::get('/users', 'Statistics\UserStatisticsController@getUsers');
    Route::get('/users/count', 'Statistics\UserStatisticsController@countUsers');
    Route::get('/genders', 'GenderController@index');

});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Auth\APIController@logout');
    Route::get('/get-user', 'Auth\APIController@getUser');
});
Route::group(['prefix' => 'tpa'], function () {

    Route::post('login', 'ThirdPartyAppAuthController@login');
    Route::post('logout', 'ThirdPartyAppAuthController@logout');
    Route::post('refresh', 'ThirdPartyAppAuthController@refresh');
    Route::post('me', 'ThirdPartyAppAuthController@me');
    Route::post('payload', 'ThirdPartyAppAuthController@payload');
});

Route::group(['middleware' => 'auth:api'], function () {
    // Access Control|Accounts|Permissions|Roles|Assign Permissions|Assign Roles
    Route::group(['middleware' => ['permission:manage_users']], function () {
        Route::resource('address', 'AddressController');
        Route::resource('user', 'UserController');
        Route::resource('permission', 'PermissionController');
        Route::resource('role', 'RoleController');
        Route::get('permissionrole/attach', 'PermissionRoleController@attach');
        Route::get('permissionrole/detach', 'PermissionRoleController@detach');
        Route::get('permissionrole', 'PermissionRoleController@index');
        Route::get('roleuser/attach', 'RoleUserController@attach');
        Route::get('roleuser/detach', 'RoleUserController@detach');
        Route::get('roleuser', 'RoleUserController@index');
    });

    // Health Units|Instrument|Reports|Barcode
    Route::group(['middleware' => ['permission:manage_configurations']], function () {
        Route::resource('adhoccategory', 'AdhocCategoryController');
        Route::resource('adhocoption', 'AdhocOptionController');
        Route::resource('code', 'CodeController');
        Route::resource('counter', 'CounterController');
        Route::resource('organization', 'OrganizationController');
    });

    // Lab Sections|Specimen Types|Specimen Rejection|Test Types|Drugs|Organisms
    Route::group(['middleware' => ['permission:manage_test_catalog']], function () {
        Route::resource('susceptibilitybreakpoint', 'SusceptibilityBreakPointController');
        Route::resource('susceptibilityrange', 'SusceptibilityRangeController');
        Route::get('testtypemapping', 'TestTypeMappingController@index');
        Route::post('testtypemapping/update', 'TestTypeMappingController@update');
        Route::post('testtypemapping/create', 'TestTypeMappingController@create');

        Route::resource('testphase', 'TestPhaseController');
        Route::resource('testStatus', 'TestStatusController');
        Route::resource('testtypecategory', 'TestTypeCategoryController');
        Route::get('specimentypetesttype/attach', 'TestTypeMappingController@attach');
        Route::get('specimentypetesttype/detach', 'TestTypeMappingController@detach');

        Route::resource('testtype', 'TestTypeController');
        Route::resource('rejectionreason', 'RejectionReasonController');
        Route::resource('interpretation', 'InterpretationController');
        Route::resource('measurerange', 'MeasureRangeController');
        Route::resource('measuretype', 'MeasureTypeController');
        Route::resource('measure', 'MeasureController');
        Route::resource('referralreason', 'ReferralReasonController');
        Route::resource('rejectionreason', 'RejectionReasonController');
        Route::resource('specimenstatus', 'SpecimenStatusController');
        Route::resource('specimentype', 'SpecimenTypeController');
        Route::resource('antibiotic', 'AntibioticController');
    });

    // Health Units|Instrument|Reports|Barcode
    Route::group(['middleware' => ['permission:manage_configurations']], function () {
        Route::resource('adhoccategory', 'AdhocCategoryController');
        Route::resource('adhocoption', 'AdhocOptionController');
        Route::resource('code', 'CodeController');
        Route::resource('counter', 'CounterController');
        Route::resource('location', 'LocationController');
    });

    // Lab Sections|Specimen Types|Specimen Rejection|Test Types|Drugs|Organisms
    Route::group(['middleware' => ['permission:manage_test_catalog']], function () {
        Route::resource('susceptibilitybreakpoint', 'SusceptibilityBreakPointController');
        Route::resource('susceptibilityrange', 'SusceptibilityRangeController');
        Route::resource('testmapping', 'TestMappingController');
        Route::resource('testphase', 'TestPhaseController');
        Route::resource('testStatus', 'TestStatusController');
        Route::resource('testtypecategory', 'TestTypeCategoryController');
        Route::resource('testtype', 'TestTypeController');
        Route::resource('rejectionreason', 'RejectionReasonController');
        Route::resource('interpretation', 'InterpretationController');
        Route::resource('measurerange', 'MeasureRangeController');
        Route::resource('measuretype', 'MeasureTypeController');
        Route::resource('measure', 'MeasureController');
        Route::resource('referralreason', 'ReferralReasonController');
        Route::resource('rejectionreason', 'RejectionReasonController');
        Route::resource('specimenstatus', 'SpecimenStatusController');
        Route::resource('specimentype', 'SpecimenTypeController');
    });

    // Registration
    Route::group(['middleware' => ['permission:manage_patients|view_patient_names|request_test']], function () {
        Route::resource('encounterclass', 'EncounterClassController');
        Route::resource('encounterstatus', 'EncounterStatusController');
        Route::resource('encounter', 'EncounterController');
        Route::resource('patient/testrequest', 'PatientController');
        Route::resource('gender', 'GenderController');
        Route::resource('name', 'NameController');
        Route::resource('patient', 'PatientController');
        Route::post('patient/testrequest', 'PatientController@testRequest');
    });

    // Routine and Reference Testing
    Route::group(['middleware' => [
        'permission:accept_test_specimen|'.
        'reject_test_specimen|'.
        'change_test_specimen|'.
        'start_test|'.
        'enter_test_result|'.
        'edit_test_result|'.
        'verify_test_result|'.
        'refer_test_specimen|'.
        'manage_quality_control'],
    ], function () {
        Route::resource('specimenrejection', 'SpecimenRejectionController');
        Route::resource('antibioticsusceptibility', 'AntibioticSusceptibilityController');
        Route::resource('referral', 'ReferralController');
        Route::resource('specimen', 'SpecimenController');
        Route::post('test/specimencollection', 'TestController@specimenCollection');
        Route::post('test/specimenreferral', 'TestController@specimenReferral');
        Route::post('test/specimenrejection', 'TestController@specimenRejection');
        Route::get('test/start/{test_id}', 'TestController@start');
        Route::get('test/verify/{test_id}', 'TestController@verify');
        Route::resource('test', 'TestController');

        Route::post('encounter/addtests', 'EncounterController@addTests');
        Route::post('encounter/specimencollection', 'EncounterController@specimenCollection');
        Route::post('result', 'ResultController@store');
        Route::resource('controltest', 'ControlTestController');
        Route::post('controlresult', 'ControlResultController@store');
        Route::resource('controlmeasurerange', 'ControlMeasureRangeController');
        Route::resource('controlmeasure', 'ControlMeasureController');
        Route::resource('controltype', 'ControlTypeController');
        Route::resource('lot', 'LotController');
        Route::resource('instrument', 'InstrumentController');
    });

    // Stock Card|Stock Book|Commodities|Supliers|Metrics
    Route::group(['middleware' => ['permission:manage_inventory']], function () {
    });

    // Inventory|Maintenance Log|Breakdown|Suplier
    Route::group(['middleware' => ['permission:manage_equipment']], function () {
    });

    // todo: tobe be secured ... out in the open
    Route::get('report', ['uses' => 'ReportController@index']);

    // Summary Log|Incidents|Report
    Route::group(['middleware' => ['permission:manage_biosafty_biosecurity']], function () {
    });
});
