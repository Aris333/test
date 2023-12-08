<head>
  <!-- BEGIN Pre-requisites -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js">
  </script>
  <script src="https://apis.google.com/js/client:platform.js?onload=start" async defer>
  </script>
  <!-- END Pre-requisites -->
<!-- Continuing the <head> section -->
  <script>
    function start() {
      gapi.load('auth2', function() {
        auth2 = gapi.auth2.init({
          client_id: '499929518879-0ngkj1rd5vt1ntn2s5rqb93mp5ft0c03.apps.googleusercontent.com',
          // Scopes to request in addition to 'profile' and 'email'
          scope: 'https://www.googleapis.com/auth/business.manage',
          immediate: true
        });
      });
    }
  </script>
</head>
<body>
  <!-- Add where you want your sign-in button to render -->
<!-- Use an image that follows the branding guidelines in a real app, more info here:
 https://developers.google.com/identity/branding-guidelines
-->
<h1>Google My Business Offline Access Demo</h1>

<p> This demo demonstrates the use of using Google Identity Services and OAuth to gain authorization to call the Google My Business API on behalf of the user, even when the user is offline.

When a refresh token is acquired, store this token securely on your database. You will then be able to use this token to refresh the OAuth credentials and make offline API calls on behalf of the user. 

The user may revoke access at any time from the <a href='https://myaccount.google.com/permissions'>Account Settings</a> page.
</p>

<button id="signinButton">Sign in with Google</button><br>
<input id="authorizationCode" type="text" placeholder="Authorization Code" style="width: 60%"><button id="accessTokenButton" disabled>Retrieve Access/Refresh Token</button><br>
 <input id="refreshToken" type="text" placeholder="Refresh Token, never expires unless revoked" style="width: 60%"><button id="refreshSubmit">Refresh Access Token</button><br>
 <input id="accessToken" type="text" placeholder="Access Token" style="width: 60%"><button id="gmbAccounts">Get Google My Business Accounts</button><br>
 <p>API Responses:</p>
<script>
    //Will be populated after sign in.
    var authCode;
  $('#signinButton').click(function() {
    // signInCallback
    auth2.grantOfflineAccess().then(signInCallback);
  });

  $('#accessTokenButton').click(function() {
    // signInCallback defined in step 6.
    retrieveAccessTokenAndRefreshToken(authCode);
  });

  $('#refreshSubmit').click(function() {
    // signInCallback defined in step 6.
    retrieveAccessTokenFromRefreshToken($('#refreshToken').val());
  });

   $('#gmbAccounts').click(function() {
    // signInCallback defined in step 6.
    retrieveGoogleMyBusinessAccounts($('#accessToken').val());
  });




function signInCallback(authResult) {
    //the 'code' field from the response, used to retrieve access token and bearer token
  if (authResult['code']) {
    // Hide the sign-in button now that the user is authorized, for example:
    $('#signinButton').attr('style', 'display: none');
    authCode = authResult['code'];

    $("#accessTokenButton").attr( "disabled", false );

    //Pretty print response
    var e = document.createElement("pre")
    e.innerHTML = JSON.stringify(authResult, undefined, 2);
    document.body.appendChild(e);

    //autofill authorization code input
    $('#authorizationCode').val(authResult['code'])

    
  } else {
    // There was an error.
  }
}

//WARNING: THIS FUNCTION IS DISPLAYED FOR DEMONSTRATION PURPOSES ONLY. YOUR CLIENT_SECRET SHOULD NEVER BE EXPOSED ON THE CLIENT SIDE!!!!
function retrieveAccessTokenAndRefreshToken(code) {
      $.post('https://www.googleapis.com/oauth2/v4/token',
      { //the headers passed in the request
        'code' : code,
        'client_id' : '499929518879-0ngkj1rd5vt1ntn2s5rqb93mp5ft0c03.apps.googleusercontent.com',
        'client_secret' : 'mxpI8Brju6Xb7qJ2PIFQnrbm',
        'redirect_uri' : 'http://localhost',
        'grant_type' : 'authorization_code'
      },
      function(returnedData) {
        console.log(returnedData);
        //pretty print JSON response
        var e = document.createElement("pre")
        e.innerHTML = JSON.stringify(returnedData, undefined, 2);
        document.body.appendChild(e);
        $('#refreshToken').val(returnedData['refresh_token'])
      });
}

//WARNING: THIS FUNCTION IS DISPLAYED FOR DEMONSTRATION PURPOSES ONLY. YOUR CLIENT_SECRET SHOULD NEVER BE EXPOSED ON THE CLIENT SIDE!!!!
function retrieveAccessTokenFromRefreshToken(refreshToken) {
    $.post('https://www.googleapis.com/oauth2/v4/token', 
        { // the headers passed in the request
        'refresh_token' : refreshToken,
        'client_id' : '499929518879-0ngkj1rd5vt1ntn2s5rqb93mp5ft0c03.apps.googleusercontent.com',
        'client_secret' : 'mxpI8Brju6Xb7qJ2PIFQnrbm',
        'redirect_uri' : 'http://localhost',
        'grant_type' : 'refresh_token'
      },
      function(returnedData) {
        var e = document.createElement("pre")
        e.innerHTML = JSON.stringify(returnedData, undefined, 2);
        document.body.appendChild(e);
        $('#accessToken').val(returnedData['access_token'])
      });
}

function retrieveGoogleMyBusinessAccounts(accessToken) {
    $.ajax({
        type: 'GET',
        url: 'https://mybusiness.googleapis.com/v4/accounts',
        headers: {
            'Authorization' : 'Bearer ' + accessToken
        },
        success: function(returnedData) {
            var e = document.createElement("pre")
            e.innerHTML = JSON.stringify(returnedData, undefined, 2);
            document.body.appendChild(e);
        }
    });
}
</script>
</body>
</html>
