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
	//$userFacebookID = 776627385;
    //return view('index')->with('userFacebookID', $userFacebookID);
    	echo '<script>window.location.assign("'.$fb->getLoginUrl(['email']).'")</script>';
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

Route::get('/facebook/callback', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
{
    // Obtain an access token.
    try {
        $token = $fb->getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.
    if (! $token) {
        // Get the redirect helper
        $helper = $fb->getRedirectLoginHelper();

        if (! $helper->getError()) {
            abort(403, 'Unauthorized action.');
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

    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
    $facebook_user = $response->getGraphUser();

    $query = DB::table('usuarios')->select('facebookID')->where('facebookID', '=', $facebook_user['id'])->first();

    if($query){
    	return redirect('gallery');
    }else{
    	return view('index')->with('userFacebookID', $facebook_user['id']);
    }
});