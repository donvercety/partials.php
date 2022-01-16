<?php

require __DIR__ . '/../lib/FileStorage.php';

try {
	$db = new FileStorage(__DIR__ . '/../db/key-value.json');

} catch (Exception $ex) {
	die(var_dump($ex->getMessage()));
}

$db->set(1, [
	"foo" => "bar"
]);


$db->set(2, [
	"test" => "best"
]);

$db->set(3, [
	"test" => [
		"check" => false,
		"tests" => true,
		"_data" => "unknown"
	]
]);

$db->set("admin", [
	"name"  => "Tommy Vercety",
	"pass"  => "098f6bcd4621d373cade4e832627b4f6",
	"email" => "test@test.com"
]);

var_dump($db->get(2));
var_dump($db->get("3.test._data"));
var_dump($db->get("admin.name"));

$db->del(2);

echo 'DB Dump:';
var_dump($db->dump());