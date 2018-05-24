
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

class Model
{
    protected $_db;
    protected $_sql;
    protected $num_rows;
   
    
    public function __construct()
    {
       /* $this->_db = Database::init();   */
       
    }
     
     protected function _setSql($sql)
     {
         $this->_sql = $sql;
     }
     
      public function create_table(){
      try {
          if (!$this->_sql)
          {
            throw new Exception("No SQL query!");
          }   
          $conn = $this->_db->prepare($this->_sql);
          $conn->execute();                
      } catch (Exception $ex) {
          echo $this->_sql . "<br>" . $ex->getMessage();
      }        
    }
    
       public function add_record($data = null){
       if (!$this->_sql)
        {
            throw new Exception("No SQL query!");
        }        
        $conn = $this->_db->prepare($this->_sql);
        $conn->execute($data);        
        $last_id = $this->_db->lastInsertId();
        return $last_id;
    }
   
    public function fetch_all($data = null)
    {
        if (!$this->_sql)
        {
            throw new Exception("No SQL query!");
        }
         
        $conn = $this->_db->prepare($this->_sql);
        $conn->execute($data);
        return $conn->fetchAll();
    }
     
    public function fetch_record($data = null)
    {
        if (!$this->_sql)
        {
            throw new Exception("No SQL query!");
        }
         
        $conn = $this->_db->prepare($this->_sql);
        $conn->execute($data);        
        $this->num_rows = $conn->rowCount();
        return $conn->fetch();
    }

   
   public function update_record($data=NULL){  
      try{
        if (!$this->_sql)
        {
            throw new Exception("No SQL query!");
        }
         
          $conn = $this->_db->prepare($this->_sql);
          $conn->execute($data);
          $this->num_rows=$conn->rowCount();
      
        if ($this->num_rows > 0 ){
          return TRUE;
        }else {
          return FALSE;
        }
      }catch(Exception $ex){
           echo $this->_sql . "<br>" . $ex->getMessage();
      }
   } 

   public function delete_record($table, $query_field, $query_value){
     $sql = "DELETE FROM " . $table . " WHERE " . $query_field . "='" . $query_value . "'";
     $conn = $this->_db->prepare($sql);
     $conn->execute();  
   }
   
   protected function parse_url_query($string) {
        if (! empty($string)) {
          parse_str($string, $array);
          return $array;          
        }
    }
    
    protected function get_datetime() {
       $objDateTime = new DateTime('NOW');
       $date_time = $objDateTime->format('Y-m-d H:i:s');      
       //$phpdate = strtotime($date_time);
       return $date_time;
       //return $phpdate;
    }

     protected function is_admin($uid)    
    {   
        $query = "SELECT user_id FROM users_in_roles UIR INNER JOIN roles R on 
        UIR.role_id = R.id WHERE R.name = 'admin' AND UIR.user_id = ? LIMIT 1";   
        $this->_setSql($query); 
        $this->fetch_record(array($uid));
         if ($this->num_rows > 0 )          
            return TRUE;
         return FALSE;
    } 
}


