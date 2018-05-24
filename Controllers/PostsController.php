

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
 


class PostsController extends Controller
{
    public function __construct($model, $action)
    {        
        parent::__construct($model, $action);            
        $this->_setModel(trim($model, 's'));
     
    }
     
   public function add_post() {
        $username = Session::get('username');
        if (isset($_POST['submit']))
         {
          if(! $this->_model->add_post($username, $_POST['comment'])){
            Session::set_error_output('Unable to add post');   
          } 
         unset($_POST);
         Session::redirect('/posts/index');
         }
      }
 
    public function index()
    {
        try {          
            $posts= $this->_model->getPosts();              
            $this->_view->set('posts',$posts);
            //-------------------------------
            $username = Session::get('username');
            if (empty($username)){         
              Session::redirect(DEFAULT_PAGE);    
            }
            
            $this->_view->set('title', 'New Posts');
             
            return $this->_view->render();
             
        } catch (Exception $e) {
            echo "Application error:" . $e->getMessage();
        }
    }
}
