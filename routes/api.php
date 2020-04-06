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

Route::group([
    'middleware' => ['tenant.identify', 'auth:api'],
], function () {

    /* Recruitments */
    Route::get('/recruitments', 'RecruitmentsController@list');
    Route::get('/recruitments/{recruitmentId}', 'RecruitmentsController@get');
    Route::post('/recruitments', 'RecruitmentsController@create');
    Route::patch('/recruitments/{recruitmentId}', 'RecruitmentsController@update');

    /* Form Fields */
    Route::get('/form-fields', 'FormFieldsController@list');
    Route::post('/form-fields', 'FormFieldsController@create');
    Route::patch('/form-fields/{fieldId}', 'FormFieldsController@update');
    Route::delete('/form-fields/{fieldId}', 'FormFieldsController@delete');

    /* Candidates */
    Route::get('/candidates', 'CandidatesController@list');
    Route::get('/candidates/names', 'CandidatesController@names');
    Route::get('/candidates/{candidateId}', 'CandidatesController@get');
    Route::put('/candidates/{candidateId}', 'CandidatesController@update');
    Route::delete('/candidates/{candidateId}', 'CandidatesController@delete');

    /* Notes */
    Route::get('/notes', 'NotesController@get');
    Route::post('/notes', 'NotesController@create');

    /* Predefined messages */
    Route::get('/predefined_messages', 'MessageTemplatesController@list');
    //Route::get('/message_templates', 'MessageTemplatesController@get');

    /* Remaining endpoints */
    Route::get('/sources', 'SourcesController@list');
    Route::post('/sources', 'SourcesController@create');
    Route::put('/change-stage-commands/{commandUUID}', 'CandidatesController@changeStage');
    Route::get('/messages', 'MessagesController@list');
    Route::get('/stages', 'StagesController@list');
});

Route::group([
    'middleware' => [\App\Http\Middleware\IdentifyTenant::class],
], function () {
    Route::get('/candidates/{candidateId}/cv', 'CandidatesController@cv')->name('candidates.cv');
    Route::get('/recruitments/key/{key}', 'RecruitmentsController@getByKey');
    Route::post('/candidates', 'CandidatesController@create'); //TODO: to jest dziura bo dodawac kandydatow bez autoryzacji mozna tylko z formularza zgloszeniowego
});
