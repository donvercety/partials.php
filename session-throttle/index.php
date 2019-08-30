<?php

session_start();
include('./throttle.php');

// ex.
throttle([
	'id'          => 'api_request',       //.(required) String, unique identifier, so the throttler can keep track of multiple actions
	'throttleKey' => 'throttled',         // (optional) String, identifier for the throttler to work with in the $_SESSION array (default: 'throttled')
	'throttleFor' => 10,                  // (optional) Throttle user for X seconds (default: 60)
	'runsAllowed' => 5,                   // (optional) MAX allowed attempts (default: 1)
	'runsForTime' => 10,                  // (optional) Within X seconds (default: 20)
	'throttled'   => function($seconds) { // (required) You've been throttled, take some action!
		die("Dude! You've been throttled. Try again in {$seconds} seconds.");
	}
]);

var_dump($_SESSION);
