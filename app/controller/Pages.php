<?php
    class Pages extends Controller{
        
        private $studentModel;

        public function __construct() {
            $this->studentModel = $this->loadModel('Student');
        }
        
        public function index() {
            $students = $this->studentModel->getAllStudents();
            $data = [
                'title' => 'Index',
                'students' => $students    
            ];
            $this->loadView('pages/index', $data);;
        }

        public function about() {
            $this->loadView('pages/about');
        }
    }
    