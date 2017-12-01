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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/foo', 'Foobarzip@index');
Route::get('/magic', 'MagicNumber@index');

// Route::get('/magic', function () {
// 	$generator = new App\Repositories\RandomRepository;
// 	$controller = new App\Http\Controllers\MagicNumber($generator);
// 	return $controller->index();
// });
