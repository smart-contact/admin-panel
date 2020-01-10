<?php

Route::group(['namespace' => 'SmartContact\AdminPanel\Controllers', 'prefix' => "adminpanelpage", 'as' => "adminpanelpage."], function () {
    Route::get('/', 'AdminPanelPageController@index')->name('index');
    Route::get("{adminpanelpage}/edit/", "AdminPanelPageController@edit")->name('edit');
    Route::get("new", "AdminPanelPageController@create")->name('create');
    Route::get("{id}/restore", "AdminPanelPageController@restore")->name('restore');
    Route::get("trash", "AdminPanelPageController@trash")->name('trash');
    Route::get("{adminpanelpage}", "AdminPanelPageController@show")->name('show');
    Route::post("/", "AdminPanelPageController@store")->name('store');
    Route::patch("{adminpanelpage}", "AdminPanelPageController@update")->name('update');
    Route::delete("{adminpanelpage}/delete", "AdminPanelPageController@delete")->name('delete');
    Route::delete("{id}/force-destroy", "AdminPanelPageController@destroy")->name('destroy');
});

Route::group(['namespace' => 'SmartContact\AdminPanel\Controllers', 'prefix' => 'dashboard'], function() {
    Route::get('/{slug}', 'AdminPanelPageController@to');
});
