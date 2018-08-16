<?php

// Route::get('/home', function () {
//     $users[] = Auth::user();
//     $users[] = Auth::guard()->user();
//     $users[] = Auth::guard('admin')->user();

//     //dd($users);

//     return view('admin.home');
// })->name('home');

Route::get('/home', 'DashboardController@Staff')->name('home');


Route::get('/staff/blocked','AdminStaffController@blockedstaff');
Route::post('/staff/{id}/unblock','AdminStaffController@unblockedstaff')->name('unblock_vendor');
Route::get('/staff/add', 'AdminStaffController@index');
Route::post('/staff/add', 'AdminStaffController@store');
Route::get('/staff/approve', 'AdminStaffController@showUnApprovedStaff');
Route::post('/staff/approve/{id}', 'AdminStaffController@approvestaff')->name('approve_staff');
Route::get('/staff', 'AdminStaffController@Staffindex');
Route::get('/staff/{id}','AdminStaffController@view')->name('view_staff');
Route::delete('/staff/{id}','AdminStaffController@deletestaff')->name('destory_staff');
Route::get('staff/{id}/edit', 'AdminStaffController@showEditstaff')->name('edit_staff');
Route::post('/staff/edit/{id}', 'AdminStaffController@showEditstaff');
Route::post('/staff/{id}/update', 'AdminStaffController@updatestaff')->name('update_staff');
Route::get('/staff/{id}/block','AdminStaffController@blockedstaff')->name('block_staff');

Route::get('/contacts/add', 'AdminStaffController@contact');
Route::post('/contacts/add', 'ContactController@import');


