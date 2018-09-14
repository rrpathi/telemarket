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


// Route::get('/export','ExportController@index');
Route::get('/export','staff\ExportController@index');
Route::post('/export','staff\ExportController@export')->name('export-data');

// vendor
Route::get('/vendorcode/add', 'staff\vendorController@index');
Route::post('/vendorcode/add', 'staff\vendorController@store');
Route::get('/vendorcode','staff\vendorController@view');
Route::get('vendorcode/edit/{id}', 'staff\vendorController@editVendor')->name('edit_vendor');
Route::post('vendorcode/{id}/update', 'staff\vendorController@update_vendor')->name('update_vendor');



// export edit
Route::get('/export/{id}/edit','staff\ExportController@editExport');
Route::post('/export/{id}/edit','staff\ExportController@updateExport')->name('update_export_data');



// ajax edit and delete data
Route::get('/customer_export_count','staff\ExportController@customerExportCount');
Route::delete('/destory_export/{id}/delete','staff\ExportController@deleteExport')->name('destory_export');


Route::get('/export-data','staff\ExportController@dataExport');
Route::get('/customer_export_status','staff\ExportController@exportStatus');
Route::post('/export-data','staff\ExportController@exportDataExcel')->name('export-data-staff');








