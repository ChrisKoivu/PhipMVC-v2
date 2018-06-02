
 	
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
   public function add(){

   }

   /* read post method */
   public function read($id="ALL"){
       if ($id = "ALL"){
         // get all posts
         $this->select_all_records();
       }else{
         // get selected post
         $this->select_record($id);
       }
   }

   /* update post method */ 

   public function edit(){

   }

   /* delete post method */
   public function delete (){

   }

   private function create_post_table(){
    $db = New Database();

    $sql_post_table = "
      CREATE TABLE IF NOT EXISTS post(
          id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          title varchar(128) NOT NULL,
          body TEXT NOT NULL
      )
    ";
    $this->create_model_table($sql_post_table);
   }
   
}
