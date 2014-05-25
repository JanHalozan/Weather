<?php
	$con = new mysqli('localhost', 'developer', 'Sup3rG3sL0', 'development');
	mysqli_set_charset($con, 'utf8');

	// ONE TIME USE!!! TO CREATE SMALL POOL OF FACTS

	// ------------------- ANIMAL FACTS
	/*
	@$html = file_get_contents("http://uselessfacts.net/animal-facts/");
        
    if($html === false)
	{
    	echo "error animal";
    }
    else
    {
        // Load content and create xPath
        $doc = new DOMDocument();
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"); 
        @$doc->loadHTML($html);
        $xPath = new DomXPath($doc);
        
        foreach($xPath->query("//div[@class='facttext']") as $fact){
        	mysqli_query($con, "INSERT INTO facts(fact) VALUES ('$fact->nodeValue')");
        }
        echo "done animal";
    }

    // -------------------- FOOD FACTS
    @$html = file_get_contents("http://uselessfacts.net/food-facts/");
        
    if($html === false)
	{
    	echo "error food";
    }
    else
    {
        // Load content and create xPath
        $doc = new DOMDocument();
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"); 
        @$doc->loadHTML($html);
        $xPath = new DomXPath($doc);
        
        foreach($xPath->query("//div[@class='facttext']") as $fact){
        	mysqli_query($con, "INSERT INTO facts(fact) VALUES ('$fact->nodeValue')");
        }
        echo "done food";
    }
	*/

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

        // for 5 new facts
        for($i = 0; $i < 5; $i++) 
        {
        	$allredyKnown = false;

        	// Get last 5 facts from DB
		    $last5Facts = mysqli_query($con, "SELECT fact FROM facts ORDER BY id DESC LIMIT 5");

		    while($fact = mysqli_fetch_array($last5Facts))
		    {
		    	// If they are still old	    	
		    	if($firstPageFacts->item($i)->nodeValue == $fact['fact'])
		    	{
		    		// Dont insert them
		    		$allredyKnown == true;
		    	}	
		    }

		    if($allredyKnown == false)
		    {
        		mysqli_query($con, "INSERT INTO facts(fact) VALUES ('". $firstPageFacts->item($i)->nodeValue ."')");
        	}
        }       
    }
    mysqli_close($con);
?>