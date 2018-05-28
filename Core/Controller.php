
<?php
/* ///////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright (c) June 28, 2015. Christopher M Koivu.


Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, or distribute copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED 
TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL 
THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
////////////////////////////////////////////////////////////////////////////////////////////////////////// */ 



class Controller
{
    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_view;
    protected $_modelBaseName;
    protected $user_role_id;
    
    public function __construct($model, $action)
    {   
        
        $this->_controller = ucwords(__CLASS__);
        $this->_action = $action;       
        $this->_modelBaseName = $model;            
        $this->_setView($action);      
        $this->_view->set_header();
        $this->_view->set_footer();           
    }
     
    protected function _setModel($modelName)
    {        
        $path= HOME . DS . 'Models'. DS ;
        $modelName .= 'Model';
       
        if (file_exists($path . $modelName. '.php'))
        {
          $this->_model = new $modelName();
        }
    }
     
    protected function _setView($viewName)
    {
        $this->_view = new View(HOME . DS . 'Views' . DS . $this->_modelBaseName . DS . $viewName . '.php');
    }
    
    
}
