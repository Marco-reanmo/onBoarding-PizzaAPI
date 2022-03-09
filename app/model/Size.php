<?php
    class Size {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getSizeByRadioButtonString($string) {
            $id = $this->radioButtonStringToId($string);
            $this->database->query('SELECT *
                                    FROM sizes
                                    WHERE ID = :id');
            $this->database->bind(':id', $id);
            return $this->database->single();
        }

        private function radioButtonStringToId($string) {
            switch($string) {
                case 'size_small': return 1;
                case 'size_medium': return 2;
                case 'size_large': return 3;
                default: return 0;
            }
        }
    }
