<?php

require 'Config.php';

$cfg = new Helpers\Config();
$cfg->load('conf.json');

var_dump($cfg->get('db.host.local'));
var_dump($cfg->get('db.port'));
var_dump($cfg->get('token'));
