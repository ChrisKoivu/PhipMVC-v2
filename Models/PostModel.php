
 	
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
 


class PostModel extends Model
{
   public function __construct (){
      parent::__construct();
      if(!$this->model_table_exists()){
        $this->create_post_table();    
      }
      
   }
   

   /* create post method */
   public function add($title, $body){
      $db = New Database();
      $conn = $db->db_connect();
      
      // prepare and bind
      $stmt = $conn->prepare("INSERT INTO post (title, body, post_link) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $title, $body, $post_link);
     
      // set parameters and execute 
      $title = filter_input_value($title);
      $body = filter_input_value($body);
      $post_link = create_post_link($title);

      if($stmt->execute()){
          //header("Location: /user/login");
      }

      unset($db);
      $stmt->close();
      $conn->close();
     
   }

   /* read post method */
   public function read_post($id="ALL"){
       if ($id = "ALL"){
         // get all posts by default
         return $this->select_all_records();
       }else{
         // get selected post
          return $this->select_record($id);
       }
   }

   /* update post method */ 

   public function edit(){

   }

   /* delete post method */
   public function delete (){

   }

   private function get_post_id($post_link){
      $db = New Database();
      $conn = $db->db_connect();
      
      // prepare and bind
      $stmt = $conn->prepare("SELECT id FROM post WHERE post_link = ?");
      $stmt->bind_param("s", $post_link);
    
   }

   private function create_post_link($post_title){
     $post_link = trim(strtolower($post_title));
     $post_link = 'index/' . str_replace(' ', '_', $post_link);
     return $post_link;
   }

   private function create_post_table(){
    $db = New Database();

    $sql_post_table = "
      CREATE TABLE IF NOT EXISTS post(
          id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          title varchar(128) NOT NULL,
          body TEXT NOT NULL,
          post_link varchar(128) NOT NULL
      )
    ";
    $this->create_model_table($sql_post_table);
   }
   
}
