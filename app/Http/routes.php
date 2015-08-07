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

Route::any('/', function (SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
	try {
		$token = $fb->getPageTabHelper()->getAccessToken();
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		// Failed to obtain access token
		dd($e->getMessage());
	}

	if (! $token) {
		// Get the redirect helper
		$helper = $fb->getRedirectLoginHelper();

		if (! $helper->getError()) {
			echo '<script>window.top.location.href = "'.$fb->getLoginUrl(['email'], 'https://www.facebook.com/pages/Walking-Dead/178582138819465?sk=app_1616041778638428').'";</script>';
		}

		// User denied the request
		dd(
			$helper->getError(),
			$helper->getErrorCode(),
			$helper->getErrorReason(),
			$helper->getErrorDescription()
		);
	}

	if (! $token->isLongLived()) {
		// OAuth 2.0 client handler
		$oauth_client = $fb->getOAuth2Client();

		// Extend the access token.
		try {
			$token = $oauth_client->getLongLivedAccessToken($token);
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			dd($e->getMessage());
		}
	}

	$fb->setDefaultAccessToken($token);

	// Save for later
	Session::put('fb_user_access_token', (string) $token);    

	// Get basic info on the user from Facebook.
	try {
		$response = $fb->get('/me?fields=id,name,email');
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		dd($e->getMessage());
	}

	$facebook_user = $response->getGraphUser();
	Session::put('facebookID', $facebook_user['id']);


	$query = DB::table('usuarios')->where('facebookID', '=', $facebook_user['id'])->count();

	if($query > 0){
		return redirect('gallery');
	}else{
		return view('index')->with('userFacebookID', $facebook_user['id']);
	}
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

	return redirect('gallery');
});

Route::get('gallery', function () {
	if(isset($_GET['masVotados'])){
		$labels = DB::table('label')
			->select(array(
				'label.label',
				'usuarios.nombre',
				'label.id',
				DB::raw('(SELECT count(*) FROM votos WHERE votos.labelID = label.id) AS votos')
			))
			->join('usuarios', 'usuarios.id', '=', 'label.idUser')
			->orderBy('votos', 'desc')
			->paginate(6);
	}else if(isset($_GET['nombre'])){
		$labels = DB::table('label')
			->select(array(
				'label.label',
				'usuarios.nombre',
				'label.id',
				DB::raw('(SELECT count(*) FROM votos WHERE votos.labelID = label.id) AS votos')
			))
			->join('usuarios', 'usuarios.id', '=', 'label.idUser')
			->where('usuarios.nombre', 'like', '%'.$_GET['nombre'].'%')
			->orderBy('label.fecha', 'desc')
			->paginate(6);
	}else if(isset($_GET['alf'])){
		$labels = DB::table('label')
			->select(array(
				'label.label',
				'usuarios.nombre',
				'label.id',
				DB::raw('(SELECT count(*) FROM votos WHERE votos.labelID = label.id) AS votos')
			))
			->join('usuarios', 'usuarios.id', '=', 'label.idUser')
			->orderBy('usuarios.nombre', 'asc')
			->paginate(6);		
	}else{
		$labels = DB::table('label')
			->select(array(
				'label.label',
				'usuarios.nombre',
				'label.id',
				DB::raw('(SELECT count(*) FROM votos WHERE votos.labelID = label.id) AS votos')
			))
			->join('usuarios', 'usuarios.id', '=', 'label.idUser')
			->orderBy('label.fecha', 'desc')
			->paginate(6);
	}

	return view('gallery')->with('labels', $labels);
});

Route::post('ajaxVote', function () {
	$datos = Request::input();
	$datos['facebookID'] = Session::get('facebookID');
	$datos['fecha'] = date('Y-m-d H:i:s');

	$votos = DB::table('votos')
		->where('facebookID', '=',  $datos['facebookID'])
		->where('labelID', '=',  $datos['labelID'])
		->count();

	$response = new stdClass();

	if($votos > 0){
		$response->code = false;
		$response->message = 'Ya votaste por esta etiqueta';
	}else{
		DB::table('votos')->insert(
			$datos
		);

		$response->code = true;
		$response->message = 'Voto Exitoso';
	}

	echo json_encode($response);
});

Route::get('terminos', function () {

	//return view('gallery')->with('labels', $labels);
	return 'terminos';
});