

<?php
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
