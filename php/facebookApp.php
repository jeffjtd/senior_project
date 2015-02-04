
<?php

    session_start();
 
	require_once ('../fb/autoload.php');

    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    use Facebook\FacebookResponse;
    use Facebook\FacebookSDKException;
    use Facebook\FacebookRequestException;
    use Facebook\FacebookAuthorizationException;
    use Facebook\GraphObject;

    // init app with app id (APPID) and secret (SECRET)
    FacebookSession::setDefaultApplication('647699142008684', 'd17fabe5860188788545b1bae4fd6813');

    // login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper( 'http://localhost/senior_project/php/facebookApp.php' );

    try {
      $session = $helper->getSessionFromRedirect();
    } catch( FacebookRequestException $ex ) {
      // When Facebook returns an error
    } catch( Exception $ex ) {
      // When validation fails or other local issues
    }

    // see if we have a session
    if ( isset( $session ) ) {
      // graph api request for user data
      $request = new FacebookRequest( $session, 'GET', '/me/notifications' );
      $response = $request->execute();
      // get response
      $graphObject = $response->getGraphObject()->asArray();

      // print data
      //echo  print_r( $graphObject, 1 );
      echo '<pre>' . print_r( $graphObject['data'][0]->title, 1);
    
    } else {
    	$params = array(
    		'scope' => 'manage_notifications'
    		);
      // show login url
      echo '<a href="' . $helper->getLoginUrl($params) . '">Login</a>';
    }