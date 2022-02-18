<?php
    class Student {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getAllStudents() {
            $this->database->query("SELECT * FROM students");
            return $this->database->resultSet();
        }
    }