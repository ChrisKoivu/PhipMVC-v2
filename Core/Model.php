
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
    
    protected $table;

    public function __construct()
    {
    
        $this->table = trim(strtolower(trim(get_class($this))),'model');
    }

    protected function create_model_table($sql){
        $db = New Database();
        $db->create_table($sql);
    }

    protected function select_all_records(){
        $db = New Database();
        $conn = $db->db_connect();
        $data = array();
        $sql = "SELECT * FROM " . $this->table;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // save query results to associative array
            while($row = $result->fetch_assoc()) {
              $data[]=$row;
            }
           return $data;
        } else {
           return false;
        }
        $conn->close();       
    }
 
    protected function delete_record($id){

    }

    protected function select_record($id){

  
   $db = New Database();
    
   $conn = $db->db_connect();
   $data = array();


   $sql = "SELECT * FROM " . $this->table . " WHERE id = ?";

   if($stmt = $conn->prepare($sql)){

      // Bind variables
      $stmt->bind_param("i", $id); 

      // if $id is not an integer dont run query
      if (filter_var($id, FILTER_VALIDATE_INT)) {
         // execute the prepared statement
         if($stmt->execute()){     
           // fetch the rows and save to data array
           $result = $stmt->get_result();
           while ($row = $result->fetch_assoc())
           {
             $data[] = $row;
           }

         } 
         $stmt->close();
       }
   }    

   $conn->close();
   // returns assoc array with query results or an empty array
   return $data;
}

    protected function model_table_exists(){
      $db = New Database();
      return $db->table_exists($this->table);
    }
     
     
} // end of Model class

?>


