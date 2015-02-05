<?php

    session_start();

    require_once( '../fb/autoload.php' );
    
    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    use Facebook\FacebookResponse;
    use Facebook\FacebookSDKException;
    use Facebook\FacebookRequestException;
    use Facebook\FacebookAuthorizationException;
    use Facebook\GraphObject;

    // init app with app id (APPID) and secret (SECRET)
    FacebookSession::setDefaultApplication('427760157376315','cafdf42e83e677212b2c90024789d231');

    // login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper( 'http://localhost:81/senior_project/php/facebookApp.php' );

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
        $request = new FacebookRequest(
          $session,
          'GET',
          '/me/notifications'
        );
        $response = $request->execute();
        $graphObject = $response->getGraphObject()->asArray();
        $backingData = $graphObject['backingData'];
        $data = $backingData[data][0];
        
      echo  $data;
    } else {
        $params = array(
          'scope' => 'manage_notifications'
        );
      echo '<a href="' . $helper->getLoginUrl($params) . '">Login</a>';
    }