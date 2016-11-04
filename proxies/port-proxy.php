<?php

// ====================================================== //
// Service Proxy for load balancing, based on device ids! //
// ====================================================== //

define('SERVICE_2', 29002);
define('SERVICE_1', 29001);

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
// :: Proxy Logic
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET") {
    $req = getRequestData();
    $wid = filter_input(INPUT_GET, 'getId', FILTER_VALIDATE_INT);

    if (isset($wid)) {
        $srv = selectServer($wid);
        $url = prepareUrl($req['host'], $srv);
    } else {
        $url = prepareUrl($req['host'], SERVICE_2);
    }

    $res = makeGetRequest($url, $req['headers']);
    renderResponse($res);

} else {

    $req = getRequestData();
    $wid = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT);

    if (isset($wid)) {
        $srv = selectServer($wid);
        $url = prepareUrl($req['host'], $srv);

    } else {
        $wid = filter_input(INPUT_GET, 'getId', FILTER_VALIDATE_INT);

        if (isset($wid)) {
            $srv = selectServer($wid);
            $url = prepareUrl($req['host'], $srv);
        } else {
            $url = prepareUrl($req['host'], SERVICE_1);
        }
    }

    $res = makePostRequest($url, $req['headers'], $req['body']);
    renderResponse($res);
}

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
// :: Functions
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

function getRequestData() {
    $headers = getallheaders();
    $body    = file_get_contents('php://input');
    $host    = split(':', $headers['Host'])[0];
    $head    = [];

    if (isset($_FILES['file'])) {
        $location = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
        $filetype = $_FILES['file']['type'];

        $head = [
            "Content-Type: multipart/form-data",
            "Expect: ",
            "Content-Disposition: form-data; name=\"file\"; filename=\"{$filename}\"",
            "Authorization: {$headers['Authorization']}"
        ];

        $body = ['file' => new CURLFile($location, $filetype, $filename)];

    } else {
        foreach ($headers as $key => $val) {
            $head[] = "{$key}: {$val}";
        }
    }

    return [
        'host'    => $host,
        'headers' => $head,
        'body'    => $body
    ];
}

function selectServer($wid) {
    return ($wid % 2 === 0) ? SERVICE_1 : SERVICE_2;
}

function prepareUrl($host, $port) {
    return "https://{$host}:{$port}{$_SERVER['REQUEST_URI']}";
}

function makeGetRequest($url, $headers) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1, // return the transfer as a string
        CURLOPT_FAILONERROR    => 0, // response code greater than 400 cause error
        CURLOPT_HEADER         => 1, // show curl response headers
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_URL            => $url,
    ));

    $resp = curl_exec($curl);

    curl_close($curl);
    return $resp;
}

function makePostRequest($url, $headers, $body) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1, // return the transfer as a string
        CURLOPT_FAILONERROR    => 0, // response code greater than 400 cause error
        CURLOPT_HEADER         => 1, // show curl response headers.
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_URL            => $url,
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     => $body,
    ));

    $resp = curl_exec($curl);

    curl_close($curl);
    return $resp;
}

function renderResponse($res) {
    $parsed  = split("\r\n\r\n", $res);

    $headers = split("\r\n", $parsed[0]);
    $body    = $parsed[1];

    foreach ($headers as $header) {
        header($header);
    }
    echo $body;
}
