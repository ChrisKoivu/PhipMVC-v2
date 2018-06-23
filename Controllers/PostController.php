

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
         
         $this->_view->set('username', $this->username);
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
              
            
              $this->_view->set('title',$post[0]['title']);
            
              $this->_view->set('body', $post[0]['body']);
     
           
              if($_SERVER["REQUEST_METHOD"] == "POST"){   
                if ($post[0]['user_username'] === $this->username) {   
                  if (!empty($_POST['post_body'] ) ){
                    $body = $_POST['post_body'];
                    $post_url =  $post[0]['post_link'];
                     if( $this->_model->edit_post($body, $post_url)){
                    
                      $session = New Session();
                      $session->redirect($post_url);
                     }
                  }
 else {
                    $error = "Title and body can not be blank";
                  }
                  $auth = true;
                } else {
                  $error = "Only authorized users can edit a post";
                  $auth = false;
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
     if ($post = $this->_model->read_post($slug)){
        $post = $this->_model->read_post($slug);
        print_r($post);

        $title = $post[0]['title'];
        $body = $post[0]['body'];

        $this->_view->set('title', $title);
        $this->_view->set('body', $body );
        
     
        if ($post[0]['user_username'] === $this->username) { 
          $confirm = 'Are you sure you want to delete this post?'; 

          if($_SERVER["REQUEST_METHOD"] == "POST"){ 
           $this->_model->delete_post($slug);
          }
        } else {
                  
          $error = "Only authorized users can delete a post";
         } // end of auth user check 
       } else{
         $error = 'This post does not exist';
       }// end of if post exists check block
      } // end of if empty query check        
     
   $this->_view->set('error', $error);
   $this->_view->set('confirm', $confirm);
   return $this->_view->render();
} // end of delete post function

} // End of PostController class 
