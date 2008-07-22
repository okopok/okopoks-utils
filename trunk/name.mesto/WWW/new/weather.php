<?php
error_reporting(all);
// WEATHER.COM XML PARSER
// Version 1.4
// Copyright 2005 Nick Schaffner
// http://53x11.com

//////// Set Varibles Below



$zipcode = '55306';				// Zipcode
$partner = 'XXXXXXXXXX';			// Partner ID
$license = 'XXXXXXXXXXXXXXXXXXXX';		// License Key
$wfile	 = 'public_html/weather.txt';		// Root to weather.txt
$icons	 = 'images/weather';			// Path to Weather Icons from Include
$email	 = false;				// Email yourself results?  True or False
$mailto	 = 'you@yourdomain.com';		// Your email address (if emailing results)
$units	 = 'english';				// Set to 'english' (Fahrenheit & MPH) or 'metric' (Celsius & KMH)
$clock	= 12;		// Set to '12' or '24' hour format

$url	 = 'http://xoap.weather.com/weather/local/';	// URL to xoap.weather



//////// Configure what the script outputs
//////// Edit if you have a knowledge of PHP and HTML

function output($conditions,$icon,$temp,$wind,$sun) { 

return "

<table border='0' cellspacing='0' cellpadding='0'>
	
	<tr>
	<td style='padding: 0px 10px 0px 10px; valign='top' align='center'>$icon<br />$conditions</td>

	<td valign='top' align='left'>Temp: $temp<br />Wind: $wind<br/>$sun</td>
	</tr>

</table>



"; }

//////// Parse XML

$file = "$url$zipcode?cc=*&&prod=xoap&par=$partner&key=$license";


$xml_parser = xml_parser_create();

$fp = fsockopen($file, "13");
   $out = "GET / HTTP/1.1\r\n";
   $out .= "Host: www.example.com\r\n";
   $out .= "Connection: Close\r\n\r\n";
fwrite($fp, $out);

/*
     if (file_exists($file)){
            $data = implode('', file($file));
         } else {
            $fp = fopen($file,'r');
*/
            while(!feof($fp)){
               $data = $data . fread($fp, 1024);
            }
            fclose($fp);
//	}

xml_parse_into_struct( $xml_parser, $data, $vals, $index );
xml_parser_free( $xml_parser );
    
$t = true;

foreach ($vals as $key => $i) {

if ($vals[$key]['value'] != false) {

	if ($vals[$key]['tag'] != 'T') { 
	
		$temp = strtolower($vals[$key]['tag']);
		$$temp = $vals[$key]['value'];

	} elseif ($t == true) { 

		if ($vals[$key]["level"] == 3) $conditions = $vals[$key]['value']; 
		else { $windir = $vals[$key]['value']; $t = false; break; }

	} 
}

}

//////// Make sense of the varibles

$sunr = str_replace (' ','',$sunr);
$suns = str_replace (' ','',$suns);
$date = date("l, F jS Y @ g:ia");
$temp_unit = '&#176;F';
$wind_unit = 'mph';

if ($units == 'metric') { // Set Metric
	$tmp = round((($tmp - 32)/9) * 5);
	$flik = round((($flik - 32)/9) * 5);
	$temp_unit = '&#176;C';
	$s = round($s * 1.609);
	$wind_unit = 'kmh';
}

if ($clock == 24)  {
	$sunr = date("H:i",strtotime($sunr));
	$suns = date("H:i",strtotime($suns));
	
}

$sun = "Dawn: $sunr - Dusk: $suns";

if ($tmp != $flik) $temp = "<b>$tmp$temp_unit</b> <i>(feels like $flik$temp_unit)</i>"; 
else $temp = "<b>$tmp$temp_unit</b>";

if ($s == 'calm') $wind = "<b>Calm</b>";
else $wind = "<b>$windir</b> @ <b>". $s . "</b> $wind_unit";

$icon = "<a href='http://www.weather.com/weather/local/$zipcode'><img border='0' alt='$conditions, Click for detailed weather for $zipcode' title='$conditions, Detailed weather for $zipcode' height='32' width='32' src='$icons/$icon.png' /></a>";
$props = "Weather.com XML Parser, Copyright " . date('Y') . " http://53x11.com";

$output = trim(output($conditions,$icon,$temp,$wind,$sun));
$output = "$output<!-- Generated on $date by $props-->";

//////// Write to file

$fd = fopen ($wfile , "w"); 
fwrite ($fd , $output);
fclose($fd);

//////// Email and Cron Job output

$replace = array('<','>','/','b','i');
$temp = str_replace($replace, '', $temp);
$wind = str_replace($replace, '', $wind);
$temp = str_replace('&#176;', '°', $temp);

$message = "Weather report for $zipcode\n\n$conditions\nTemp: $temp\nWind: $wind\n\n$sun\n\nGenerated on $date by $props";

echo $message;

if ($email) mail($mailto,"Weather.com XML Parse Results for $date",$message, "From: $mailto\nReply-To: $mailto");

?> 