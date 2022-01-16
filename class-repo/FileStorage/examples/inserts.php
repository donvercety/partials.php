<?php

require __DIR__ . '/../lib/FileStorage.php';

$db = new FileStorage(__DIR__ . '/../db/inserts.json');

$sql = $db->get('sql');

if (is_array($sql)) {
	array_push($sql, [
		'id'        => uniqid(),
		'timestamp' => time(),
	]);
	$db->set('sql', $sql);

} else {
	$db->set('sql', [[
		'id'        => uniqid(),
		'timestamp' => time(),
	]]);
}

var_dump($db->dump());