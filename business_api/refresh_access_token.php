<?php
	require_once 'google-api-php-client/vendor/autoload.php';

	// $code = $_GET["code"];
	$access_token = $_GET["access_token"];
	$refresh_token = $_GET["refresh_token"];

// 	$redirect_uri = "http://localhost";
// 	$clientId = "499929518879-0ngkj1rd5vt1ntn2s5rqb93mp5ft0c03.apps.googleusercontent.com";
// 	$clientSecret = "mxpI8Brju6Xb7qJ2PIFQnrbm";
	
	$redirect_uri = "http://speedyfaxapp.com";
	// $redirect_uri = "https://www.stocknum.com";
	$clientId = "1012741349978-jtsvkor5dtci1vaioplj1lf04gr5asnh.apps.googleusercontent.com";
	$clientSecret = "RJLuha1d-ODh9Z-_Nz7r-2C1";

	$client = new Google_Client();

	// $client->setAuthConfig('client_credentials.json');
	$client->setApplicationName("My App");
	$client->setClientId($clientId);
	$client->setClientSecret($clientSecret);
	$client->addScope("https://www.googleapis.com/auth/plus.business.manage");
	$client->setAccessType("offline");
	$client->setRedirectUri($redirect_uri);

	if (isset($access_token) && isset($refresh_token)) {
		// $client->authenticate($code);
		$client->setAccessToken($access_token);
		if ($client->isAccessTokenExpired()) {
			$client->refreshToken($refresh_token);

			$result = $client->getAccessToken();
			$access_token = $result['access_token'];
			$refresh_token = $result['refresh_token'];

			$ret = Array();
			$ret['access_token'] = $access_token;
			$ret['refresh_token'] = $refresh_token;

			header('Content-Type: application/json');
			echo json_encode($ret);
		} else {
			$ret = Array();
			$ret['access_token'] = $access_token;
			$ret['refresh_token'] = $refresh_token;

			header('Content-Type: application/json');
			echo json_encode($ret);
		}
	}
?>
