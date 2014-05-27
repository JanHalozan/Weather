<?php
	$con = new mysqli('localhost', 'developer', 'Sup3rG3sL0', 'development');
	mysqli_set_charset($con, 'utf8');

    // Get number of facts
    $result = mysqli_query($con,"SELECT COUNT(*) FROM facts WHERE `fact` IS NOT NULL");
    $row = mysqli_fetch_row($result);

    // If its zero table is empty
    if($row[0] == 0){
        // ------------------- ANIMAL FACTS
        @$html = file_get_contents("http://uselessfacts.net/animal-facts/");
            
        if($html === false)
        {
            echo "<p>error animal</p>";
        }
        else
        {
            // Load content and create xPath
            $doc = new DOMDocument();
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"); 
            @$doc->loadHTML($html);
            $xPath = new DomXPath($doc);
            
            foreach($xPath->query("//div[@class='facttext']") as $fact){
                if(strlen($fact->nodeValue) < 100){
                    mysqli_query($con, "INSERT INTO facts(fact) VALUES ('$fact->nodeValue')");
                }
            }
            echo "<p>done animal</p>";
        }

        // -------------------- FOOD FACTS
        @$html = file_get_contents("http://uselessfacts.net/food-facts/");
            
        if($html === false)
        {
            echo "<p>error food</p>";
        }
        else
        {
            // Load content and create xPath
            $doc = new DOMDocument();
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"); 
            @$doc->loadHTML($html);
            $xPath = new DomXPath($doc);
            
            foreach($xPath->query("//div[@class='facttext']") as $fact){
                if(strlen($fact->nodeValue) < 100){
                    mysqli_query($con, "INSERT INTO facts(fact) VALUES ('$fact->nodeValue')");
                }
            }
            echo "<p>done food</p>";
        }

    }

    // --------------- WEEKLY PARSE
    // Get 5 new facts from uselessfacts.net
    @$html = file_get_contents("http://uselessfacts.net/");
        
    if($html === false)
	{
    	echo "error";
    }
    else
    {
        // Load content and create xPath
        $doc = new DOMDocument();
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"); 
        @$doc->loadHTML($html);
        $xPath = new DomXPath($doc);
        
        $firstPageFacts = $xPath->query("//div[@class='facttext']");

        // Get last 5 facts from DB
        $last5Facts = mysqli_query($con, "SELECT fact FROM facts ORDER BY id DESC LIMIT 5");

        // Create temp array of those facts
        $counter = 0;
        while($fact = mysqli_fetch_array($last5Facts)){
            $array[$counter] = $fact['fact'];
            $counter++;
        }

        // for 5 new facts       
        for($i = 0; $i < 5; $i++) 
        {    

            $allredyKnown = false;

            for($j = 0; $j < 5; $j++) {        

                if(strlen($firstPageFacts->item($i)->nodeValue) < 100){
                    // If they are still old       
                    if($firstPageFacts->item($i)->nodeValue === $array[$j])
                    {
                        // Dont insert them
                        $allredyKnown = true;
                    }

                } else {

                    $allredyKnown = true;
                }

            }

            if($allredyKnown === false)
            {           
                mysqli_query($con, "INSERT INTO facts(fact) VALUES ('". $firstPageFacts->item($i)->nodeValue ."')");
                echo "<p>". $firstPageFacts->item($i)->nodeValue ."</p>";
                echo "<p>Added new fact</p>";
            
            }
        }                        
    }
    mysqli_close($con);
?>