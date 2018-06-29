
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

require_once HOME . '/Core/includes/Database.php';

class Model 
{
    // set class variables
    private $error = "";
    protected $table;

    public function __construct()
    {
       $this->table = trim(strtolower(trim(get_class($this))),'model');
    }

    protected function create_model_table($sql){
        $db = New Database();
        $db->create_table($sql);
    } // end of create model table function

    protected function select_all_records(){
        // set objects
        $db = New Database();
        $conn = $db->db_connect();
        // set data array to empty array
        $data = array();
        // set sql to query all records from current table
        $sql = "SELECT * FROM " . $this->table;
        $result = $conn->query($sql);
        // if records found add to data array
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $data[]=$row;
          }
        }
        $conn->close();  
        return $data;    
    } // end of select all records function
 
    protected function delete_record($id){
        $db = New Database();
        $conn = $db->db_connect();
        $data = array();     
        $res = false; 
         // if $id is not an integer dont run query
        if (($id >= 0) && is_int($id)) { 
           $sql = "DELETE FROM " . $this->table . " WHERE id = ?";
           if($stmt = $conn->prepare($sql)){
             // Bind variables
             $stmt->bind_param("i", $id); 
             if($stmt->execute()){
                $res = true;
             } else {
                $this->error = "Delete failed: (" . $stmt->errno . ") " . $stmt->error;
             }
           }
        } else {
          $this->error = "The record id is invalid";
        }
        $stmt->close();
        $conn->close();
    } // end of delete record function
 
    protected function select_record($id){
      // set objects
      $db = New Database();
      $conn = $db->db_connect();
      // set data array to empty array
      $data = array();
      // if $id is not an integer dont run query
      if (($id >= 0) && is_int($id)) {
            $sql = "SELECT * FROM " . $this->table . " WHERE id = ?";
            if($stmt = $conn->prepare($sql)){
                // Bind variables
                $stmt->bind_param("i", $id); 
                
                // execute the prepared statement
                if($stmt->execute()){     
                    // fetch the rows and save to data array
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc())
                    {
                        $data = $row;
                    }
                } // end of execute sql block
                $stmt->close();
            }  // end of prepare statement block
       } // end of id check
       $conn->close();
       // returns assoc array with query results or an empty array
       return $data;
    }  // end of select record function

    protected function model_table_exists(){
      $db = New Database();
      return $db->table_exists($this->table);
    }
     
    public function get_error_message(){
        return $this->error;
    }
} // end of Model class

?>


