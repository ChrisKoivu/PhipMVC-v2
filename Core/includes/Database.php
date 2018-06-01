<?php
    Class Database {
        public function __construct() {
            $this->create_database();


        }

        public function db_connect(){
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
       
            if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
            }else{
               return $conn;
            }
           
          }
         
        private function create_database(){
            // Create connection
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
            // Check connection
             if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
             }
             // Create database
              $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
              if ($conn->query($sql) === FALSE) {
                 echo "Error creating database: " . $conn->error;
              }
              $conn->close();
          }
      

          public function create_table($sql){
              $conn = $this->db_connect();
              if ($conn->query($sql) === TRUE) {
                 return TRUE;
              } else {
                 return FALSE;
             }
             $conn->close();
         }
    
         public function table_exists($tablename) {
           
            $conn = $this->db_connect();
            // Check connection
             if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
             }
            try {   
                $sql = "select 1 from $tablename";            
                $result = $conn->query($sql);
              
                if($result && $result->num_rows > 0){
                    return true;
                } else {
                    return false;
                }
             }catch(PDOException $e){		       
                return FALSE;		        
             }
             $conn->close();
          }
         
         /* remove all html tags and characters */
          function filter_input_value($str) {
            $str = trim($str);
            $str = stripslashes($str);
            $str = htmlspecialchars($str);
            return $str;
          }



    }/*end of Database class */

?>