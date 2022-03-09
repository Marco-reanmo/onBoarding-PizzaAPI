<?php
    class Category {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getAll() {
            $this->database->query('SELECT *
                                    FROM categories');
            return $this->database->resultSet();
        }

        public function getCategoryById($id) {
            $this->database->query('SELECT *
                                    FROM categories
                                    WHERE ID = :id');
            $this->database->bind(':id', $id);
            return $this->database->single();
        }

        public function getCategoryByName($name) {
            $this->database->query('SELECT *
                                    FROM categories
                                    WHERE name = :name');
            $this->database->bind(':name', $name);
            return $this->database->single();
        }        
    }