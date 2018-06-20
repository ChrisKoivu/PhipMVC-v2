

<?php


class PostController extends Controller
{
    private $username;
    
    public function __construct($model, $action)
    {        
        parent::__construct($model, $action);            
        $this->_setModel(trim($model));
        $session = New Session();
        $this->username = trim($session->get_session_value('username'));
    }
     
   public function add_post() {
    
   try {  
      $error = '';
      /* validate if a post submission or just the display form */
      if($_SERVER["REQUEST_METHOD"] == "POST"){  
        if (!empty($this->username)) { 
        
          if (!empty($_POST['post_title']) && !empty($_POST['post_body'] )) {
  
             $title = $_POST['post_title'];
     
             $body = $_POST['post_body'];
           
             $this->_model->add_post($title, $body, $this->username);
        
          }
  else {
             $error = 'Posts require a title and a body';
          }
        }else{
           $error = 'Only authorized users can add a post';
        }  
      } // end of request method

      $this->_view->set('error', $error);
      return $this->_view->render();
    
   } catch (Exception $e) {
        
      echo "Application error:" . $e->getMessage();
    
   }
   
}

 // end of add post function


    // this method displays all of our posts
    // if $query empty, all posts displayed
    // if query has slug name, that post is shown
    public function index($query) {          
      try {     
         if(!empty($query)) {     
            $slug = '/post/index/' . trim($query);           
            $posts = $this->_model->read_post($slug);   
         } else {
            $posts = $this->_model->read_all_posts();
         }
         
         $this->_view->set('posts',$posts);        
         return $this->_view->render();       
      } catch (Exception $e) {        
         echo "Application error:" . $e->getMessage();      
      }
    } // end of index method

    public function edit($query){

         $error = '';
         if(!empty($query)){
            
              $slug = '/post/index/' . trim($query);
           
              $post = $this->_model->read_post($slug);
            
              $this->_view->set('title',$post['title']);
            
              $this->_view->set('body', $post['body']);
     
           
              if($_SERVER["REQUEST_METHOD"] == "POST"){   
                if ($post['user_username'] === $this->username) {   
                  if (!empty($_POST['post_title']) && !empty($_POST['post_body'] ) ) {
                
                    $title = $_POST['post_title'];
                
                    $body = $_POST['post_body'];
                               
                    $this->_model->edit_post($title, $body, $post['post_link']);
            
                  }
 else {
                    $error = "Title and body can not be blank";
                  }
                } else {
                  $error = "Only authorized users can edit a post";
                }
              }
   // end of post validation block
              $this->_view->set('error', $error);
 
              return $this->_view->render(); 
        }          
            
     } // end of edit post function
     
     public function delete($query){


  $error = '';
    
  $confirm = '';     
  if(!empty($query)){
 
     $slug = '/post/index/' . trim($query);
     $post = $this->_model->read_post($slug);
     $this->_view->set('title',$post['title']);
     $this->_view->set('body', $post['body']);
     
     
     if ($post['user_username'] === $this->username) { 
       $confirm = 'Are you sure you want to delete this post?'; 
       $this->_view->set('confirm',$confirm);

       if($_SERVER["REQUEST_METHOD"] == "POST"){ 
           $this->_model->delete_post($slug);
       }
      } else {
                  
         $error = "Only authorized users can delete a post";
                }
      } // end of username auth block        
     
   }else{
      $error = "Please select a post to delete";
   }
   $this->_view->set('error', $error);
   return $this->_view->render();
} // end of delete post function

} // End of PostController class 
