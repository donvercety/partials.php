<?php

$host    = '127.0.0.1';
$db      = 'db_name';
$user    = 'db_user';
$pass    = 'db_pass';
$charset = 'utf8mb4';

$dns = "mysql:host={$host};dbname={$db};charset={$charset}";
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false
];

$pdo = new PDO($dns, $user, $pass, $opt);

// echo json_encode($pdo->query('SELECT * FROM `users_table` LIMIT 10')->fetchAll());

