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

Route::middleware('auth:api')->group(function () {
    Route::get('/recruitments', 'RecruitmentsController@list');
    Route::get('/recruitments/{recruitmentId}', 'RecruitmentsController@get');

    Route::get('/candidates', 'CandidatesController@list');
    Route::get('/candidates/{candidateId}', 'CandidatesController@get');
    Route::put('/candidates/{candidateId}', 'CandidatesController@update');
    Route::put('/candidates/{candidateId}/change-stage-commands/{commandUUID}', 'CandidatesController@changeStage');

    Route::get('/notes', 'NotesController@get');
    Route::post('/notes', 'NotesController@create');

    Route::get('/stages', 'StagesController@list');
});

Route::get('/candidates/{candidateId}/cv', 'CandidatesController@cv')->name('candidates.cv');
