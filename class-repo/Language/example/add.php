<?php
require_once('init.php');
header("Content-Type: text/html; charset=utf-8");

if (isset($_GET['key']) && isset($_GET['val'])) {
	$l->setData($_GET['key'], $_GET['val']);
	$l->saveData('data.txt');
	echo "Success! {$_GET['key']} => {$_GET['val']}";
} else {
	die("Do something like: <code>?key=test&val=тест,test</code>");
}
