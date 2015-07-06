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

Route::get('/', function (SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
	$userFacebookID = 776627385;

    return view('index')->with('userFacebookID', $userFacebookID);
});

Route::post('/registro', function () {
	$extension = Input::file('foto')->getClientOriginalExtension(); // getting image extension
	$fileName = rand(11111,99999).'.'.$extension; // renameing image
	Input::file('foto')->move(public_path()."/uploads/sanson", $fileName);

	$datos = Request::input();
	$datos['foto'] = $fileName;
	$datos['fecha'] = date('Y-m-d H:i:s');

	$userID = DB::table('usuarios')->insertGetId(
		$datos
	);

    return view('uploadLabel')->with('userID', $userID);
});

Route::post('/upload', function () {
	$extension = Input::file('label')->getClientOriginalExtension(); // getting image extension
	$fileName = rand(11111,99999).'.'.$extension; // renameing image
	Input::file('label')->move(public_path()."/uploads/labels", $fileName);

	$datos = Request::input();
	$datos['label'] = $fileName;
	$datos['fecha'] = date('Y-m-d H:i:s');

	DB::table('label')->insert(
		$datos
	);

    return redirect()->route('gallery');
});

Route::get('gallery', function () {
	$labels = DB::table('label')
		->join('usuarios', 'usuarios.id', '=', 'label.idUser')
		->get();

    return view('gallery')->with('labels', $labels);
});