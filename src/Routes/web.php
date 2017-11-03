<?php

use Illuminate\Support\Facades\Config;
use Rakshitbharat\Licensee\Classes\LicenseeClass;

Route::group(['prefix' => Config('licensee.utility_prefix'), 'middleware' => Config('licensee.middleware'), 'as' => Config('licensee.utility_prefix') . '_', 'namespace' => 'Rakshitbharat\Licensee\Controllers'], function () {
    Route::any('list', function () {
        return View('licensee::index');
    })->name('list');
    Route::any('roleMaker', function (Illuminate\Http\Request $request) {
        if ($request->method() == 'GET') {
            return LicenseeClass::dataFromDB($request);
        }
        if ($request->method() == 'POST') {
            return LicenseeClass::dataToDB($request);
        }
    })->name('roleMaker');
});
