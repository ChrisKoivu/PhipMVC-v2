

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



class UserController extends Controller
{    
    private $_key, $_email;
    public function __construct($model, $action)
    {     
        parent::__construct($model, $action);
        $this->_setModel($model);      
    }//end of constructor
     
    public function register(){
        /* overriding the default header set in the parent class */
        $this->_view->set_header('header-register.php');
        /* render the view */
        return $this->_view->render();
    }

    public function login(){
        /* overriding the default header set in the parent class */
        $this->_view->set_header('header-register.php');
        /* render the view */
        return $this->_view->render();
    }

    public function admin(){
       $error = "";
       $session = New Session();
       if ($session->is_admin()){ 
         // do some action
       }else{
         $error = 'You are not an Administrator of this website';
       }
       $this->_view->set('error', $error);
       return $this->_view->render();
    }

    public function logout(){
        /* logout of the session */
        $session = New Session();
        $session->logout_session();
        /* render the view */
        return $this->_view->render();
    }
    
    } //end of user controller class
