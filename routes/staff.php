<?php

Route::get('/home', function () {
    return view('staff.home');
})->name('home');


Route::get('/customer/add', 'staff\CustomerController@index');
Route::post('/customer/add', 'staff\CustomerController@addCustomer')->name('add_customer');
Route::get('/customer', 'staff\CustomerController@viewCustomer');
Route::get('/customer/{id}/edit', 'staff\CustomerController@editCustomer')->name('edit_customer');
Route::post('/customer/{id}/update', 'staff\CustomerController@updateCustomer')->name('update_customer');

Route::get('/contacts/add', 'staff\TotalController@contactForm');
Route::post('/contacts/add', 'ContactController@import');


