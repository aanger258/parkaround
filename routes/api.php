<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('ceva',function(){
	return 'ceva';
});
Route::post('addNewUser', function(Request $request){
	return User::addNewUser($request);
});
Route::post('checkUser', function(Request $request){
	return User::checkUser($request);
});
Route::post('getParkingSpots', 'LocationController@getParkingSpots';