<?php

use EscolaLms\Cmi5\Http\Controllers\Cmi5Controller;

Route::group(['prefix' => '/api/admin/cmi5', 'middleware' => ['auth:api']], function () {
    Route::post('/', [Cmi5Controller::class, 'upload']);
});
