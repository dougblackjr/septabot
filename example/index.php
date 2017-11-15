<?php

// CODE: Clear the variables we'll use
$trainLineName = '';
$response = array(
	'response_type' => 'ephemeral',
	'text' => ''
);
$finalResponse = '';

// CODE: Set the train lines
// Typically, we would want to call this dynamically and cache these, just in case SEPTA adds/removes a train line
// We will skip that for time
$trains = array(
	"airport",
	"chestnut-hill-east",
	"chestnut-hill-west",
	"cynwyd",
	"fox-chase",
	"glenside",
	"lansdale-doylestown",
	"manayunk-norristown",
	"media-elwyn",
	"paoli-thorndale",
	"trenton",
	"warminster",
	"west-trenton",
	"wilmington-newark"
);

// CODE: Get input from user
if (isset($_POST['command'])) {
	
	// Checks for Slack command
	$command = $_POST['command'];
	
	// Checks for text coming from Slack command
	$text = $_POST['text'];

	// Checks for token from Slack API
	$token = $_POST['token'];
	
	// Check the token and make sure the request is from our team 
	// Replace that with your token number
	if($token != '12345') {
		
		$msg = "I have died. I have no regrets. (Slack Token issue)";
	
		die($msg);

	}
}
// CODE: Get train key from text sent in
// We have to do some RegEx here
$pattern = '/' . preg_quote(strtolower($text), '/') . '/';
$trainLineName = preg_grep($pattern, $trains);
// Then we need to limit this to one train. We'll take the last one.
$trainLineName = end($trainLineName);

// CODE: Call SeptaStats API using cURL
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => 'http://www.septastats.com/api/current/line/'.$trainLineName.'/outbound/latest'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

// CODE: Create reply
$decoded = json_decode($resp, TRUE);

$data = $decoded['data'];

// Let's get a count of trains
$finalResponse = 'I see ' . count($data) . ' trains. ';

// If we got a response (the array is not null)
if (!is_null($data)) {
	// For each train
	foreach ($data as $key => $trainArray) {
		// Let's get the train number and destination
		$finalResponse .= 'Train ' . $trainArray['id'] . '\'s ';
		// Let's get the next stop
		$finalResponse .= 'next stop is ' . $trainArray['nextstop'] . '. ';
		// Let's get the lateness
		$finalResponse .= 'It is ' . $trainArray['late'] . ' minutes late. ' . PHP_EOL;
		// If you wanted to add a map
		// 'https://www.google.com/maps/place/' . $trainArray['lat'] . ' + ' . $trainArray['lon'] . '/';
	}
}

// CODE: Send back json_encoded array
$response['text'] = $finalResponse;

// CODE: Flush the object
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