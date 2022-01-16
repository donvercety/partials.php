<?php

class About {

    public function index(Route $route) {
        $route->render("about", [
            "title"  => "About Page",
            "params" => $route->getParams(),
            "query"  => $route->getData(),
        ]);
    }
}