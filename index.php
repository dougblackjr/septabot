<?php

function getTrains() {

	// Set the train lines
	$ch = curl_init();

	curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://www.septastats.com/api/current/lines'
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
		// Is it a train name?
		$trainName = checkTrainNames($text, $allTrains);

		$response['text'] = $trainName;
	}


}

echo json_encode($response);

// Get train key from text sent in

// Call SeptaStats API using cURL

// Create reply

// If we got a response (the array is not null)
	// Let's get a count of trains
// Else
	// The user couldn't find their train, or they're being sassy


// Send back json_encoded array

// Flush the object

// Enjoy!