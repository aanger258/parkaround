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
Route::get('post',function(Request $request){
	$new_user = new User;
	$new_user->name = $request->name;
	$new_user->email = $request->email;
	$new_user->password = Hash::make($request->password);
	$new_user->save();
});

