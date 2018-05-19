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

Route::get('/', 'AdminController@main');
Route::post('/', 'AdminController@login');
Route::get('/admin', 'AdminController@showDashboard');

Route::post('/admin/add-user', 'AdminController@userAdd');
