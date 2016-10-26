<?php

namespace Http\Response;

function text($text) {
	header('Content-Type: text/plain');
	echo $text;
}

function json($data) {
	header('Content-Type: application/json');
	echo json_encode($data);
}

function render($template, array $data = array()) {
	header('Content-Type: text/html');

	if (file_exists($template)) {
		extract($data);
		require($template);
	}
}

function redirect($location) {
	return header('Location: ' . $location);
}

function notFound() {
	header('HTTP/1.0 404 Not Found');
	echo '404 Not Found';
}