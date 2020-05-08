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

Route::group([
    'prefix' => '/{tenant}',
    'middleware' => ['tenant.identify', 'auth:api'],
    'as' => 'tenant:',
], function () {

    /* Users */
    Route::get('/me', 'UsersController@me');

    /* Recruitments */
    Route::get('/recruitments', 'RecruitmentsController@list');
    Route::get('/recruitments/{recruitmentId}', 'RecruitmentsController@get');
    Route::post('/recruitments', 'RecruitmentsController@create');
    Route::patch('/recruitments/{recruitmentId}', 'RecruitmentsController@update');
    Route::put('/commands/recruitment-close/{recruitmentId}', 'RecruitmentsController@close');

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
    Route::post('/candidates', 'CandidatesController@create');
    Route::delete('/candidates/{candidateId}', 'CandidatesController@delete');

    /* Notes */
    Route::get('/notes', 'NotesController@get');
    Route::post('/notes', 'NotesController@create');

    /* Predefined messages */
    Route::get('/predefined_messages', 'MessageTemplatesController@list');
    Route::patch('/predefined_messages/{messageId}', 'MessageTemplatesController@update');
    Route::get('/predefined_messages/parsed/', 'MessageTemplatesController@getParsed');

    /* Sources */
    Route::get('/sources', 'SourcesController@list');
    Route::post('/sources', 'SourcesController@create');
    Route::delete('/sources/{sourceId}', 'SourcesController@delete');

    /* Remaining endpoints */
    Route::put('/change-stage-commands/{commandUUID}', 'CandidatesController@changeStage');
    Route::get('/messages', 'MessagesController@list');
    Route::get('/stages', 'StagesController@list');
    Route::get('/activities', 'ActivitiesController@list');
});

Route::group([
    'prefix' => '/{tenant}',
    'middleware' => [\App\Http\Middleware\IdentifyTenant::class],
    'as' => 'tenant:',
], function () {
    Route::get('/candidates/{candidateId}/cv', 'CandidatesController@cv')->name('candidates.cv');
    Route::post('/apply', 'ApplyController@apply');
    Route::get('/apply-form/{sourceKey}', 'ApplyController@applyForm');
});

Route::group([
    'prefix' => '/{tenant}',
    'middleware' => ['api.addAccessToken', 'tenant.identify', 'auth:api'],
    'as' => 'tenant:',
], function () {
    Route::get('/message_preview/{messageId}', 'MessagePreview@render')->name('message_preview.render');
});
