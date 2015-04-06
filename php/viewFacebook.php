<!DOCTYPE html>
<html>

<head>
  <?php
    session_start();
  ?>
    

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">


    <!-- Gritter -->
    <link href="../js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

   <!-- <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">-->
    <link href="../css/minStyle.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
    
                    <a href="login.html">
               
                    </a>
             
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                                      <!--..............PHP................-->
                                      <?php
                                       require_once ('../fb/autoload.php');

                                        use Facebook\FacebookSession;
                                        use Facebook\FacebookRedirectLoginHelper;
                                        use Facebook\FacebookRequest;
                                        use Facebook\FacebookResponse;
                                        use Facebook\FacebookSDKException;
                                        use Facebook\FacebookRequestException;
                                        use Facebook\FacebookAuthorizationException;
                                        use Facebook\GraphObject;
                                        $appID = '427760157376315';
                                        $appSecret = 'cafdf42e83e677212b2c90024789d231';
                                        FacebookSession::setDefaultApplication($appID, $appSecret);

                                        // login helper with redirect_uri
                                        $helper = new FacebookRedirectLoginHelper( 'http://localhost:81/senior_project/php/viewFacebook.php' );
                                        FacebookSession::setDefaultApplication($appID, $appSecret);

                                        // login helper with redirect_uri
                                        $helper = new FacebookRedirectLoginHelper( 'http://localhost:81/senior_project/php/viewFacebook.php' );

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
                                          echo '<div class="row">
                                                  <div class="col-lg-4"></div>
                                                  <div class="col-lg-4">
                                                      <div class="ibox float-e-margins">
                                                     
                                                        <div class="ibox-content" style="text-align:center">
                                                          <a style="text-decoration:none; color:white;"class="btn btn-primary btn-lg btn-link dim"                                                                  role="button" href="' . $helper->getLoginUrl($params) . '">Login</a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>';
                                          //echo '<a style="text-decoration:none; color:white;"class="btn btn-primary btn-lg btn-link dim" role="button" href="' . $helper->getLoginUrl($params) . '">Login</a>';   // show login url
                                        }

                                        function displayNotifications($graphObject) {
                                          for($i = 0; $i < sizeof($graphObject['data']); ++$i ) {
                                            if($graphObject['data'][$i]->unread == 1){
                                              echo '<pre>' . print_r( $graphObject['data'][$i]->title, 1) . '</pre>';
                                            //  echo '<pre>' . print_r( $graphObject['data'][$i]->title, 1) . '</pre>';
                                            }
                                          }
                                        }

                                        function displayMessages($graphObject, $name) {

                                          $numChats = 0;

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
                                                        <div class="ibox-title">';

                                                            //Echo out users in group
                                                            for($numUsers = 0; $numUsers < sizeof($graphObject['data'][$i]->to->data); $numUsers++)
                                                              if( isset($graphObject['data'][$i]->to->data[$numUsers]) )
                                                                if($graphObject['data'][$i]->to->data[$numUsers]->name != $name)
                                                                  if( $numUsers == sizeof($graphObject['data'][$i]->to->data) - 1 )
                                                                    echo '<b>' . $graphObject['data'][$i]->to->data[$numUsers]->name . '</b>'; 
                                                                  else echo '<b>' . $graphObject['data'][$i]->to->data[$numUsers]->name . '</b>' . ', '; 

                                                      //Echo the rest of the header
                                                      echo '<div class="ibox-tools">
                                                                 <i class="fa fa-exclamation-triangle"></i>New message(s)
                                                                 <i class="fa fa-exclamation-triangle"></i>
                                                                <a class="collapse-link">
                                                                    <i class="fa fa-chevron-up"></i>
                                                                </a>
                                                                <a class="close-link">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="ibox-content">';

                                              //Echo all the chat data
                                              /*for($k = 0; $k < sizeof($graphObject['data'][$i]->comments->data); $k++)
                                                if( isset($graphObject['data'][$i]->comments->data[$k]->message) ) {
                                                  echo '<b>' . $graphObject['data'][$i]->comments->data[$k]->from->name . '</b><br />';
                                                  echo $graphObject['data'][$i]->comments->data[$k]->message . '<br />';
                                                }
                                              */
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
                                        }
                                    ?>
                        </div>
                </div>
                <div class="footer">
                    <div class="pull-right">
                        10GB of <strong>250GB</strong> Free.
                    </div>
                    <div>
                        <strong>Copyright</strong> Example Company &copy; 2014-2015
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>

</body>
</html>