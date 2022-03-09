<?php
    require_once APPROOT . 'bootstrap.php';

    class Categories extends Controller {

        public function __construct() {
            $this->categoryModel = $this->loadModel('Category');
        }

        public function index() {
            if(isLoggedIn()) {
                $categories = $this->categoryModel->getAll();
                $data = [
                    'title' => 'Kategorien',
                    'categories' => $categories
                ];
                $this->loadView('categories/index', $data);
            } else {
                redirect('users/login');
            };
        }
    }