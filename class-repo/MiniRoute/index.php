<?php

/* Including Route.php Class */
require ('lib/Route.php');
require ('controllers/Home.php');
require ('controllers/Contact.php');
require ('controllers/About.php');

/* Instantiating new $route Object */
$route = new Route([
    "view_path" => "./views/"
]);

// when using Classes
$route->add('/', 'Home');
$route->add('/about', 'About');
$route->add('/contact', 'Contact');

// when using functions
$route->add('/map', function() use ($route) {
    echo 'this is a func for map';
    
    // pretty parameters
    var_dump($route->getParams());

    // query string parameters
    var_dump($route->getData());
});

//echo '<pre>';
//print_r($route);
//echo '</pre>';

$route->submit();