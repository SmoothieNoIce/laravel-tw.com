<?php

use App\Http\Controllers\Frontend\DocsController;

if (! defined('DEFAULT_VERSION')) {
    define('DEFAULT_VERSION', '7.x');
}

if (! defined('SHOW_VAPOR')) {
    define('SHOW_VAPOR', random_int(1, 2) === 1);
}

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.docs.'.
 */
Route::group([
    'prefix' => 'docs',
    'as' => 'docs.',
    'namespace' => 'Docs',
], function () {
    Route::get('/', [DocsController::class, 'showRootPage']);

    Route::get('/6.0/{page?}', function ($page = null) {
        $page = $page ?: 'installation';
        $page = $page == '7.x' ? 'installation' : $page;

        return redirect(trim('/7.x/'.$page, '/'), 301);
    });

    Route::get('/{version}/{page?}', [DocsController::class, 'show'])->name('docs.version');
});
