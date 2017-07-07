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
Route::resource('address', 'AddressController');
Route::resource('careteampractitioner', 'CareTeamPractitionerController');
Route::resource('careteam', 'CareTeamController');
Route::resource('codeableconcept', 'CodeableConceptController');
Route::resource('coding', 'CodingController');
Route::resource('collection', 'CollectionController');
Route::resource('componenttype', 'ComponentTypeController');
Route::resource('component', 'ComponentController');
Route::resource('contactpoint', 'ContactPointController');
Route::resource('container', 'ContainerController');
Route::resource('episodeofcarediagnosis', 'EpisodeOfCareDiagnosisController');
Route::resource('episodeofcare', 'EpisodeofCareController');
Route::resource('humanname', 'HumanNameController');
Route::resource('ingredient', 'IngredientController');
Route::resource('migration', 'MigrationController');
Route::resource('oauthaccesstoken', 'OauthAccessTokenController');
Route::resource('oauthauthcode', 'OauthAuthCodeController');
Route::resource('oauthclient', 'OauthClientController');
Route::resource('oauthpersonalaccessclient', 'OauthPersonalAccessClientController');
Route::resource('oauthrefreshtoken', 'OauthRefreshTokenController');
Route::resource('observationtype', 'ObservationTypeController');
Route::resource('observation', 'ObservationController');
Route::resource('organizationcontact', 'OrganizationContactController');
Route::resource('organization', 'OrganizationController');
Route::resource('paneltype', 'PanelTypeController');
Route::resource('panel', 'PanelController');
Route::resource('passwordreset', 'PasswordResetController');
Route::resource('patientcommunication', 'PatientCommunicationController');
Route::resource('patientcontact', 'PatientContactController');
Route::resource('patientlink', 'PatientLinkController');
Route::resource('patient', 'PatientController');
Route::resource('practitionercommunication', 'PractitionerCommunicationController');
Route::resource('practitionerqualification', 'PractitionerQualificationController');
Route::resource('practitioner', 'PractitionerController');
Route::resource('procedurerequest', 'ProcedureRequestController');
Route::resource('processing', 'ProcessingController');
Route::resource('quantity', 'QuantityController');
Route::resource('referencerange', 'ReferenceRangeController');
Route::resource('referralrequest', 'ReferralRequestController');
Route::resource('specimen', 'SpecimenController');
Route::resource('statushistory', 'StatusHistoryController');
Route::resource('status', 'StatusController');
Route::resource('substance', 'SubstanceController');
Route::resource('usertype', 'UserTypeController');
Route::resource('user', 'UserController');
