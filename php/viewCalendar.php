<?php

include_once "calendarConfig.php";

include_once "../html/userCalendar.html";

if (isset($authUrl)) {
                        echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
                    } else {
                    echo <<<END
    <iframe src="https://www.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=blackrosestar333%40gmail.com&amp;color=%232952A3&amp;ctz=America%2FNew_York" style=" border-width:0 " width="800" height="600" frameborder="0" scrolling="no"></iframe>
END;
                    }

include "../html/test.php"; 

include "../html/calendarFooter.html";
