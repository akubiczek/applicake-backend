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
    Route::get('/users', 'UsersController@list')->middleware(['can:read users']);
    Route::patch('/users/{user}', 'UsersController@update')->middleware(['can:update users']);
    Route::delete('/users/{userId}', 'UsersController@delete')->middleware(['can:delete users']);
    Route::post('/invites', 'UsersController@invite')->middleware(['can:create users']);

    /* Recruitments */
    Route::get('/recruitments', 'RecruitmentsController@list');
    Route::get('/recruitments/{recruitment}', 'RecruitmentsController@get')->middleware(['can:view,recruitment']);
    Route::post('/recruitments', 'RecruitmentsController@create')->middleware(['can:create,App\Models\Recruitment']);
    Route::patch('/recruitments/{recruitment}', 'RecruitmentsController@update')->middleware(['can:update,recruitment']);
    Route::post('/commands/recruitment-close/{recruitment}', 'RecruitmentsController@close')->middleware(['can:close,recruitment']);
    Route::post('/commands/recruitment-reopen/{recruitment}', 'RecruitmentsController@reopen')->middleware(['can:reopen,recruitment']);
    Route::post('/commands/recruitment-duplicate/{recruitment}', 'RecruitmentsController@duplicate')->middleware(['can:duplicate,recruitment']);

    /* Granted users to specific recruitments */
    Route::get('/recruitments/{recruitment}/granted-users', 'RecruitmentUserController@list')->middleware(['can:list,App\Models\RecruitmentUser']);
    Route::post('/recruitments/{recruitment}/granted-users', 'RecruitmentUserController@create')->middleware(['can:create,App\Models\RecruitmentUser']);
    Route::delete('/recruitments/{recruitment}/granted-users/{userId}', 'RecruitmentUserController@delete')->middleware(['can:delete,App\Models\RecruitmentUser']);

    /* Form Fields */
    Route::get('/form-fields', 'FormFieldsController@list');
    Route::post('/form-fields', 'FormFieldsController@create');
    Route::patch('/form-fields/{fieldId}', 'FormFieldsController@update');
    Route::delete('/form-fields/{fieldId}', 'FormFieldsController@delete');
    Route::patch('/form-fields/reorder/{dragId}/{dropId}', 'FormFieldsController@reorder');

    /* Candidates */
    Route::get('/candidates', 'CandidatesController@list');
    //Route::get('/candidates/names', 'CandidatesController@names'); deprecated
    Route::get('/candidates/{candidate}', 'CandidatesController@get')->middleware(['can:view,candidate']);
    Route::put('/candidates/{candidate}', 'CandidatesController@update')->middleware(['can:update,candidate']);
    Route::delete('/candidates/{candidate}', 'CandidatesController@delete')->middleware(['can:delete,candidate']);
    Route::put('/candidates/hasbeenseen/{candidate}', 'CandidatesController@hasBeenSeen')->middleware(['can:update,candidate']);

    Route::post('/candidate-creations', 'CandidatesController@create')->middleware(['can:create,App\Models\Candidate']);


    /* Notes */
    Route::get('/notes', 'NotesController@get')->middleware(['can:list,App\Models\Note']);
    Route::post('/notes', 'NotesController@create')->middleware(['can:create,App\Models\Note']);

    /* Predefined messages */
    Route::get('/predefined_messages', 'MessageTemplatesController@list');
    Route::patch('/predefined_messages/{messageId}', 'MessageTemplatesController@update');
    Route::get('/predefined_messages/parsed/', 'MessageTemplatesController@getParsed');

    /* Sources */
    Route::get('/sources', 'SourcesController@list');
    Route::post('/sources', 'SourcesController@create');
    Route::delete('/sources/{sourceId}', 'SourcesController@delete');

    /* Remaining endpoints */
    Route::put('/change-stage-commands/{commandUUID}', 'CandidatesController@changeStage')->middleware(['can:changeStage,App\Models\Candidate']);
    Route::get('/messages', 'MessagesController@list')->middleware(['can:list,App\Models\Message']);
    Route::get('/stages', 'StagesController@list');
    Route::get('/activities', 'ActivitiesController@list')->middleware(['can:list,App\Models\Activity']);
});

Route::group([
    'prefix' => '/{tenant}',
    'middleware' => [\App\Http\Middleware\IdentifyTenant::class],
    'as' => 'tenant:',
], function () {
    Route::post('/apply', 'ApplyController@apply');
    Route::get('/apply-form/{sourceKey}', 'ApplyController@applyForm');
    Route::put('/invites/{token}', 'UsersController@finishInvitation');
});

Route::group([
    'prefix' => '/{tenant}',
    'middleware' => ['api.addAccessToken', 'tenant.identify', 'auth:api'],
    'as' => 'tenant:',
], function () {
    Route::get('/message_preview/{messageId}', 'MessagePreview@render')->name('message_preview.render');
    Route::get('/candidates/{candidateId}/cv', 'CandidatesController@cv')->name('candidates.cv');
});

Route::post('/password-token', 'PasswordsController@token');
Route::post('/password-reset', 'PasswordsController@reset');
