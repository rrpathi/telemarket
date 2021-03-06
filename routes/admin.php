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

Route::get('/customer/add','CustomerController@index');
Route::post('/customer/add','CustomerController@store');
Route::get('/customer','CustomerController@view');
Route::get('customer/edit/{id}', 'CustomerController@editCustomer')->name('edit_customer');
Route::post('customer/{id}/update', 'CustomerController@updateCustomer')->name('update_customer');
Route::delete('/customer/{id}','CustomerController@deleteCustomer')->name('destory_customer');

Route::get('/export','ExportController@index');
Route::post('/export','ExportController@export')->name('export-data');

Route::get('/vendorcode/add', 'VendorCodeController@index');
Route::post('/vendorcode/add', 'VendorCodeController@store');
Route::get('/vendorcode','VendorCodeController@view');
Route::get('vendorcode/edit/{id}', 'VendorCodeController@editVendor')->name('edit_vendor');
Route::post('vendorcode/{id}/update', 'VendorCodeController@update_vendor')->name('update_vendor');
Route::delete('/vendorcode/{id}','VendorCodeController@deleteCustomer')->name('destory_vendor');

Route::get('/export/{id}/edit','ExportController@editExport');

Route::delete('/exportDelete/{id}','ExportController@deleteExport')->name('destory_export');
Route::post('/exportUpdate/{id}/update','ExportController@updateExport')->name('update_export');

// export admin approval
Route::get('/exportApproval','ExportController@ExportApproval');
Route::get('/getExportApprovalStatus','ExportController@getExportApprovalStatus');
Route::post('/update_approval_status','ExportController@updateApprovalStatus')->name('update_approval_status');

// Block List
Route::get('/BlockList/Add','blockListControllers@addBlockListForm');
Route::post('/BlockList/Add','blockListControllers@addBlockList');
Route::get('/BlockList','blockListControllers@viewBlockList');
Route::get('BlockList/edit/{id}', 'blockListControllers@editBlockList')->name('edit_blockList');
Route::post('BlockList/{id}/update', 'blockListControllers@updateBlockList')->name('update_block_list');
Route::delete('/BlockList/{id}','blockListControllers@deleteBlockList')->name('destory_BlockList');



// EXPORT EXCEL DATA ADMIN
Route::get('exportExcelList', 'ExportController@ViewExportLIst');
Route::get('exportExcel/{id}/download', 'ExportController@DownloadExcelData')->name('DownloadExcel');

