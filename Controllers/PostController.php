

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
          // check if logged in
          if (!empty($this->username)) { 
            // verify post has a title and a body
            if (!empty($_POST['post_title']) && !empty($_POST['post_body'] )) {
              // call the add post function in PostModel class
              if($this->_model->add_post($_POST['post_title'], $_POST['post_body'], $this->username)){
                $session = New Session();
                $session->redirect("/post/index/");
              }
            } else {
              $error = 'Posts require a title and a body';
            }
          }else{
            $error = 'Only authorized users can add a post';
          }  
        } // end of request method
       // send data to view and render
       $this->_view->set('error', $error);
       return $this->_view->render();
    } catch (Exception $e) {
      echo "Application error:" . $e->getMessage();
    }
  } // end of add post function


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
          // check for post request
          if($_SERVER["REQUEST_METHOD"] == "POST"){  
            // validate user is editing his post
            if ($post[0]['user_username'] === $this->username) {   
                if (!empty($_POST['post_body'] ) ){
                  $body = $_POST['post_body'];
                  $post_url =  $post[0]['post_link'];
                  if( $this->_model->edit_post($body, $post_url)){                 
                      $session = New Session();
                      $session->redirect($post_url);
                  }
                }else {
                  $error = "Title and body can not be blank";
                }//end of empty post check
                $auth = true;
            } else {
                  $error = "Only authorized users can edit a post";
                  $auth = false;
            } // end of auth user check 
         } // end of post validation block
         $this->_view->set('error', $error);
         return $this->_view->render(); 
       }  // end of query block
     } // end of edit post function
     
     public function delete($query){
        $error = '';
        $confirm = '';     
        if(!empty($query)){
           $slug = '/post/index/' . trim($query);
           if ($post = $this->_model->read_post($slug)){
              $post = $this->_model->read_post($slug);
              $title = $post[0]['title'];
              $body = $post[0]['body'];
              $this->_view->set('title', $title);
              $this->_view->set('body', $body );
              // check if user is auth
              if ($post[0]['user_username'] === $this->username) { 
                  $confirm = 'Are you sure you want to delete this post?'; 

                  if($_SERVER["REQUEST_METHOD"] == "POST"){ 
                    $this->_model->delete_post($slug);
                    $session = New Session();
                    $session->redirect("/post/index/");
                  }
              } else {
                $error = "Only authorized users can delete a post";
              } // end of auth user check 
            } else{
             $error = 'This post does not exist';
            }// end of if post exists check block
        } else {
           $error = 'You must specify a post to delete!';
        }// end of if empty query check        
        // send values to the view
        $this->_view->set('error', $error);
        $this->_view->set('confirm', $confirm);
        return $this->_view->render();
   } // end of delete post function

} // End of PostController class 
