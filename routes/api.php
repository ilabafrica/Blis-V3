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

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Auth\APIController@logout');
    Route::get('/get-user', 'Auth\APIController@getUser');
});

Route::group(['middleware' => 'auth:api'], function () {
    // Access Control|Accounts|Permissions|Roles|Assign Permissions|Assign Roles
    Route::group(['middleware' => ['permission:manage_users']], function () {
        Route::resource('address', 'AddressController');
        Route::resource('user', 'UserController');
        Route::resource('permission', 'PermissionController');

	// Health Units|Instrument|Reports|Barcode
	Route::group(['middleware' => ['permission:manage_configurations']], function() {
		Route::resource('adhoccategory', 'AdhocCategoryController');
		Route::resource('adhocoption', 'AdhocOptionController');
		Route::resource('code', 'CodeController');
		Route::resource('counter', 'CounterController');
		Route::resource('facility', 'FacilityController');
	});

	// Lab Sections|Specimen Types|Specimen Rejection|Test Types|Drugs|Organisms
	Route::group(['middleware' => ['permission:manage_test_catalog']], function() {
		Route::resource('susceptibilitybreakpoint', 'SusceptibilityBreakPointController');
		Route::resource('susceptibilityrange', 'SusceptibilityRangeController');
		Route::resource('testmapping', 'TestMappingController');
		Route::resource('testphase', 'TestPhaseController');
		Route::resource('teststatus', 'TestStatusController');
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
		Route::resource('drug', 'DrugController');
	});

        Route::get('permissionrole/attach', 'PermissionRoleController@attach');
        Route::get('permissionrole/detach', 'PermissionRoleController@detach');
        Route::get('permissionrole', 'PermissionRoleController@index');

        Route::resource('roleuser', 'RoleUserController');
        Route::post('roleuser/delete', ['uses' => 'RoleUserController@delete']);
        Route::resource('role', 'RoleController');
    });

    // Health Units|Instrument|Reports|Barcode
    Route::group(['middleware' => ['permission:manage_configurations']], function () {
        Route::resource('adhoccategory', 'AdhocCategoryController');
        Route::resource('adhocoption', 'AdhocOptionController');
        Route::resource('code', 'CodeController');
        Route::resource('counter', 'CounterController');
    });

    // Lab Sections|Specimen Types|Specimen Rejection|Test Types|Drugs|Organisms
    Route::group(['middleware' => ['permission:manage_test_catalog']], function () {
        Route::resource('susceptibilitybreakpoint', 'SusceptibilityBreakPointController');
        Route::resource('susceptibilityrange', 'SusceptibilityRangeController');
        Route::resource('testmapping', 'TestMappingController');
        Route::resource('testphase', 'TestPhaseController');
        Route::resource('teststatus', 'TestStatusController');
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
    Route::group(['middleware' => ['permission:manage_patients|view_patient_names']], function () {
        Route::resource('breed', 'BreedController');
        Route::resource('encounterclass', 'EncounterClassController');
        Route::resource('encounterstatus', 'EncounterStatusController');
        Route::resource('encounter', 'EncounterController');
        Route::resource('gender', 'GenderController');
        Route::resource('location', 'LocationController');
        Route::resource('maritalstatus', 'MaritalStatusController');
        Route::resource('name', 'NameController');
        Route::resource('organization', 'OrganizationController');
        Route::resource('patient', 'PatientController');
        Route::resource('practitioner', 'PractitionerController');
        Route::resource('species', 'SpeciesController');
        Route::resource('telecom', 'TelecomController');
    });

    // Routine and Reference Testing
    Route::group(['middleware' => ['permission:accept_test_specimen|'.
        'reject_test_specimen|'.
        'change_test_specimen|'.
        'start_test|'.
        'enter_test_results|'.
        'edit_test_results|'.
        'verify_test_results|'.
        'refer_test_specimens|'.
        'manage_quality_control', ],
    ], function () {
        Route::resource('specimenrejection', 'SpecimenRejectionController');
        Route::resource('antibioticsusceptibility', 'AntibioticSusceptibilityController');
        Route::resource('antibiotic', 'AntibioticController');
        Route::resource('collection', 'CollectionController');
        Route::resource('referral', 'ReferralController');
        Route::resource('result', 'ResultController');
        Route::resource('specimen', 'SpecimenController');
        Route::resource('test', 'TestController');
        Route::resource('controlresult', 'ControlResultController');
        Route::resource('controltest', 'ControlTestController');
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


Route::get('report', ["uses" => "ReportController@index"]);
// these below are just for testing how ever
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

    // Summary Log|Incidents|Report
    Route::group(['middleware' => ['permission:manage_biosafty_biosecurity']], function () {
    });
});

// todo: tobe be secured ... out in the open
Route::get('report', ['uses' => 'ReportController@index']);

