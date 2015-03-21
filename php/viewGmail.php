<?php

include_once "gmailConfig.php";



if (isset($authUrl)) {
                        echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
                    } else {
                    


                    listMessages($service, "me");
}