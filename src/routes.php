<?php

use EscolaLms\Cmi5\Http\Controllers\Cmi5Controller;

Route::group(['prefix' => '/api/admin/cmi5', 'middleware' => ['auth:api']], function () {
    Route::get('/', [Cmi5Controller::class, 'list']);
    Route::post('/', [Cmi5Controller::class, 'upload']);
});
