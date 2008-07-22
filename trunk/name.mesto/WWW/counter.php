<?php
// Our log file;
$counter = "counter.cnt";

// Date logging;
$today = getdate();
$month = date("M");
$mday = date("d");
$year = date("Y");
$current_date = $mday . $month . $year;
$ipad=$_SERVER["REMOTE_ADDR"];
// Log visit;
$fp = fopen($counter, "a");
$line = $ipad . "|" . $mday . $month . $year . "\n";
$size = strlen($line);
fputs($fp, $line, $size);
fclose($fp);

// Read log file into array;
$contents = file($counter);

// Total hits;
$total_hits = sizeof($contents);

// Total hosts;
$total_hosts = array();
for ($i=0;$i<sizeof($contents);$i++) {
	$entry = explode("|", $contents[$i]);
	array_push($total_hosts, $entry[0]);
}
$total_hosts_size = sizeof(array_unique($total_hosts));

// Daily hits;
$daily_hits = array();
for ($i=0;$i<sizeof($contents);$i++) {
	$entry = explode("|", $contents[$i]);
	if ($current_date == chop($entry[1])) {
		array_push($daily_hits, $entry[0]);
	}
}
$daily_hits_size = sizeof($daily_hits);

// Daily hosts;
$daily_hosts = array();
for ($i=0;$i<sizeof($contents);$i++) {
	$entry = explode("|", $contents[$i]);
	if ($current_date == chop($entry[1])) {
		array_push($daily_hosts, $entry[0]);
	}
}
$daily_hosts_size = sizeof(array_unique($daily_hosts));

// Let's display everything;
echo "Total hits: $total_hits, Total hosts: $total_hosts_size<br>Daily hits: $daily_hits_size, Daily hosts: $daily_hosts_size";
?>
