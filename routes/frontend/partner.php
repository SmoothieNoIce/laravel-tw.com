<?php

use App\Http\Controllers\Frontend\PartnersController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.partner.'.
 */
Route::group([
    'prefix' => 'partner',
    'as' => 'partner.',
    'namespace' => 'Partner',
], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        Route::get('partners', [PartnersController::class, 'index']);
        Route::get('partner/{partner}', [PartnersController::class, 'show']);
    });
});
