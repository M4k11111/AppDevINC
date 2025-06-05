<?php
    class Get {
        private $pdo;
        public function __construct(\PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function getEmployees(){
            $sql = "SELECT * FROM employees";
            $data = array();
            try{
                if($result = $this->pdo->query($sql)->fetchAll()){
                    foreach($result as $record){
                        array_push($data, $record);
                    }
                    return $data;
                }
            }
            catch(\PDOException $e){
                return $e->getMessage();
            }
            return "No records found";
        }
        public function getAccounts(){
            $sql = "SELECT * FROM accounts";
            $data = array();
            try{
                if($result = $this->pdo->query($sql)->fetchAll()){
                    foreach($result as $record){
                        array_push($data, $record);
                    }
                    return $data;
                }
            }
            catch(\PDOException $e){
                return $e->getMessage();
            }
            return "No records found";
        }
        public function getDTR(){
            $sql = "SELECT * FROM dtr";
            $data = array();
            try{
                if($result = $this->pdo->query($sql)->fetchAll()){
                    foreach($result as $record){
                        array_push($data, $record);
                    }
                    return $data;
                }
            }
            catch(\PDOException $e){
                return $e->getMessage();
            }
            return "No records found";
        }
    }
?>