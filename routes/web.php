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

Route::get('/apply/{key}')->name('recruitment.apply');

Route::group([
    'middleware' => ['tenant.identify'],
], function () {
    //TODO: route nie zabezpieczony!
    Route::get('/message_preview/{messageId}', 'MessagePreview@render')->name('message_preview.render');
});
