<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StduentController;
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

Route::get('/', function () {
	// $slug = 'hello inaam ul haq';
	// return str($slug)->slug();
	// return  Str::of($slug)->slug();
	//return Blade::render('{{$greeting}}world',['greeting'=>'hello']);
    return view('welcome');
})->name('home');

// Route::get('/endpoint', function () {
// 	return to_route('home');
// });


//Route::get('StduentController',[StduentController::class,'index']);
Route::controller(StduentController::class)->group(function(){
	Route::get('/StduentController','index');
});
Route::post('saveData',[StduentController::class,'save']);
Route::get('fetchdata',[StduentController::class,'fetch']);
Route::get('editStudent/{id}',[StduentController::class,'editStudent']);
Route::put('updateStudent/{id}',[StduentController::class,'updateStudent']);
Route::get('deleteStudent/{id}',[StduentController::class,'deleteStudent']);
Route::view("noaccess", "noaccess");
