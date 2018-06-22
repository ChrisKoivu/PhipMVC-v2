
 	
<?php
 

class PostModel extends Model
{
   public function __construct (){
      parent::__construct();
      if(!$this->model_table_exists()){
        $this->create_post_table();    
      }
      
   }
   

   /* create post method */
   public function add_post($title, $body, $username){
      $db = New Database();
      $conn = $db->db_connect();
      
      if(!$this->is_duplicate_post($title)){
            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO post (title, body, post_link, user_username) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $body, $post_link, $username);
          
            // set parameters and execute 
            $title = $db->filter_input_value($title);
            $body = $db->filter_input_value($body);
            $post_link = $this->create_post_link($title);     
            $username = $db->filter_input_value($username);
            $stmt->execute();
            $stmt->close();
          }else{
            print '<div class = "error-panel"> A post with this title already exists</div>';
      } // end of is duplicate post block
     
      unset($db);
      $conn->close();
     
   }

   /* read post method */
   
public function read_post($slug){
   
   return $this->get_post($slug);
      
}



/* get all saved posts */
public function read_all_posts(){
   return $this->select_all_records();

}

   /* update post method */ 

  public function edit_post($title, $body, $slug){
   /* get link to post being edited */
   $post_link = $slug;
       
   
      $db = New Database();    
      $conn = $db->db_connect();
    
      $sql = "UPDATE " . $this->table . " SET title = ? SET body = ? SET post_link = ? WHERE post_link = ?";
      

      /* bug is here, prepared statement not working */
      if($stmt = $conn->prepare($sql)){
           
           // set values
           $post_link = $this->filter_post_link($slug);
           $body = $db->filter_input_value($body);
           $title = $db->filter_input_value($title);
           $new_post_link = $this->create_post_link($title);
           
           // Bind variables
           if(!$stmt->bind_param("ssss", $title, $body, $new_post_link, $post_link)) {
             echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
           }

         
           
           // execute query
           if ($stmt->execute()) {
              //query with out errors:
              printf("rows updated: %d\n", $stmt->affected_rows);
           } else {
              //some error:
              printf("Error: %s.\n", $stmt->error);
           }
           $stmt->close();
       } else {
          echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;       
       }
       $conn->close();
       unset($db);
   
}


   /* delete post method */
   public function delete_post($slug){   
      $db = New Database();
    
      $conn = $db->db_connect();
      $post_link = $this->filter_post_link($slug);
   
      $sql = "DELETE FROM " . $this->table . " WHERE post_link = ?";
      if($stmt = $conn->prepare($sql)){
         // bind variables
         $stmt->bind_param("s", $post_link);
         // execute query
         $stmt->execute();
         $stmt->close();
      }   
      $conn->close();
      unset($db);    
}



   private function create_post_table(){
    $db = New Database();

    $sql_post_table = "
      CREATE TABLE IF NOT EXISTS post(
          id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          title varchar(128) NOT NULL,
          body TEXT NOT NULL,
          post_link varchar(128) NOT NULL,
          user_username varchar(128) NOT NULL
      )
    ";
    $this->create_model_table($sql_post_table);
   }

   private function create_post_link($post_title){
      $title = trim(strtolower($post_title));
      $db = New Database();
      $title = $db->filter_input_value($title);
      $post_link = '/post/index/' . str_replace(' ', '_', $title);
      unset($db);
      return $post_link;
   }

  private function filter_post_link($post_link){
    $base_url = str_replace('/post/index/','',$post_link);    
    $base_url = htmlspecialchars(stripslashes(trim($base_url)));
    $post_link = '/post/index/' . $base_url;     
    return $post_link;
 }


   private function get_post($slug){
      
      $db = New Database();
      $conn = $db->db_connect();
      $post_link = $this->filter_post_link($slug);
      $data = array();
      
      $sql = "SELECT * FROM " . $this->table . " WHERE post_link = ? LIMIT 1";
      
      if($stmt = $conn->prepare($sql)){
        
          // Bind variables
          $stmt->bind_param("s", $post_link); 
        
   
          // execute the prepared statement
          if($stmt->execute()){     
            
            // fetch the rows and save to data array
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc())
            {
              $data[]= $row;
            }

          } 
          $stmt->close();
     }    

      $conn->close();
      // returns assoc array with query results or an empty array
      return $data;
  } 

   // retrieve post id from post table
   private function get_post_id($post_link){
      $db = New Database();
      $conn = $db->db_connect();
      
      // prepare and bind
      $stmt = $conn->prepare("SELECT id FROM post WHERE post_link = ? LIMIT 1");
      $stmt->bind_param("s", $post_link);  
      if($stmt->execute()){
        $stmt->store_result();    
        if($stmt->num_rows == 1){
          $stmt->bind_result($id);
          if($stmt->fetch()){
            $result = $id;
          }
        }else{
          // no records, so returning -1
          $result = -1;
        }
      }
      
      $stmt->close();
      unset($db);
      return $result;
   }

  
   // verifies post is unique 
   private function is_duplicate_post($post_title){
      $link = $this->create_post_link($post_title);
      if($this->get_post_id($link) < 0 ){
        return false;
      } else {
        return true;
      }
   }


   
}
