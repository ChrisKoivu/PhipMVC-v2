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
    
         public function does_table_exist($tablename) {
            $conn = $this->db_connect();
            // Check connection
             if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
             }
            try {   
                $sql = "select 1 from $tablename";
                $result = $conn->query($sql);
                return TRUE;
             }catch(PDOException $e){		       
                return FALSE;		        
             }
             $conn->close();
          }
         
          public function select_records($sql){
            $conn = $this->db_connect();
            $result = $conn->query($sql);
           
            if ($result->num_rows > 0) {
              // assign results to an associative array
               $records = $result->fetch_assoc();
               return $records;
            }
            $conn->close();
            return NULL;
         }
    
         /* 
            this function should not take external inputs,
            just processed by clicking a 'delete' button
            on a form
         */
        
         public function delete_record($id, $table) {
            $conn = $this->db_connect();
            $sql = "DELETE FROM ". $table . "WHERE id=" .$id;
            if ($conn->query($sql) === TRUE) {
              echo "Record deleted successfully";
            } else {
              echo "Error deleting record: " . $conn->error;
            }
            $conn->close();
         }
    


    }

?>