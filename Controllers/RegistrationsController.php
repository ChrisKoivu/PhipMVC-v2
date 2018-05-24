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



class RegistrationsController extends Controller {

    public function __construct($model, $action)
    {        
      parent::__construct($model, $action);            
      $this->_setModel(rtrim($model, 's'));       
    }//end of constructor
     
   
    
    public function register()
    {
        try { 
            $this->_model->__initialize();       
            if (isset($_POST['submit']))
            {
               if($this->_model->verify_password_match($_POST['password'], $_POST['confirm_password'])){
                  $this->_model->add_user($_POST['username'], $_POST['password'], $_POST['email']);
                }
               unset($_POST);
            }
        }catch (Exception $e) {
           echo $e->getMessage();
        } // end of try-catch block
          return $this->_view->render();   
    }   // end log

}

?>
