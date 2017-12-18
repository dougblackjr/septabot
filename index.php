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
			
			// Get Station Data into response
			$stationData = getStationData($text);

			// Give count of trains
			$finalResponse .= "Here are the next trains from Jefferson Station to {$text}:" . PHP_EOL;

			// Loop through first two
			for ($i = 0; $i < 2; $i++) { 
				// What line it is?
				$finalResponse .= 'I see a ' . $stationData[$i]['orig_line'] . ' train ';
				// Next time train is departing Jefferson
				$finalResponse .= 'departing at ' . $stationData[$i]['orig_departure_time'] . ' ';
				// Arrival time at destination
				$finalResponse .= "and arriving to {$text} around " . $stationData[$i]['orig_arrival_time'] . '. ';
				// Is it late?
				if($stationData[$i]['orig_delay'] == 'On time') {
					
					$finalResponse .= 'It is on time!';

					if($i == 0) {
						
						$finalResponse .= PHP_EOL;

					} else {

						$finalResponse .= ':fire_septa::fire_septa::fire_septa:';

					}

				} else {

					$finalResponse .= 'It is currently ' . $stationData[$i]['orig_delay'] . ' late.' . PHP_EOL;

				}
				
			}
			
		} else {
			// Else
			// Did you mean....list of possible stations
			if(empty($possibleStations)) {

				$finalResponse = 'Learn how to use a computer. :fire_septa:';

			} elseif(count($possibleStations) > 10) {

				$finalResponse = 'Too many results. Go Google it (or try a different search)';

			} else {

				$listOfStations = implode(' - ', $possibleStations);

				$finalResponse = 'Did you mean...' . $listOfStations;

			}

		}
		
		// Set response text
		$response['text'] = $finalResponse;
	}


}

// Flush the object
// This looks confusing but is necessary for Slack to see it
ignore_user_abort(true);
set_time_limit(0);
ob_start();
// do initial processing here
echo json_encode($response); // send the response
header('Connection: close');
header("Content-Type: application/json");
header('Content-Length: '.ob_get_length());
ob_end_flush();
ob_flush();
flush();
// Enjoy!