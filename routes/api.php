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

Route::group(['middleware' => 'auth:api'], function () {
	Route::resource('address', 'AddressController');
	Route::resource('adhoccategory', 'AdhocCategoryController');
	Route::resource('adhocoption', 'AdhocOptionController');
	Route::resource('rejectionreason', 'RejectionReasonController');
	Route::resource('specimenrejection', 'SpecimenRejectionController');
	Route::resource('antibioticsusceptibility', 'AntibioticSusceptibilityController');
	Route::resource('antibiotic', 'AntibioticController');
	Route::resource('breed', 'BreedController');
	Route::resource('codeableconcept', 'CodeableConceptController');
	Route::resource('collection', 'CollectionController');
	Route::resource('counter', 'CounterController');
	Route::resource('encounterclass', 'EncounterClassController');
	Route::resource('encounterstatus', 'EncounterStatusController');
	Route::resource('encounter', 'EncounterController');
	Route::resource('gender', 'GenderController');
	Route::resource('interpretation', 'InterpretationController');
	Route::resource('location', 'LocationController');
	Route::resource('maritalstatus', 'MaritalStatusController');
	Route::resource('measurerange', 'MeasureRangeController');
	Route::resource('measuretype', 'MeasureTypeController');
	Route::resource('measure', 'MeasureController');
	Route::resource('name', 'NameController');
	Route::resource('organization', 'OrganizationController');
	Route::resource('patient', 'PatientController');
	Route::resource('permission', 'PermissionController');
	Route::resource('practitioner', 'PractitionerController');
	Route::resource('referralreason', 'ReferralReasonController');
	Route::resource('referral', 'ReferralController');
	Route::resource('rejectionreason', 'RejectionReasonController');
	Route::resource('result', 'ResultController');
	Route::resource('role', 'RoleController');
	Route::resource('species', 'SpeciesController');
	Route::resource('specimenstatus', 'SpecimenStatusController');
	Route::resource('specimentype', 'SpecimenTypeController');
	Route::resource('specimen', 'SpecimenController');
	Route::resource('susceptibilitybreakpoint', 'SusceptibilityBreakPointController');
	Route::resource('susceptibilityrange', 'SusceptibilityRangeController');
	Route::resource('telecom', 'TelecomController');
	Route::resource('testphase', 'TestPhaseController');
	Route::resource('teststatus', 'TestStatusController');
	Route::resource('testtypecategory', 'TestTypeCategoryController');
	Route::resource('testtype', 'TestTypeController');
	Route::resource('test', 'TestController');
	Route::resource('user', 'UserController');
});
