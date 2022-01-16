<?php

/**
 * Mini Route v2.3
 *
 * Implements function or class callbacks for a specific url.
 * It implements beautiful urls with '/' separation for parameters.
 * It can detect which parameter is a class, method or a separate function,
 * all the parameters are accessible as a method of the Route class
 * use dependency injection, to get hold of the Route instance
 *
 * @author Tommy Vercety
 */
class Route {

    private $_uri        = [],
            $_controller = [],
            $_params     = null,
            $_getData    = null,
            $_match      = 0,
            $_viewPath   = "",
            $_method;

    /**
     * Constructor, settings can be 
     * added when instantiating class
     * @param array $settings
     */
    public function __construct($settings = []) {
        $this->settings($settings);
    }

    /**
     * Building a collection of internal URLs to look for.
     *
     * @param string $uri
     * @param string $controller
     */
    public function add($uri, $controller = null) {
        $this->_uri[] = '/' . trim($uri, '/');

        if($controller != null) {
            $this->_controller[] = $controller;
        }
    }

    /**
     * Makes the thing run
     */
    public function submit() {
        $this->_setGetData(filter_input_array(INPUT_GET));
        $uriArr = explode('/', $this->_parseURI());

        // adding '/' to each array entry
        foreach($uriArr as $param) {
            $params[] = "/{$param}";
        }

        $this->_method = isset($params[2]) ? ltrim($params[2], "/") : null;

        foreach ($this->_uri as $key => $value) {
            if (preg_match("#^$value$#", $params[1])) {
                $this->_match = 1;

                is_string($this->_controller[$key])
                    ? $this->_callClassCallback($key, $params)
                    : $this->_callFunctionCallback($key, $params);
            }
        }

        if (! $this->_match) {
            $this->_notFound();
        }
    }

    /**
     * Parse URI
     * @return string
     */
    private function _parseURI() {      
        return isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";
    }

    /**
     * Set Document Root
     * @param string $settings
     */
    public function settings($settings = []) {
        if (isset($settings["view_path"])) {
            $this->_viewPath = $settings["view_path"];
        }
    }

    /**
     * Render View File
     * @param  string $template
     * @param  array  $data
     */
    public function render($template, $data = []) {
        $path = "{$this->_viewPath}{$template}.php";
        
        if (file_exists($path)) {
            extract($data);
            require($path);
        }
    }

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    // :: Not Found 404
    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    /**
     * Method to be executed on a non-existing url.
     * @return void
     */
    private function _notFound() {
        header('HTTP/1.1 404 Not Found');
        echo '404: Page not found!';
    }

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    // :: Getters and Setters
    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    /**
     * Set URI Parameters
     * @param array $params
     */
    private function _setParams($params) {
        $this->_params = $params;
    }

    /**
     * Set Query String Parameters
     * @param array $get
     */
    private function _setGetData($get) {
        $this->_getData = $get;
    }

    /**
     * Get URI Parameters
     * @return array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * Get Query String Parameters
     * @return type
     */
    public function getData() {
        return $this->_getData;
    }

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    // :: Callbacks
    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    /**
     * This method is called when we pass a string
     * as a second parameter in the add() function
     * this means that we are trying to call a class.
     *
     * @param  string $key      current iteration key
     * @param  array  $params   optional
     * @return void
     */
    private function _callClassCallback($key, $params) {
        $count  = 0;
        $values = [];
        $class  = new $this->_controller[$key];

        $i = 3;

        if (! method_exists($class, $this->_method)) {
            $i = 2;
            $this->_method = 'index';
        }

        for (; $i < count($params); $i++) {
            $values[$count] = trim($params[$i], '/');
            $count++;
        }

        $this->_setParams($values);
        call_user_func_array([$class, $this->_method], [$this]);
    }

    /**
     * This method is called when we pass a
     * function callback in the add() method
     *
     * @param  string $key      current iteration key
     * @param  array  $params   optional
     * @return void
     */
    private function _callFunctionCallback($key, $params) {
        $count  = 0;
        $values = [];

        for ($i = 2; $i < count($params); $i++) {
            $values[$count] = trim($params[$i], '/');
            $count++;
        }

        $this->_setParams($values);
        call_user_func($this->_controller[$key]);
    }
}