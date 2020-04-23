<?php

Auth::routes();


// webpage setting route

Route::post("/app-boost","AdminSettings\AppOptimizer@appBooter");
Route::get("/boost-app","AdminSettings\AppOptimizer@booterapp");


// user registration panel route

Route::group(["namespace"=>"User"],function(){

//permission
	Route::get("/permissions","PermissionController@index");
	Route::post("/permissions-get","PermissionController@show");
	Route::post("/permissions-add","PermissionController@store");
	Route::post("/permissions-edit","PermissionController@edit");
	Route::post("/permissions-update","PermissionController@update");
	Route::post("/permissions-delete","PermissionController@destroy");

//Role
  Route::get("/roles","RoleController@index");
	Route::post("/roles-get","RoleController@show");
	Route::post("/roles-add","RoleController@store");
	Route::post("/roles-edit","RoleController@edit");
	Route::post("/roles-update","RoleController@update");
  Route::post("/roles-delete","RoleController@destroy");

//User
	Route::get("/users","UserController@index");
	Route::post("/users-get","UserController@show");
	Route::post("/users-add","UserController@store");
	Route::post("/users-edit","UserController@edit");
	Route::post("/users-update","UserController@update");
  Route::post("/users-delete","UserController@destroy");
  Route::post("/users-agent-type","UserController@agent");

});

//Admin-dashboard Route

Route::group(["namespace"=>"Dashboard"],function(){
  Route::get("/dash","AdminIndexPageController@index");
});







