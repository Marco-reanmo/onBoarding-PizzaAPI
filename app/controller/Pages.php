<?php
    class Pages extends Controller{
        
        public function __construct() {
            //Instantiiere Model
        }
        
        public function index() {
            $data = [
                'title' => 'Pizza API',
            ];
            $this->loadView('pages/index', $data);;
        }

        public function about() {
            $this->loadView('pages/about');
        }
    }
    