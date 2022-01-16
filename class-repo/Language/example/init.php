<?php

require_once('../Language.php');

$l = new Language([
	"BG" => 0,
	"EN" => 1,
], 'data.txt');

// use query parameters, cookies or whatever you want..!
$l->chooseLanguage((strtoupper($_GET['lang']) == 'EN') ? "EN" : "BG");

