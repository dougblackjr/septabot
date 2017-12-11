<?php

function getTrains() {

	// Set the train lines
	$ch = curl_init();

	curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://www.septastats.com/api/current/stations'
		)
	);

	$resp = curl_exec($ch);

	if(curl_errno($ch)) {
		
		die('CURL ERROR: ' . curl_errno($ch));

	}

	curl_close($ch);

	$decoded = json_decode($resp, TRUE);

	return $decoded;

}

function getStationData($stationName) {

	$name = rawurlencode($stationName);

	// Get train info from station name
	$ch = curl_init();

	curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://www3.septa.org/hackathon/NextToArrive/Jefferson%20Station/' . $name
		)
	);

	$resp = curl_exec($ch);

	if(curl_errno($ch)) {
		
		die('CURL ERROR: ' . curl_errno($ch));

	}

	curl_close($ch);

	$decoded = json_decode($resp, TRUE);

	return $decoded;

}

function checkTrainNames($text, $trains) {

	$possibleTrains = array();

	foreach ($trains as $key => $value) {
		
		if (stripos(strtolower($value), strtolower($text)) !== FALSE) {
		    
		    $possibleTrains[] = $key;
		
		}

	}

	return $possibleTrains;

}




// Clear the variables we'll use
$trainName = '';
$response = array(
	'response_type' => 'ephemeral',
	'text' => ''
);
$finalResponse = '';

$decoded = getTrains();

$allTrains = $decoded['data'];
// var_dump($allTrains);die();

// Get input from user
if (isset($_POST['command'])) {

	$text = $_POST['text'];

	if($text == 'help') {

		$response['text'] = implode(' - ', $allTrains);

	} else {
		
		// Check if string is in list of stations
		$possibleStations = checkTrainNames($text, $allTrains);
		// If it is exact
		if(in_array($text, $possibleStations)) {
			// Get getStationData
			
		} else {
			// Else
			// Did you mean....list of possible stations
			$listOfStations = implode(' - ', $possibleStations);

			$finalResponse = 'Did you mean...' . $listOfStations;
		}
		
		// Set response text






		// $trainInfo = getStationData($text);

		$response['text'] = $finalResponse;
	}


}

echo json_encode($response);

// Flush the object

// Enjoy!