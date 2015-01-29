<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
include_once "../google-api-php-client/examples/templates/base.php";
include_once "../google-api-php-client/src/Google/Service/Calendar.php";
session_start();
require_once('../google-api-php-client/autoload.php');

/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/user-example.php
  
  Kathleen Client ID
  
 ************************************************/
 $client_id = '635183243049-cvq4vpcl6mla7fk2f3qpls8s9bboo4lg.apps.googleusercontent.com';
 $client_secret = '4QQUciU4XQQC0Q2ABIDARi5-';
 $redirect_uri = 'http://localhost/senior_project/php/viewCalendar.php';

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/calendar");
/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Calendar($client);
/************************************************
  If we're logging out we just need to clear our
  local access token in this case
 ************************************************/
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
 ************************************************/
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}
/******************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}

/* Start of form */
    if(isset($_POST['submit']))
    {
        header("Location: http://localhost/senior_project/php/viewCalendar.php");

        
        if( isset($_POST["date"]) || isset($_POST["hr"]) || isset($_POST["min"]) || isset($_POST["eventTitle"] ) || isset($_POST["endmin"]) || isset($_POST["endhr"] ))
         {
            $date = htmlspecialchars($_POST["date"]);
            $hr = htmlspecialchars($_POST["hr"]);
            $min = htmlspecialchars($_POST["min"]);
            $eventTitle = $_POST["eventTitle"];
            $ampm = htmlspecialchars($_POST["ampm"]);
            $endampm = htmlspecialchars($_POST["endampm"]);
    
            $endhr = htmlspecialchars($_POST["endhr"]);
            $endmin = htmlspecialchars($_POST["endmin"]);
    
            $calendar = $service->calendars->get('primary');
            $email = $calendar->getSummary();
    
             if($ampm == 'PM')
                 $hr += 12;
            $event = new Google_Service_Calendar_Event();
         
            $event->setSummary($eventTitle);
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime($date . 'T' . $hr . ':' . $min . ':00.000-05:00');
            $event->setStart($start);
            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime($date. 'T' . $endhr . ':' . $endmin . ':00.000-05:00');
            $event->setEnd($end);
            
            $attendee1 = new Google_Service_Calendar_EventAttendee();
            $attendee1->setEmail($email);
            $attendees = array($attendee1);
            $createdEvent = $service->events->insert('primary', $event);
             
        }
    }
     


?>

                    
 