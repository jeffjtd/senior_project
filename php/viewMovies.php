<?php include_once "../html/linksForm.html"; ?>
<?php include_once "tabs.php" ?>

<div id="movieForm">
     <form action="" method="post">   
    Location <input type="text" name="location">
        <br>
         <div class="inputType"> 
    <input type="submit" name="submitLocation1" value="View Movies">
     <input type="submit" name="submitLocation2" value="View Weather">
             </div>
</div>



<?php

/* Start of form */
 if(isset($_POST['submitLocation1']))
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
                echo "<div class='movieContent'>";
                    for($x=0;$x<$limit;$x++) {
                        $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                        $link = $feed[$x]['link'];
                        $description = $feed[$x]['desc'];
                        
                         echo "<div class='indivMovie'>";
                            echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';

                            $pieces = explode("<li>", $description);

                            foreach ($pieces as $piece) {
                                $piece = str_replace("</li>", "", $piece);
                                echo '<p>'.$piece.'</p>';
                            }
                        echo "</div>";
                    }
                echo "</div>";
           

        }
    }
/* End of form */




/* Start of form */
 if(isset($_POST['submitLocation2']))
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
            echo "<div class='weatherContent'>";
            for($x=0;$x<$limit;$x++) {
                $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                $link = $feed[$x]['link'];
                $description = $feed[$x]['desc'];
                $date = date('l F d, Y', strtotime($feed[$x]['date']));
                echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
                echo '<small><em>Posted on '.$date.'</em></small></p>';
                echo '<p>'.$description.'</p>';
            }
            echo "</div>";
             
        }
    }
/* End of form */
	
?>
    
    </body>
    </html>
