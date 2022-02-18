<?php
    class User {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function emailIsTaken($new_email) {
            $this->row = $this->findUserByEmail($new_email);
            if ($this->database->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function findUserByEmail($email) {
            $this->database->query('SELECT * FROM users WHERE users.email = :email');
            $this->database->bind(':email', $email);
            return $this->database->single();
        }

        public function register($userData) {
            $addressID = $this->registerAddress(
                $userData['postal_code'],
                $userData['city'],
                $userData['street'],
                $userData['house_number']
            );
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
            $this->database->query('INSERT INTO users (name, email, password, address_ID) VALUES (:name, :email, :password, :address_ID)');
            $this->database->bind(':name', $userData['name']);
            $this->database->bind(':email', $userData['email']);
            $this->database->bind(':password', $userData['password']);
            $this->database->bind(':address_ID', $addressID);
            return $this->database->single();
        }

        private function registerAddress($postal_code, $city, $street, $house_number) {
            $this->database->query('INSERT INTO addresses (postalCode, city, street, houseNumber) VALUES (:postalCode, :city, :street, :houseNumber)');
            $this->database->bind(':postalCode', $postal_code);
            $this->database->bind(':city', $city);
            $this->database->bind(':street', $street);
            $this->database->bind(':houseNumber', $house_number);
            $this->database->single();    
            return $this->database->lastInsertId();
        }

        public function login($email, $password) {
            $row = $this->findUserByEmail($email);
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)) {
                return $row;
            } else {
                return false;
            }
        }

    }