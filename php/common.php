<?php 

/*
 * COMMON.PHP
 * Contains common functions to be used within the system
 */

/*
 * generate JSON output
 */
function generateOutput($output) {
	error_reporting(0);
 	if($_REQUEST["callback"]) {
 		header("Content-Type: text/javascript");
 		echo $_REQUEST["callback"].'('.json_encode($output).')';

 	} else {
 		header('Content-Type: application/x-json');
		echo json_encode($output);
 	}
}

/*
 * Havesine formula for distance calculation between two points on the earths surface
 */
function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit) {

	$theta = $lon1 - $lon2;

	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);

	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") {

		return ($miles * 1.609344);
	} else if ($unit == "N") {

		return ($miles * 0.8684);
	} else if($unit == 'M') {

		return ($miles * 1.609344) * 1000;
	} else {
		return $miles;
	}
}


?>