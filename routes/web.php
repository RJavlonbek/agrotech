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

Auth::routes();
// password
Route::post('/password/forgot','PasswordResetController@forgotpassword');
Route::get('passwords/reset/{token}/{email}','PasswordResetController@geturl');
Route::post('/passwordchange', 'PasswordResetController@passwordnew');
//Dashboard

Route::get('/', ['middleware'=>'auth','uses'=>'HomeController@dashboard']);

Route::get('/import-excel','Customercontroller@import_excel_form');
Route::post('/import-excel','Customercontroller@import_excel_form');


Route::auth();

//profile

Route::get('setting/profile','Profilecontroller@index');	
Route::post('/setting/profile/update/{id}','Profilecontroller@update');	

Route::get('/instruction','Customercontroller@instruction');
Route::get('/full-report','VehicleReportController@generate_full_report');
Route::get('/sign', 'Customercontroller@sign');


// Customer 
Route::group(['prefix'=>'customer','middleware'=>'auth'],function(){


	Route::get('/add',['as'=>'customer/add','uses'=>'Customercontroller@customeradd']);
	Route::post('/store',['as'=>'customer/store','uses'=>'Customercontroller@storecustomer']);
	Route::get('/list',['as'=>'customer/list','uses'=>'Customercontroller@index']);
	Route::get('/list/{id}',['as'=>'customer/list/{id}','uses'=>'Customercontroller@customershow']);
	Route::get('/list/delete/{id}',['as'=>'customer/list/delete/{id}','uses'=>'Customercontroller@destroy']);
	Route::get('/list/edit/{id}',['as'=>'customer/list/edit/{id}','uses'=>'Customercontroller@customeredit']);
	Route::post('/list/edit/update/{id}',['as'=>'customer/list/edit/update/{id}','uses'=>'Customercontroller@customerupdate']);
	Route::get('/free-open',['as'=>'customer/free-open','uses'=>'Customercontroller@free_open_model']);
	Route::get('/paid-open',['as'=>'/customer/paid-open','uses'=>'Customercontroller@paid_open_model']);
	Route::get('/Repeatjob-modal',['as'=>'/customer/Repeatjob-modal','uses'=>'Customercontroller@repeat_job_model']);
	Route::get('/customer_category_add',['as'=>'/customer/customer_category_add','uses'=>'Customercontroller@categoryadd']);
	Route::get('/customer_category_delete',['as'=>'/customer/customer_category_delete','uses'=>'Customercontroller@categorydelete']);
	Route::get('/ownershipform_add',['as'=>'/customer/ownershipform_add','uses'=>'Customercontroller@ownershipformadd']);
	Route::get('/ownershipform_delete',['as'=>'/customer/ownershipform_delete','uses'=>'Customercontroller@ownershipformdelete']);
	Route::get('/search','Customercontroller@searchCustomer');
	Route::get('/category/list','Customercontroller@categories');
	Route::get('/category/add','Customercontroller@category_add');
	Route::post('/category/store','Customercontroller@category_store');
	Route::get('/category/edit/{id}','Customercontroller@category_edit');
	Route::post('/category/update','Customercontroller@category_update');
	Route::get('/check-inn','Customercontroller@checkInn');


// Route::get('/view/modal',['as'=>'/customer/view/modal','uses'=>'Customercontroller@view']);
// Route::get('/view/salesmodal',['as'=>'/customer/view/salesmodal','uses'=>'Customercontroller@salesview']);
// Route::get('/view/com-modal',['as'=>'/customer/view/com-modal','uses'=>'Customercontroller@commodal']);
// Route::get('/view/completedservice',['as'=>'/customer/view/completedservice','uses'=>'Customercontroller@servicecompleted']);
// Route::get('/view/upservice',['as'=>'/customer/view/upservice','uses'=>'Customercontroller@upservice']);
// Route::get('/view/upcomingservice',['as'=>'/customer/view/upcomingservice','uses'=>'Customercontroller@upcomingservice']);

});

Route::group(['prefix'=>'driver-licence','middleware'=>'auth'],function(){
	Route::get('/give','Customercontroller@driver_licence_form');
	Route::get('/list','Customercontroller@driver_licences');
	Route::get('/cancel/{id}','Customercontroller@driver_licence_cancel');
	Route::post('/store','Customercontroller@driver_licence_store');
	Route::get('/preview','Customercontroller@driver_licence_preview');
	Route::post('/save-image','Customercontroller@driver_licence_image');
	Route::post('/save-signature', 'Customercontroller@driver_signature');
});
Route::group(['prefix'=>'notification','middleware'=>'auth'],function(){
	Route::get('/medlist','HomeController@medlist');
	Route::get('/reglist','HomeController@reglist');
});

Route::group(['prefix'=>'driver-exam','middleware'=>'auth'],function(){
	Route::get('/','Customercontroller@driver_exam_form');
	Route::post('/store','Customercontroller@driver_exam_store');
	Route::get('/list','Customercontroller@driver_exams');
	Route::get('/cancel/{id}','Customercontroller@driver_exam_cancel');
	Route::post('/add-exam-type','Customercontroller@add_exam_type');
	Route::post('/edit-exam-type','Customercontroller@edit_exam_type');
	Route::get('/list/preview', 'Customercontroller@driver_exam_preview');
});

Route::group(['prefix'=>'user','middleware'=>'auth'],function(){
	Route::get('/list/{id}','Usercontroller@usershow');
	Route::get('/get','Usercontroller@get_users');
});
//Vehical

Route::group(['prefix'=>'vehicle','middleware'=>'auth'],function(){

	Route::get('/ajaxlist', 'VehicalControler@ajax_list');
	Route::get('/tm-list', 'VehicalControler@tm_list');

	Route::get('/add',['as'=>'vehicle/add','uses'=>'VehicalControler@index']);
	Route::post('/store',['as'=>'vehicle/store','uses'=>'VehicalControler@vehicalstore']);
	Route::get('/list',['as'=>'vehicle/list','uses'=>'VehicalControler@vehicallist']);
	Route::get('/list/delete/{id}/{city_id}',['as'=>'vehical/list/delete/{id}','uses'=>'VehicalControler@destory']);
	Route::get('list/edit/{id}/{city_id}',['as'=>'vehical/list/edit/{id}','uses'=>'VehicalControler@editvehical']);
	Route::post('list/edit/update/{id}/{city_id}',['as'=>'/vehical/list/edit/update/{id}','uses'=>'VehicalControler@updatevehical']);
	Route::get('/list/view/{id}/{city_id}',['as'=>'vehical/list/view/{id}','uses'=>'VehicalControler@vehicalshow']);
    Route::get('/vehicaltypefrombrand','VehicalControler@vehicaltype');
    Route::get('/owner_search_name','VehicalControler@owner_search_name');
    Route::get('/factory_search_name','VehicalControler@factory_search_name');
    Route::get('/brand_search_name','VehicalControler@brand_search_name');
    Route::get('/checktype', 'VehicalControler@checktype');
    
    
   //vihical type,brand,fuel,model
	
	Route::get('/vehicle_type_add',['as'=>'vehical/vehicle_type_add','uses'=>'VehicalControler@vehicaltypeadd']);
	Route::get('/vehicaltypedelete',['as'=>'vehical/vehicaltypedelete','uses'=>'VehicalControler@deletevehicaltype']);
	
	
	Route::get('vehicle_brand_add',['as'=>'vehical/vehicle_brand_add','uses'=>'VehicalControler@vehicalbrandadd']);
	Route::get('/vehicalbranddelete',['as'=>'/vehical/vehicalbranddelete','uses'=>'VehicalControler@deletevehicalbrand']);
	
	
	Route::get('vehicle_fuel_add',['as'=>'vehical/vehicle_fuel_add','uses'=>'VehicalControler@fueladd']);
	Route::get('fueltypedelete',['as'=>'vehical/fueltypedelete','uses'=>'VehicalControler@fueltypedelete']);
 
   
	Route::get('add/getDescription','VehicalControler@getDescription');
	Route::get('delete/getDescription','VehicalControler@deleteDescription');
	Route::get('add/getImages','VehicalControler@getImages');
	Route::get('delete/getImages','VehicalControler@deleteImages');
	Route::get('add/getcolor','VehicalControler@getcolor');
	Route::get('delete/getcolor','VehicalControler@deletecolor');
	
	Route::get('vehicle_model_add','VehicalControler@add_vehicle_model');
	Route::get('vehicle_model_delete','VehicalControler@delete_vehi_model');
	Route::get('/factory_add', 'VehicalControler@factoryadd');
	Route::get('/factorydelete', 'VehicalControler@factorydelete');
	Route::get('/vehicle_lock', 'VehicalControler@vehiclelock');
	Route::get('/lock', 'VehicalControler@addlock');
	Route::get('/lock/{id}', 'VehicalControler@unlock');
	Route::post('/lockstore', 'VehicalControler@lock_store');
	Route::get('/owner_search_lock', 'VehicalControler@ownerlock');
	Route::get('/vehicle_search_lock', 'VehicalControler@searchvehiclelock');
	Route::get('/vehicalworkdelete', 'VehicalControler@work_for_delete');
	Route::get('/vehicle_working_add', 'VehicalControler@working_add');
	Route::get('/locker_add', 'VehicalControler@locker_add');
	Route::get('/lockerdelete', 'VehicalControler@locker_delete');

	Route::get('/technical-passport','Customercontroller@technical_passport_form');
	Route::post('/technical-passport','Customercontroller@technical_passport_store');
	Route::get('/technical-passport/list','Customercontroller@technical_passports');
	Route::get('/technical-passport/cancel/{id}','Customercontroller@technical_passport_cancel');
	Route::get('/technical-passport/preview','Customercontroller@technical_passport_preview');
	Route::get('/transport-number','Customercontroller@transport_number_form');
	Route::post('/transport-number','Customercontroller@transport_number_store');
	Route::get('/transport-number/list','Customercontroller@transport_numbers');
	Route::get('/transport-number/cancel/{id}','Customercontroller@transport_number_cancel');
	Route::get('/transport-number/preview','Customercontroller@transport_number_preview');
	Route::get('/check-for-transport-number','Customercontroller@check_transport_number');
	Route::get('/find-by-owner','Customercontroller@getTransports');
	Route::get('/vehicle_lock/edit/{id}', 'VehicleCertificatesController@lockedit');
	Route::get('/vehicle_lock/delete/{id}', 'VehicleCertificatesController@lockdelete');
	Route::post('/vehicle_lock/edit/update/{id}', 'VehicleCertificatesController@lockupdate');
	Route::get('/vehiclebrandselect', 'VehicalbransControler@typeworksearch');
	Route::get('/tm-1','Customercontroller@tm_1_form');
	Route::get('/get-last-active-transport-number','Customercontroller@get_last_tr_number');
	Route::get('/tm-formsubmit', 'VehicalControler@tm_formsubmit');
	Route::get('checkfactory', 'VehicalControler@checkfactory');
	
});

Route::get('/technical-inspection/preview','VehicleCertificatesController@technical_inspection_preview');

Route::get('/type_search_name','VehicalControler@type_search_name');
Route::get('/work_search_name','VehicalControler@working_search_name');


Route::group(['prefix'=>'certificate','middleware'=>'auth'],function(){
	Route::get('/cancel/{id}', 'Customercontroller@certificate_cancel');
	Route::get('/list', 'Customercontroller@vehicle_certificates');
	Route::get('/list/edit/{id}', 'VehicleCertificatesController@edit');
	Route::get('/list/view/{id}', 'VehicleCertificatesController@view');
	Route::get('/list/delete/{id}', 'VehicleCertificatesController@delete');
	Route::get('/add', 'VehicleCertificatesController@index');
	Route::post('/store', 'Customercontroller@technical_passport_store');
	Route::get('/preview','Customercontroller@certificate_preview');
	Route::post('/update/{id}', 'VehicleCertificatesController@update');
	Route::get('/medlist', 'VehicleCertificatesController@medlist');
	Route::get('/medadd', 'VehicleCertificatesController@medadd');
	Route::post('/medstore', 'VehicleCertificatesController@medstore');
	Route::get('/medlist/edit/{id}', 'VehicleCertificatesController@mededit');
	Route::post('/medupdate/{id}', 'VehicleCertificatesController@medupdate');
	Route::get('/medlist/delete/{id}', 'VehicleCertificatesController@meddelete');
	Route::get('/reglist', 'VehicleCertificatesController@reglist');
	Route::get('/reglistoutof', 'VehicleCertificatesController@reglistoutof');
	Route::get('/regadd', 'VehicleCertificatesController@regadd');
	Route::get('/regsub', 'VehicleCertificatesController@regsub');
	Route::post('/regstore', 'VehicleCertificatesController@regstore');
	Route::get('/reglist/regback/{id}', 'VehicleCertificatesController@regback');
	Route::get('/searchvehiclereg', 'VehicleCertificatesController@searchvehiclereg');
	Route::get('/reglist/delete/{id}', 'VehicleCertificatesController@regdelete');
	Route::get('/check-engineno', 'VehicleCertificatesController@checkengineno');
	Route::get('/checklising', 'VehicleCertificatesController@checklising');
});

	// vehical type

Route::group(['prefix'=>'vehicletype','middleware'=>'auth'],function(){
    Route::get('/vehicletypeadd',['as'=>'/vehicletype/add' ,'uses'=>'VehicaltypesControler@index']);
    Route::post('/vehicaltystore',['as'=>'/vehicletype/vehicletystore' ,'uses'=>'VehicaltypesControler@storevehicaltypes']);
    Route::get('/list',['as'=>'/vehical/list' ,'uses'=>'VehicaltypesControler@vehicaltypelist']);
    Route::get('/list/delete/{id}',['as'=>'/vehical/list/delete/{id}' ,'uses'=>'VehicaltypesControler@destory']);
    Route::get('/list/edit/{id}',['as'=>'/vehical/list/edit/{id}' ,'uses'=>'VehicaltypesControler@editvehicaltype']);
    Route::post('/list/edit/update/{id}',['as'=>'/vehical/list/edit/update/{id}' ,'uses'=>'VehicaltypesControler@updatevehicaltype']);
});
Route::group(['prefix'=>'active','middleware'=>'auth'],function(){
    Route::get('/list',['as'=>'/active/list' ,'uses'=>'ActivitiesController@index']);
});
Route::group(['prefix'=>'locker','middleware'=>'auth'],function(){
    Route::get('/add', 'VehicleLockerController@index');
    Route::post('/lockerstore','VehicleLockerController@store');
    Route::get('/list','VehicleLockerController@list');
    Route::get('/list/delete/{id}','VehicleLockerController@destory');
    Route::get('/list/edit/{id}','VehicleLockerController@edit');
    Route::post('/list/edit/update/{id}','VehicleLockerController@update');
});
Route::group(['prefix'=>'payment','middleware'=>'auth'],function(){

    Route::get('/add', 'PaymentController@index');
    Route::post('/store','PaymentController@store');
    Route::get('/list','PaymentController@list');
    Route::get('/list/delete/{id}','PaymentController@destory');
    Route::get('/list/edit/{id}','PaymentController@edit');
    Route::post('/list/edit/update/{id}','PaymentController@update');
    Route::get('/technical-pass', 'PaymentController@technical_pass');
    Route::get('/medtype', 'PaymentController@vehicle_med');
    Route::get('/vehicle_reg', 'PaymentController@vehicle_reg');
    Route::get('/driver_licence', 'PaymentController@driver_licence');
    Route::get('/reg-out', 'PaymentController@reg_out');
});
Route::group(['prefix'=>'fuel','middleware'=>'auth'],function(){

    Route::get('/add', 'FuelTypeController@index');
    Route::post('/store','FuelTypeController@store');
    Route::get('/list','FuelTypeController@list');
    Route::get('/list/delete/{id}','FuelTypeController@destory');
    Route::get('/list/edit/{id}','FuelTypeController@edit');
    Route::post('/list/edit/update/{id}','FuelTypeController@update');
    

});

Route::group(['prefix'=>'inspection','middleware'=>'auth'],function(){

    Route::get('/add', 'InspectionController@index');
    Route::post('/store','InspectionController@store');
    Route::get('/list','InspectionController@list');
    Route::get('/list/delete/{id}','InspectionController@destory');
    Route::get('/list/edit/{id}','InspectionController@edit');
    Route::post('/list/edit/update/{id}','InspectionController@update');
    

});

 //vehical brand

Route::group(['prefix'=>'vehiclebrand','middleware'=>'auth'],function(){

       Route::get('/add',['as'=>'/vehicalbrand/list','uses'=>'VehicalbransControler@index']);
       Route::get('/list',['as'=>'/vehicalbrand/list','uses'=>'VehicalbransControler@listvehicalbrand']);
       Route::post('/store',['as'=>'/vehicalbrand/store','uses'=>'VehicalbransControler@store']);
       Route::get('/list/delete/{id}',['as'=>'/vehicalbrand/list/delete','uses'=>'VehicalbransControler@destory']);
       Route::get('/list/edit/{id}',['as'=>'/vehicalbrand/list/edit/{id}','uses'=>'VehicalbransControler@editbrand']);
       Route::post('/list/edit/update/{id}',['as'=>'/vehicalbrand/list/edit/update{id}','uses'=>'VehicalbransControler@brandupdate']);
       

});
Route::group(['prefix'=>'workingtype','middleware'=>'auth'],function(){

   Route::get('/add','VehicleWorkingController@index');
   Route::get('/list','VehicleWorkingController@list');
   Route::post('/store', 'VehicleWorkingController@store');
   Route::get('/list/delete/{id}','VehicleWorkingController@destory');
   Route::get('/list/edit/{id}','VehicleWorkingController@edit');
   Route::post('/list/edit/update/{id}','VehicleWorkingController@update');
       

});
Route::group(['prefix'=>'factory','middleware'=>'auth'],function(){

   Route::get('/add','VehicleFactoryController@index');
   Route::get('/list','VehicleFactoryController@list');
   Route::post('/store', 'VehicleFactoryController@store');
   Route::get('/list/delete/{id}','VehicleFactoryController@destory');
   Route::get('/list/edit/{id}','VehicleFactoryController@edit');
   Route::post('/list/edit/update/{id}','VehicleFactoryController@update');
       

});
Route::group(['prefix'=>'cities','middleware'=>'auth'],function(){

   Route::get('/add','CitiesController@index');
   Route::get('/list','CitiesController@list');
   Route::post('/store', 'CitiesController@store');
   Route::get('/list/delete/{id}','CitiesController@destory');
   Route::get('/list/edit/{id}','CitiesController@edit');
   Route::post('/list/edit/update/{id}','CitiesController@update');
       

});

Route::group(['prefix'=>'states','middleware'=>'auth'],function(){

   Route::get('/add','StatesController@index');
   Route::get('/list','StatesController@list');
   Route::post('/store', 'StatesController@store');
   Route::get('/list/delete/{id}','StatesController@destory');
   Route::get('/list/edit/{id}','StatesController@edit');
   Route::post('/list/edit/update/{id}','StatesController@update');
       

});
Route::get('/selecttype', 'VehicaltypesControler@selecttype');



// Payment type


Route::group(['prefix'=>'report','middleware'=>'auth'], function(){
	Route::get('/exist', 'VehicleReportController@exist');
	Route::get('/ownership','VehicleReportController@ownership');
	Route::get('/vehicle-age','VehicleReportController@vehicle_age');
	Route::get('/vehicle-registration','VehicleReportController@vehicle_registration');
	Route::get('/new-vehicle','VehicleReportController@new_vehicle');
	Route::get('/exist-by-category','VehicleReportController@exist_by_category');
	Route::get('/income/technical-inspections','VehicleReportController@income_technical_inspections');
	Route::get('/income/technical-passports','VehicleReportController@income_technical_passports');
	Route::get('/income/transport-numbers','VehicleReportController@income_transport_numbers');
	Route::get('/income/driver-exams','VehicleReportController@income_driver_exams');
	Route::get('/income/driver-licenses','VehicleReportController@income_driver_licenses');
	Route::get('/income/certificates','VehicleReportController@income_certificates');
	Route::get('/income/tm-1','VehicleReportController@income_tm1_certificates');
	Route::get('/income/registrations','VehicleReportController@income_registrations');
	Route::get('/income/latest','VehicleReportController@income_latest');
	Route::post('view', 'VehicleReportController@view');
});


//Supllier

Route::group(['prefix'=>'supplier','middleware'=>'auth'],function(){
	
Route::get('/list','Suppliercontroller@supplierlist');
Route::get('/add','Suppliercontroller@supplieradd');
Route::post('/store','Suppliercontroller@storesupplier');
Route::get('/list/{id}','Suppliercontroller@showsupplier');
Route::get('/list/delete/{id}','Suppliercontroller@destroy');
Route::get('/list/edit/{id}','Suppliercontroller@edit');
Route::post('/list/edit/update/{id}','Suppliercontroller@update');
Route::get('/add_data','Suppliercontroller@adddata');

});

//Change language and timezone and language direction

Route::group(['prefix'=>'setting','middleware'=>'auth'],function(){

	Route::get('/list',['as'=>'listlanguage','uses'=>'Languagecontroller@index']);
	Route::post('/language/store',['as'=>'storelanguage','uses'=>'Languagecontroller@store']);
	Route::get('/timezone/list',['as'=>'timezonelist','uses'=>'Timezonecontroller@index']);
	Route::post('/timezone/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@store']);
	Route::post('/date/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@datestore']);
	//language
	Route::get('language/direction/list',['as'=>'listlanguagedirection','uses'=>'Languagecontroller@index1']);
	Route::post('language/direction/store',['as'=>'storelanguagedirection','uses'=>'Languagecontroller@store1']);
	//accessrights
	Route::get('accessrights/add',['as'=>'accessrights/add','uses'=>'Accessrightscontroller@addposition']);
	Route::post('accessrights/addstore',['as'=>'accessrights/add','uses'=>'Accessrightscontroller@storeposition']);
	Route::get('accessrights/list',['as'=>'accessrights/list','uses'=>'Accessrightscontroller@index']);
	Route::get('accessrights/list/edit/{id}',['as'=>'accessrights/list','uses'=>'Accessrightscontroller@edit']);
	Route::get('accessrights/list/delete/{id}',['as'=>'accessrights/list','uses'=>'Accessrightscontroller@delete']);
	Route::GET('/accessrights/change_role',['as'=>'/accessrights/change_role','uses'=>'Accessrightscontroller@change_role']);

	//general_setting
	Route::get('general_setting/list','GeneralController@index');
	Route::post('general_setting/store','GeneralController@store');
	//hours
	Route::get('hours/list','HoursController@index');
	Route::post('hours/store','HoursController@hours');
	Route::post('holiday/store','HoursController@holiday');
	Route::get('deleteholiday/{id}','HoursController@deleteholiday');
	Route::get('/deletehours/{id}','HoursController@deletehours');
	//currancy
	Route::post('currancy/store','Timezonecontroller@currancy');
	//custom field
	Route::get('/custom/list','Customcontroller@index');
	Route::get('custom/add','Customcontroller@add');
	Route::post('custom/store','Customcontroller@store');
	Route::get('custom/list/edit/{id}','Customcontroller@edit');
	Route::post('custom/list/edit/update/{id}','Customcontroller@update');
	Route::get('custom/list/delete/{id}','Customcontroller@delete');
	Route::get('/getrole', 'employeecontroller@getrole');


});

// DXA requests
Route::group(['prefix'=>'task','middleware'=>'auth'],function(){
	Route::get('/list', 'TaskController@list');
	Route::get('/list/{id}', 'TaskController@viewTask');
	Route::post('/save', 'TaskController@saveTask');
	Route::get('/{id}/response-sent', 'TaskController@responseSent');
});

// MIB requests
Route::group(['prefix' => 'mib-requests', 'middleware' => 'auth'], function(){
	Route::get('/list', 'TaskController@mibRequests');
	Route::get('/list/{id}', 'TaskController@viewMibRequest');
});


//Country City State ajax
Route::get('/getstatefromcountry','CountryAjaxcontroller@getstate');
Route::get('/getcityfromstate','CountryAjaxcontroller@getcity');
Route::get('/getcities','CountryAjaxcontroller@getcitiesjson');
Route::post('/edit-city','CountryAjaxcontroller@edit_city');
Route::post('/add-city','CountryAjaxcontroller@add_city');
Route::get('/getcityfromsearch','CountryAjaxcontroller@getcityfromsearch');
Route::post('/update-state','CountryAjaxcontroller@update_state');


//employee module

Route::group(['prefix'=>'employee'],function(){
	Route::get('/list',['as'=>'listemployeee','uses'=>'employeecontroller@employeelist']);
	Route::get('/add',['as'=>'addemployeee','uses'=>'employeecontroller@addemployee']);
	Route::post('/store',['as'=>'storeemployeee','uses'=>'employeecontroller@store']);
	Route::get('/edit/{id}',['as'=>'editemployeee','uses'=>'employeecontroller@edit']);
	Route::patch('/edit/update/{id}','employeecontroller@update');
	Route::get('/view/{id}','employeecontroller@showemployer');
	Route::get('/list/delete/{id}',['as'=>'/employee/list/delete/{id}','uses'=>'employeecontroller@destory']);
	Route::get('/free_service',['as'=>'/employee/free_service','uses'=>'employeecontroller@free_service']);
	Route::get('/paid_service',['as'=>'/employee/paid_service','uses'=>'employeecontroller@paid_service']);
	Route::get('/repeat_service',['as'=>'/employee/repeat_service','uses'=>'employeecontroller@repeat_service']);
});


//Color List Module

Route::group(['prefix'=>'color'],function(){
Route::get('/list',['as'=>'listcolor','uses'=>'Colorcontroller@index']);
Route::get('/add',['as'=>'addcolor','uses'=>'Colorcontroller@addcolor']);
Route::post('/store',['as'=>'storecolor','uses'=>'Colorcontroller@store']);
Route::get('/list/delete/{id}','Colorcontroller@destroy');
Route::get('/list/edit/{id}','Colorcontroller@edit');
Route::post('/list/edit/update/{id}','Colorcontroller@update');
});


//DocumentList Module
Route::group(['prefix'=>'docs'],function(){
Route::get('/list','DocsController@index');
Route::get('/add',['as'=>'addcolor','uses'=>'DocsController@add_doc']);
Route::post('/store',['as'=>'storecolor','uses'=>'DocsController@store']);
Route::get('/list/delete/{id}','DocsController@destroy');
Route::get('/list/edit/{id}','DocsController@edit');
Route::post('/list/edit/update/{id}','DocsController@update');
});

//Exam types

Route::group(['prefix'=>'exam-type'],function(){
	Route::get('/list','Customercontroller@exam_types');
	Route::get('/add','Customercontroller@exam_type_form');
	Route::post('/store','Customercontroller@add_exam_type');
	Route::get('/list/delete/{id}','Customercontroller@exam_type_delete');
	Route::get('/list/edit/{id}','Customercontroller@exam_type_form');
	Route::post('/list/edit/update/{id}','Customercontroller@edit_exam_type');
});

Route::group(['prefix'=>'export','middleware'=>'auth'],function(){
	Route::get('/vehicle-list','ExcelExportController@vehicle_list');
	Route::get('/driver-licence','ExcelExportController@driver_licence');
	Route::get('/transport-number','ExcelExportController@transport_numbers');
	Route::get('/technical-passport','ExcelExportController@technical_passports');
	Route::get('/certificate','ExcelExportController@certificate');
	Route::get('/med','ExcelExportController@med');
	Route::get('/driver-exam','ExcelExportController@exam');
	Route::get('/tm','ExcelExportController@tm');
	Route::get('/customer','ExcelExportController@customer');
	Route::get('/medout','ExcelExportController@medout');
	Route::get('/regout','ExcelExportController@regout');
});


//Mail Formate Module

Route::group(['prefix'=>'mail'],function(){
Route::get('/mail',['as'=>'usermail','uses'=>'Mailcontroller@index']);
Route::post('/mail/emailformat/{id}',['as'=>'/emailformat/{id}','uses'=>'Mailcontroller@emailupadte']);

Route::get('/user',['as'=>'usermail','uses'=>'Mailcontroller@user']);
Route::get('/sales',['as'=>'salesmail','uses'=>'Mailcontroller@sales']);
Route::get('/services',['as'=>'servicessmail','uses'=>'Mailcontroller@services']);
});

// Backup database
Route::get('/backup-list', 'BackupController@list');
Route::get('/backup','BackupController@index');
Route::get('/get-backup-file','BackupController@get_file');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
//Clear Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
