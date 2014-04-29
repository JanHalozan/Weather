<?php
	
	// input
	$input = "UNITED STATES";
	
	// check if input is country name or country code
	if (strlen($input) == 2)
		$isCountry = false;
	else if (strlen($input) > 2)
		$isCountry = true;
	else
		return null;
	
	if ($isCountry)
		$input = ucwords(strtolower($input));
	else
		$input = strtoupper($input);
	
	$html = file_get_contents('http://countrycode.org/');
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");
	
	$dom = new DOMDocument('1.0', 'utf-8');
	@$dom->loadHTML($html);
	$xPath = new DomXPath($dom);
	
	// if input contain country name
	if ($isCountry)
	{
		$country = $xPath->query("//tr[td[a[contains(., '$input')]]]/td");
		
		if ($country->length > 0) // if xPath returned result
		{
			$ret = array('name' => ltrim(rtrim($country->item(0)->nodeValue)), 'code' => substr($country->item(1)->nodeValue, 0, 2));
		}
		else // try to find matching country (input : 'United States of America' => result : 'United States')
		{
			for ($i = 0; $i < strlen($input); $i = $i + 1)
			{
				$country = $xPath->query("//tr[td[a[contains(.,'" . substr($input, 0, $i) . "')]]]/td");
				if ($country->length == 6)
				{
					$ret = array('name' => ltrim(rtrim($country->item(0)->nodeValue)), 'code' => substr($country->item(1)->nodeValue, 0, 2));
					break;
				}
			}
		}
	}
	else	// input is country code
	{
		$input .= " / ";
		$country = $xPath->query("//tr[td[contains(.,'$input')]]/td");
		
		if ($country->length == 6)
		{
			$country_name = ltrim(rtrim($country->item(0)->nodeValue));
			$ret = array('name' => $country_name, 'code' => substr($country->item(1)->nodeValue, 0, 2));
		}
		else
			return null;
	}
	
	echo json_encode($ret);
	
	return $ret;
	
	