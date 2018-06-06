

<?php


class PostController extends Controller
{
    public function __construct($model, $action)
    {        
        parent::__construct($model, $action);            
        $this->_setModel(trim($model));
        
    }
     
   public function add_post() {
    try {     
        if (!empty($_POST['post_title']) && !empty($_POST['post_body'] ) ) {
            $title = $_POST['post_title'];
            $body = $_POST['post_body'];
            $this->_model->add_post($title, $body);
         }
         return $this->_view->render();
    } catch (Exception $e) {
        echo "Application error:" . $e->getMessage();
    }
   }


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
        if(!empty($query)){
            $slug = '/post/index/' . trim($query);
            $post = $this->_model->read_post($slug);
            $this->_view->set('title',$post['title']);
            $this->_view->set('body', $post['body']);
            if (!empty($_POST['post_title']) && !empty($_POST['post_body'] ) ) {
                $title = $_POST['post_title'];
                $body = $_POST['post_body'];
                $this->_model->edit_post($title, $body, $post['post_link']);
             }
            return $this->_view->render();
        }
    }

} // End of PostController class 
