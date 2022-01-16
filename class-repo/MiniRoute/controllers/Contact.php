<?php

class Contact {

    public function index(Route $route) {
        echo '<h2>This is the contact page. </h2>';
        
        echo "<code>Pretty parameters:</code>";
        var_dump($route->getParams());
        
        $this->_contactOther($route);
    }
    
    protected function _contactOther($route) {
        echo '<h3>This is the <code>_otherContact()</code> method bout, lolz!</h3>';
        
        echo "<code>Query String parameters:</code>";
        var_dump($route->getData());
    }
}