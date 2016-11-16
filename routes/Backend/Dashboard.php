<?php

/**
 * All route names are prefixed with 'admin.'
 */
Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::get('settings', 'SettingsController@getSettings');
Route::post('settings', 'SettingsController@saveSettings');