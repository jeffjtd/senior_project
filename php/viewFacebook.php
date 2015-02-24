
<!DOCTYPE html>
<html>

<head>
  <?php
    session_start();
  ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Index</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="../css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="../js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="../img/profile_small.jpg" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Bilbo Baggins</strong>
                             </span> <span class="text-muted text-xs block">Professional Burglar <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="profile.html">Profile</a></li>
                                <li><a href="contacts.html">Contacts</a></li>
                                <li><a href="mailbox.html">Mailbox</a></li>
                                <li class="divider"></li>
                                <li><a href="login.html">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            SMP
                        </div>
                    </li>
                    <li>
                        <a href="../index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <li>
                        <a href="viewCalendar.php"><i class="fa fa-th-large"></i> <span class="nav-label">Google Calendar</span></a>
                    </li>
                    <li class="active">
                        <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Facebook</span></a>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to SMP.</span>
                </li>
                <li>
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
                <div class="row  border-bottom white-bg dashboard-header">
                  <h1>
                    Facebook Messages & Notifications
                  </h1>
            </div>
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

                                        FacebookSession::setDefaultApplication('647699142008684', 'd17fabe5860188788545b1bae4fd6813');

                                        // login helper with redirect_uri
                                        $helper = new FacebookRedirectLoginHelper( 'http://localhost:81/senior_project/php/viewFacebook.php' );
                                        FacebookSession::setDefaultApplication('427760157376315', 'cafdf42e83e677212b2c90024789d231');

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
                                        $accessToken = '427760157376315' . '|' . 'cafdf42e83e677212b2c90024789d231';
                        
                                            
                                          $request = new FacebookRequest( $session, 'GET', '/me' );
                                    
                                          $response = $request->execute();
                                          $graphObject = $response->getGraphObject()->asArray();

                                          $name = $graphObject['name'];

                                          $request = new FacebookRequest( $session, 'GET', '/me/notifications' );
                                          $response = $request->execute();
                                          $graphObject = $response->getGraphObject()->asArray();    // get response
                                          //displayNotifications($graphObject);
                                          //displayNotifications($graphObject);

                                          $request = new FacebookRequest($session, 'GET', '/me/inbox');
                                          $response = $request->execute();
                                          $graphObject = $response->getGraphObject()->asArray();
                                          
                                          displayMessages($graphObject, $name);
                                          
                                          //$accessToken = '647699142008684' . '|' .'d17fabe5860188788545b1bae4fd6813';
                                          /* Real time Start*/
                                            /*
                                           $session = new FacebookSession($accessToken);
                                            $request = new FacebookRequest(
                                            $session,
                                            'GET',
                                            '/647699142008684/subscriptions'
                                            );
                                            $response = $request->execute();
                                            $graphObject = $response->getGraphObject()->asArray();
                                            echo '<pre>' . print_r($graphObject,1);
                                            $request = new FacebookRequest(
                                            $session,
                                            'POST',
                                            '/647699142008684/subscriptions',
                                            array (
                                            'object' => 'user',
                                            'callback_url' => 'callback.php',
                                            'fields' => 'about',
                                            'verify_token' => 'tokentest',
                                            )
                                            );
                                            $response = $request->execute();
                                            $graphObject = $response->getGraphObject();
                                                */
                                          /* Real time end */
                                          //displayMessages($graphObject, $name);
                                            
                                        /*    
                                        $session = new FacebookSession($accessToken);
                                           $request = new FacebookRequest(
                                              $session,
                                              'GET',
                                              '/427760157376315/subscriptions'
                                            );
                                            $response = $request->execute();
                                          $graphObject = $response->getGraphObject()->asArray();
                                            echo '<pre>' . print_r($graphObject,1);
                                            
                                            $request = new FacebookRequest(
                                              $session,
                                              'POST',
                                              '/427760157376315/subscriptions',
                                              array (
                                                'object' => 'user',
                                                'callback_url' => 'callback.php',
                                                'fields' => 'about',
                                                'verify_token' => 'tokentest',
                                              )
                                            );
                                            $response = $request->execute();
                                            $graphObject = $response->getGraphObject();*/
                                        } else {
                                          $params = array(
                                            'scope' => 'manage_notifications', 'read_mailbox'
                                            );
                                          echo '<div class="row">
                                                  <div class="col-lg-4"></div>
                                                  <div class="col-lg-4">
                                                      <div class="ibox float-e-margins">
                                                        <div class="ibox-title" style="text-align:center">
                                                        <h2>Facebook Permissions</h2> 
                                                        <br />
                                                        </div>
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
                                              echo '<pre>' . print_r( $graphObject['data'][$i]->title, 1);
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
                                                                 <i class="fa fa-exclamation-triangle"></i>
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

    <!-- Mainly scripts -->
    <script src="../js/jquery-2.1.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="../js/plugins/flot/jquery.flot.js"></script>
    <script src="../js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="../js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="../js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="../js/plugins/flot/jquery.flot.pie.js"></script>

    <!-- Peity -->
    <script src="../js/plugins/peity/jquery.peity.min.js"></script>
    <script src="../js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../js/inspinia.js"></script>
    <script src="../js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- GITTER -->
    <script src="../js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- EayPIE -->
    <script src="../js/plugins/easypiechart/jquery.easypiechart.js"></script>

    <!-- Sparkline -->
    <script src="../js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="../js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="../js/plugins/chartJs/Chart.min.js"></script>

</body>
</html>