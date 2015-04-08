<?php
include_once "../html/links.html";
session_start(); 
include_once "gmailConfig.php";
include_once "tabs.php";

if (isset($authUrl)) {
                            echo 
    "<div class='connectCalendar'>
            <a class='login' href='" . $authUrl . "'><button class='pulse-button'><i class='fa fa-envelope'></i></button></a>
    </div>";
                    } 
else {
    echo "<div class='emailContent'>";
        listMessages($service, "me");
    echo "</div>";
}