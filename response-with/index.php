<?php

error_reporting(E_ALL ^E_NOTICE);
ini_set('display_errors', 1);

include __DIR__ . '/http.php';

if ($_GET['action'] === 'text') {
	Http\Response\text('Hello World');
} else if ($_GET['action'] === 'html') {
	Http\Response\render('./template.php', ['text' => 'Hello World']);
} else if ($_GET['action'] === 'json') {
	Http\Response\json(['isok' => true]);
} else if ($_GET['action'] === 'redirect') {
	Http\Response\redirect('template.php');
} else {
	Http\Response\notFound();
}
