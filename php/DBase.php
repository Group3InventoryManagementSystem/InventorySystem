<?php 
    class DBConnect{
        private $database = "estates";
        private $user = "root";
        private $password = "";
        private $server = "localhost";
        private $charset = "utf8";

        private function connect(){
            try{
                $dsn = "mysql:host=".$this->server.";dbname=".$this->database.";charset".$this->charset;

                $connection = new PDO($dsn, $this->user, $this->password);

                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $connection;
            }catch(Exception $e){
                echo "Connection failed: ".$e->getMessage();
                die;
            }
        }

        public function query($query1, $tableName, $query2, $array){

            $query = $query1." ".$this->database.".".$tableName." ".$query2;
            $run = $this->connect()->prepare($query);

            try{
                $run->execute($array);
                return $run;
            }catch(Exception $ex){
                echo $ex;
                return false;
            }
        }

        public function encode($string){
            return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }
    }


?>