<?php

Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
    /**
     * Search Specific Functionality
     */
    Route::get('/', 'SearchController@index')->name('index');
});