<?php
    class Test extends Controller {
        
        public function __construct() {
            echo 'This is a test';
        }

        public function index() {
            $this->loadView('test/index');
        }

        public function about() {
            $this->loadView('Unknown');
        }
    }