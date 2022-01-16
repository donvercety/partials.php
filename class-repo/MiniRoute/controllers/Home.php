<?php

class Home {
    
    public function index(Route $route) {
        echo '<h2>This is the home page. </h2>';
        
        echo "<code>Pretty parameters:</code>";
        var_dump($route->getParams());
        
        $this->_homeOther($route);
    }
    
    protected function _homeOther($route) {
        echo '<h3>This is the <code>_homeOther()</code> method, lolz!</h3>';
        
        echo "<code>Query String parameters:</code>";
        var_dump($route->getData());
    }
}