<?php
	require_once 'google-api-php-client/vendor/autoload.php';
	require_once 'google-api-php-client/MyBusiness.php';

	$refresh_token = $_GET["refresh_token"];
	$access_token = $_GET["access_token"];

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
	
	if (isset($refresh_token)) {
	    $client->refreshToken($refresh_token);
		$access_token = $client->getAccessToken();
		
		$gmb = new Google_Service_MyBusiness($client);
		$accounts = $gmb->accounts->listAccounts();
		echo $accounts;
// 		$location = $gmb->accounts_locations->listAccountsLocations( $accounts[0]['name'] );
	}

?>
