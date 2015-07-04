<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::post('/registro', function () {
	$extension = Input::file('foto')->getClientOriginalExtension(); // getting image extension
	$fileName = rand(11111,99999).'.'.$extension; // renameing image
	Input::file('foto')->move(public_path()."/uploads/sanson", $fileName);

	$datos = Request::input();
	$datos['foto'] = $fileName;

	DB::table('usuarios')->insert(
		$datos
	);

    return view('index');
});
