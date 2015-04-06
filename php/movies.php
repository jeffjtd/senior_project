<!DOCTYPE html>

<html>
    <div id="1"></div>
     <form action="" method="post">   
    Location <input type="text" name="location">
        <br>
    <input type="submit" name="submitLocation" value="submit">
</div>

</html>

<?php


/* Start of form */
 if(isset($_POST['submitLocation']))
    { 
        if( isset($_POST["location"]))
         {
            $location = htmlspecialchars($_POST["location"]);
            $rss = new DOMDocument();
            $stringLocation = 'http://www.fandango.com/rss/moviesnearme_' . $location . '.rss';
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
                
                echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
                
                $pieces = explode("<li>", $description);
                
                foreach ($pieces as $piece) {
                    $piece = str_replace("</li>", "", $piece);
                    echo '<p>'.$piece.'</p>';
                }
            }

             
        }
    }
/* End of form */
	