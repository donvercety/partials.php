<?php

namespace Http\Request;

function isGet() {
	return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

function isPost() {
	return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function isPut() {
	return strtoupper($_SERVER['REQUEST_METHOD']) === 'PUT';
}

function isDelete() {
	return strtoupper($_SERVER['REQUEST_METHOD']) === 'DELETE';
}

function isAjax() {

	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		return false;
	}

	if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		return false;
	}

	if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		return true;
	}

	return false;
}
