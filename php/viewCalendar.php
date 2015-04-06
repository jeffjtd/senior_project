<?php
header('X-Frame-Options: GOFORIT'); 
$isCalendarShowing = FALSE;

include_once "calendarConfig.php";


if (isset($authUrl)) {
    echo 
    "<div class='connectCalendar'>
            <a class='login' href='" . $authUrl . "'><button class='pulse-button'><i class='fa fa-calendar'></i></button></a>
    </div>";
    /* Log out Issue - if you log out of google, the pulse will not show up because authUrl is still set, but you need to clear it
    
    
    if (!$isCalendarShowing) {
        echo 
        "<div class='connectCalendar'>
                <a class='login' href='" . $authUrl . "'><button class='pulse-button'><i class='fa fa-calendar'></i></button></a>
        </div>";
    }*/
}

else {
    
    /* How do you get blackrosestar333@gmail.com? */
    echo 
        "<iframe id='myCalendar' src='https://www.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=jeffjtd745%40gmail.com&amp;color=%232952A3&amp;ctz=America%2FNew_York'></iframe>";
   // $isCalendarShowing = TRUE;
    include_once "../html/calendarForm.html";

}


