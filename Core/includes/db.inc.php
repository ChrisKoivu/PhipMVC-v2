

<?php
/* ///////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright (c) June 28, 2015. Christopher M Koivu.


Permission is hereby granted, free of charge, to any person obtaining a copy of 
this software and associated documentation files (the "Software"), the rights to 
use, copy, modify, merge, publish, or distribute copies of the Software, and to 
permit persons to whom the Software is furnished to do so, subject to the 
following conditions:

The above copyright notice and this permission notice shall be included in all 
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION 
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
////////////////////////////////////////////////////////////////////////////////////////////////////////// */
 
  function db_connect(){
     $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

     if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
     }else{
        return $conn;
     }
    
   }
   


     /* mysqli method to create database */
    function create_database(){
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

    function create_table($sql){
        $conn = db_connect();
        if ($conn->query($sql) === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
        $conn->close();
    }

    function does_table_exist($tablename) {
      $conn = db_connect();
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
   
     function select_records($sql){
        $conn = db_connect();
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
    
     function delete_record($id, $table) {
        $conn = db_connect();
        $sql = "DELETE FROM ". $table . "WHERE id=" .$id;
        if ($conn->query($sql) === TRUE) {
          echo "Record deleted successfully";
        } else {
          echo "Error deleting record: " . $conn->error;
        }
        $conn->close();
     }

     