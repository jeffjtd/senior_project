
<?php
  /* DECLARED VARIABLES */
 
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
    FacebookSession::setDefaultApplication('427760157376315', 'cafdf42e83e677212b2c90024789d231');

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
      $request = new FacebookRequest( $session, 'GET', '/me/notifications' );
      $response = $request->execute();
      $graphObject = $response->getGraphObject()->asArray();    // get response
      //displayNotifications($graphObject);

      $request = new FacebookRequest($session, 'GET', '/me/inbox');
      $response = $request->execute();
      $graphObject = $response->getGraphObject()->asArray();
      
      displayMessages($graphObject);
    } else {
    	$params = array(
    		'scope' => 'manage_notifications', 'read_mailbox'
    		);
      
      echo '<a href="' . $helper->getLoginUrl($params) . '">Login</a>';   // show login url
    }

    function displayNotifications($graphObject) {
      for($i = 0; $i < sizeof($graphObject['data']); ++$i ) {
        if($graphObject['data'][$i]->unread == 1){
          echo '<pre>' . print_r( $graphObject['data'][$i]->title, 1);
        }
      }
    }


     function displayMessages($graphObject) {
      //echo '<pre>' . print_r( $graphObject,1);
      //echo '<pre>' . print_r( $graphObject['data'][0]->comments ,1);
      
      for($i = 0; $i < sizeof($graphObject['data']); $i++) {
        for($k = 0; $k < sizeof($graphObject['data'][$i]->comments->data); $k++) {
          if( isset($graphObject['data'][$i]->comments->data[$k]->message) ) {
            echo '<pre>' . print_r( $graphObject['data'][$i]->comments->data[$k]->from->name, 1) . '</pre>';
            echo '<pre>' . print_r( $graphObject['data'][$i]->comments->data[$k]->message, 1) . '</pre>';
          }
        }
      }
    }