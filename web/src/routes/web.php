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



Route::get('/admin/users', 'AdminController@showUsers');
Route::get('/admin/users/add-user', 'AdminController@showUserAdd');
Route::post('/admin/users/add-user', 'AdminController@userAdd');
Route::get('/admin/users/modify-user', 'AdminController@showUserModify');
Route::post('/admin/users/modify-user/change-password', 'AdminController@userChangePassword');
Route::post('/admin/users/modify-user/change-logins', 'AdminController@userChangeLogins');
Route::post('/admin/users/modify-user/change-group', 'AdminController@userChangeGroup');
Route::post('/admin/users/modify-user/change-name', 'AdminController@userChangeName');
Route::get('/admin/users/delete-user', 'AdminController@userDelete');


Route::get('/admin/show-admins', 'AdminController@showAdmins');
Route::post('/admin/add-admin', 'AdminController@adminAdd');
Route::post('/admin/modify-admin', 'AdminController@adminModify');
Route::get('/admin/delete-admin', 'AdminController@adminDelete');

Route::get('/admin/groups', 'AdminController@showGroups');
Route::post('/admin/add-group', 'AdminController@groupAdd');
Route::get('/admin/delete-group', 'AdminController@groupDelete');
