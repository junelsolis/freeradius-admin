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

Route::get('/', 'LoginController@main');
Route::post('/', 'LoginController@login');
Route::get('/admin', 'AdminController@showDashboard');
Route::get('/admin/logout', 'AdminController@logout');

Route::get('/admin/add-user', 'AdminController@showUserAdd');
Route::post('/admin/add-user', 'AdminController@userAdd');
Route::get('/admin/list-users', 'AdminController@showUserList');
Route::get('/admin/delete-users', 'AdminController@showUserDelete');
Route::post('/admin/delete-users', 'AdminController@userDelete');
Route::get('/admin/show-admins', 'AdminController@showAdmins');
Route::post('/admin/add-admin', 'AdminController@adminAdd');
Route::post('/admin/modify-admin', 'AdminController@adminModify');
Route::get('/admin/delete-admin', 'AdminController@adminDelete');

Route::get('/admin/groups', 'AdminController@showGroups');
