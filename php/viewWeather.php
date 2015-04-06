
<?php

include_once "../html/weatherForm.html";
 if(isset($_POST['submitLocation']))
    { 
        if( isset($_POST["location"]))
         {
            $location = htmlspecialchars($_POST["location"]);
            $rss = new DOMDocument();
            $stringLocation = 'http://weather.yahooapis.com/forecastrss?p=' . $location;
            $rss->load($stringLocation);
            $feed = array();
            foreach ($rss->getElementsByTagName('item') as $node) {
                $item = array ( 
                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                    'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                    'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                    );
                array_push($feed, $item);
            }
            $limit = 1;
            for($x=0;$x<$limit;$x++) {
                $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                $link = $feed[$x]['link'];
                $description = $feed[$x]['desc'];
                $date = date('l F d, Y', strtotime($feed[$x]['date']));
                echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
                echo '<small><em>Posted on '.$date.'</em></small></p>';
                echo '<p>'.$description.'</p>';
            }

             
        }
    }
/* End of form */
	