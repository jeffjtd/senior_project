
    <!--..............PHP................
IN THE CSS HIDE 
table .xdebug-error .xe-notice 
{
display:none;
}

-->
<?php
include_once "../html/links.html";
  session_start();
 require_once ('../fb/autoload.php');
  include_once "tabs.php";
  use Facebook\FacebookSession;
  use Facebook\FacebookRedirectLoginHelper;
  use Facebook\FacebookRequest;
  use Facebook\FacebookResponse;
  use Facebook\FacebookSDKException;
  use Facebook\FacebookRequestException;
  use Facebook\FacebookAuthorizationException;
  use Facebook\GraphObject;
  $appID = '647699142008684';
  $appSecret = 'd17fabe5860188788545b1bae4fd6813';
  FacebookSession::setDefaultApplication($appID, $appSecret);

  // login helper with redirect_uri
  $helper = new FacebookRedirectLoginHelper( 'http://localhost:/senior_project/php/viewFacebook.php' );
  FacebookSession::setDefaultApplication($appID, $appSecret);

  // login helper with redirect_uri
  $helper = new FacebookRedirectLoginHelper( 'http://localhost/senior_project/php/viewFacebook.php' );
   
  
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
    $request = new FacebookRequest( $session, 'GET', '/me' );
  $accessToken = $appID . '|' . $appSecret;

      
    $request = new FacebookRequest( $session, 'GET', '/me' );

    $response = $request->execute();
    $graphObject = $response->getGraphObject()->asArray();

    $name = $graphObject['name'];

    $request = new FacebookRequest( $session, 'GET', '/me/notifications' );
    $response = $request->execute();
    $graphObject = $response->getGraphObject()->asArray();    // get response
    displayNotifications($graphObject);
    //displayNotifications($graphObject);

    $request = new FacebookRequest($session, 'GET', '/me/inbox');
    $response = $request->execute();
    $graphObject = $response->getGraphObject()->asArray();
    
    displayMessages($graphObject, $name);
    
  
  } else {
    $params = array(
      'scope' => 'manage_notifications', 'read_mailbox'
      );
      // icon for facebook
  echo 
     "<div class='connectCalendar'>
            <a class='login' href='" . $helper->getLoginUrl($params) . "'><button class='pulse-button'><i class='fa fa-facebook'></i></button></a>
    </div>";
  }

  function displayNotifications($graphObject) {
     echo "<div class='notificationContent'>";
    for($i = 0; $i < sizeof($graphObject['data']); ++$i ) {
      if($graphObject['data'][$i]->unread == 1){
        echo "<div class='notifications'><pre>" . print_r( $graphObject['data'][$i]->title, 1) . "</pre></div>";
      //  echo '<pre>' . print_r( $graphObject['data'][$i]->title, 1) . '</pre>';
      }
    }
    echo "</div>";
  }

  function displayMessages($graphObject, $name) {

    $numChats = 0;
    echo "<div class='fbMsgContent'>";
    for($i = 0; $i < sizeof($graphObject['data']); $i++) {

      $unreadMessages = $graphObject['data'][$i]->unread;
      //Check to see if there are unread chats
      if($unreadMessages >= 0) {

        //Start a new row every 3 chats
        if($numChats % 3 == 0)
           echo '<div class="row">';

        //HTML header echo
        echo '<div class="col-lg-4">
                <div class="ibox float-e-margins">
                  <div class="ibox-title ">';

                      //Echo out users in group
                      for($numUsers = 0; $numUsers < sizeof($graphObject['data'][$i]->to->data); $numUsers++)
                        if( isset($graphObject['data'][$i]->to->data[$numUsers]) )
                          if($graphObject['data'][$i]->to->data[$numUsers]->name != $name)
                            if( $numUsers == sizeof($graphObject['data'][$i]->to->data) - 1 )
                              echo '<b>' . $graphObject['data'][$i]->to->data[$numUsers]->name . '</b>'; 
                            else echo '<b>' . $graphObject['data'][$i]->to->data[$numUsers]->name . '</b>' . ', '; 

                //Echo the rest of the header
                echo '
                  </div>
                  <div class="ibox-content">';

        //Echo the messages that haven't been read
        for($k = $unreadMessages+5; $k > 0; $k--) {
          $size = sizeof($graphObject['data'][$i]->comments->data) - $k;

          if( isset($graphObject['data'][$i]->comments->data[$size]->message) ) {
            echo '<b>' . $graphObject['data'][$i]->comments->data[$size]->from->name . '</b><br />';
            echo $graphObject['data'][$i]->comments->data[$size]->message . '<br />';
          }
        }

        echo '</div>
              </div>
              </div>';
        //End current row if this was the third chat
        if( ($numChats + 1) % 3 == 0)
          echo ' </div>';

        $numChats++;
      }
    }
    echo "</div>";
  }
?>
