
 	
<?php
 

class PostModel extends Model {
   public function __construct (){
      parent::__construct();
      if(!$this->model_table_exists()){
        $this->create_post_table();    
      }
   }

   /* create post method */
   public function add_post($title, $body, $username){
     // set objects
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

    
  /* update operation for the post model */ 
  public function edit_post($body, $slug){
    //set objects
    $db = New Database();    
    $conn = $db->db_connect();
    
    // define sql statement
    $sql = "UPDATE " . $this->table . " SET body = ? WHERE post_link = ?";
        
    // prepare sql statement if it is valid
    if($stmt = $conn->prepare($sql)){           
        // set values
        $post_link = $this->filter_post_link($slug);
        $body = $db->filter_input_value($body);
              
        // Bind variables
        if(!$stmt->bind_param("ss", $body, $post_link)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
              
        // execute query
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;       
        return false;      
    }
      $conn->close();
      unset($db);
      return true;
  } // end of edit function 


  /* delete post method */
  public function delete_post($slug){   
    // set objects
    $db = New Database();
    $conn = $db->db_connect();
    $post_link = $this->filter_post_link($slug);
    
    // define sql statement
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
  } // end of delete function

  private function create_post_table(){
    // set database object
    $db = New Database();
    // define sql to create post table
    $sql_post_table = "
        CREATE TABLE IF NOT EXISTS post(
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            title varchar(128) NOT NULL,
            body TEXT NOT NULL,
            post_link varchar(128) NOT NULL,
            user_username varchar(128) NOT NULL
        )
      ";
      // call parent create table method
      $this->create_model_table($sql_post_table);
  } // end of create post table function

  private function create_post_link($post_title){
    $title = trim(strtolower($post_title));
    $db = New Database();
    $title = $db->filter_input_value($title);
    $post_link = '/post/index/' . str_replace(' ', '_', $title);
    unset($db);
    return $post_link;
  } //end of create post link function

  private function filter_post_link($post_link){
    $base_url = str_replace('/post/index/','',$post_link);    
    $base_url = htmlspecialchars(stripslashes(trim($base_url)));
    $post_link = '/post/index/' . $base_url;     
    return $post_link;
  } // end of filter post link function

  private function get_post($slug){
    //set  objects 
    $db = New Database();
    $conn = $db->db_connect();
    $post_link = $this->filter_post_link($slug);
    $data = array();
    // define sql statement   
    $sql = "SELECT * FROM " . $this->table . " WHERE post_link = ? LIMIT 1";
    // prepare sql statement for binding 
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
  } // end of get post function

  public function get_my_posts($username){
      // setup objects      
      $db = New Database();
      $conn = $db->db_connect();       
      $data = array();
      
      // verify username was provided
      if(!empty($username))  {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_username = ?";
        // prepare sql statement
        if($stmt = $conn->prepare($sql)){
            // strip any tags, filter input
            $username = $db->filter_input_value($username);
            // Bind variables
            $stmt->bind_param("s", $username); 
          
            // execute the prepared statement
            if($stmt->execute()){     
              // fetch the rows and save to data array
              $result = $stmt->get_result();
              while ($row = $result->fetch_assoc())
              {
                $data[]= $row;
              }
            } // end execute prepared statement
            $stmt->close();
        }  // end prepare sql 
      }  // end username check

      $conn->close();
      // returns assoc array with query results or an empty array
      return $data;
  } // end of get my posts function

  // retrieve post id from post table
  private function get_post_id($post_link){   
    // set objects 
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
  } // end of get post id function

    
  // verifies post is unique 
  private function is_duplicate_post($post_title){
    $link = $this->create_post_link($post_title);
    if($this->get_post_id($link) < 0 ){
      return false;
    } else {
      return true;
    }
  } // end of is duplicate function

} // end of post model class
