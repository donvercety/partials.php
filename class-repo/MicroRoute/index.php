<?php

class Router
{
    private $r = [];

    function add($r, callable $c)
    {
        $this->r[$r] = $c;
    }

    function run()
    {
        $c = $this->r;
        isset($c[$_GET["p"]]) ? $c[$_GET["p"]]() : $c[""]();
    }
}

// Init Router Class

$r = new Router;

$r->add("/", function() {
    echo "home";
});

$r->add("/lib", function() {
    echo "lib";
});

// to be used for 404 not found pages
$r->add("", function() {
    echo "404";
});

$r->run();
