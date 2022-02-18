<?php

    /* 
    PDO Database Class
        -Connect 
        -Create prepared statements,
        -Bind Values
        -Return results 
    */

    class Database {

        private $host = DB_HOST;
        private $user = DB_USER;
        private $password = DB_PASSWORD;
        private $dbname = DB_NAME;

        private $dbhandler;
        private $statement;
        private $error;

        public function __construct() {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ];
            try {
                $this->dbhandler = new PDO($dsn, $this->user, $this->password, $options);
            } catch(PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        public function query($sql) {
            $this->statement = $this->dbhandler->prepare($sql);
        }

        public function bind($parameter, $value, $type = null) {
            if(is_null($type)) {
                $type = $this->getTypeBy($value);
            }
            $this->statement->bindValue($parameter, $value, $type);
        }

        private function getTypeBy($value) {
            switch(true) {
                case is_int($value):
                    return PDO::PARAM_INT;
                case is_bool($value):
                    return PDO::PARAM_BOOL;
                case is_null($value):
                    return PDO::PARAM_NULL;
                default:
                    return PDO::PARAM_STR;
            }
        }

        public function resultSet() {
            $this->execute();
            return $this->statement->fetchAll();
        }

        public function execute() {
            return $this->statement->execute();
        }

        public function single() {
            $this->execute();
            return $this->statement->fetch();
        }

        public function rowCount() {
            return $this->statement->rowCount();
        }

    }