<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeProviderOneController;
use App\Http\Controllers\EmployeeProviderTwoController;



Route::group(['middleware' => ['tracktik.auth']], function () {
    // Define your protected routes here
	Route::get('/user', function (Request $request) {
//		return $request->user();
		return "Hello there";
	});
	
	Route::post('/user', function (Request $request) {
//		return $request->user();
		return "Post Here";
	});

	

	Route::post('/provider1/employees', [EmployeeProviderOneController::class, 'store']);
	Route::put('/provider1/employees/{id}', [EmployeeProviderOneController::class, 'update']);
	Route::post('/provider2/employees', [EmployeeProviderTwoController::class, 'store']);
	Route::put('/provider2/employees/{id}', [EmployeeProviderTwoController::class, 'update']);
});