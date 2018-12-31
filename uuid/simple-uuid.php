<?php

// http://php.net/manual/en/function.uniqid.php#94959
function gen_uuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand( 0, 0xffff ),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

echo gen_uuid() . PHP_EOL;
echo gen_uuid() . PHP_EOL;
echo gen_uuid() . PHP_EOL;
