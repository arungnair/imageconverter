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

Route::get('/foo', function()
{
    $exitCode = Artisan::call('command:name', ['--option' => 'foo']);

});

Route::get('/', 'ImageConversionController@index');
Route::post('/upload', 'ImageConversionController@resizeImage');
