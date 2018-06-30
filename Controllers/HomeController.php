
<?php

class HomeController extends Controller
{
    public function __construct($model, $action)
    {
        parent::__construct($model, $action);
        $this->_setModel($model);   	
    }
     
    public function index(){
           $this->_view->set('greeting', 'Welcome to my Home Page!');
           return $this->_view->render();
    }
    
    
}
