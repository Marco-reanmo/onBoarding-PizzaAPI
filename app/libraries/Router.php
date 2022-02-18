<?php
  /*
   * App Router Class
   * URL FORMAT - /controller/method/params
   */
  class Router {
    protected $controller;
    protected $method;
    protected $params;

    public function __construct() {

      $urlParams = $this->getUrlParameters();

      $classname = ucwords($urlParams[0]);
      $this->controller = $this->initController($classname);
      unset($urlParams[0]);

      if(isset($urlParams[1])) {
        $methodname = $urlParams[1];
        $this->method = $this->initMethod($methodname);
        unset($urlParams[1]);
      } else { //Default
        $this->method = 'index';
      }
      
      $this->params = $urlParams ? array_values($urlParams) : [];

      call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function getUrlParameters() {
      if(isset($_GET['url'])) {
        $url = $this->adaptUrl($_GET['url']);
        $parameters = explode('/', $url);
        return $parameters;
      }
    }

    private function adaptUrl($url) {
      $result = rtrim($url, '/');
      $result = filter_var($result, FILTER_SANITIZE_URL);
      return $result; 
    }

    private function initController($classname) {
      if(file_exists(APPROOT . 'controller/' . $classname . '.php')) {
        require_once APPROOT . 'controller/'. $classname . '.php';
        return new $classname;
      } else { //Default
        require_once APPROOT . 'controller/Pages.php';
        $classname = 'Pages';
        return new $classname;
      }
    }

    private function initMethod($methodname) {
      if(method_exists($this->controller, $methodname)){
        return $methodname;
      } else { //Default
        return 'index';
      }
    }

  }
