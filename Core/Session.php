<?Php
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




Class Session
{
       
      

      public function __construct() { 
          // check for current session
          if (empty($this->get_session_id()))
          { 
            //create session if non-existent, suppress errors.
            @Session_start();             
          }             
        } 
        
        
      public function set_session_value($key, $value)
      {
          $_SESSION[$key]=filter_var($value,FILTER_SANITIZE_STRING);                     
      }
            
      public function get_session_value($key){
          if(isset($_SESSION[$key]))
            return $_SESSION[$key];
      }
            
      public function get_session_id(){         
          return session_id();
      }
            
      public function logout_session() {             
          // remove all session variables
          session_unset();
          // destroy the session
          session_destroy();
      }

      public function is_admin(){
         if($this->get_session_value('role_id') === trim(ADMIN_ROLE_ID)){
           return true;
         }else{
           return false;
         }
      }

      public function is_user(){
        if($this->get_session_value('role_id') === trim(USER_ROLE_ID)){
          return true;
        }else{
          return false;
        }
      }

      public function is_logged_in(){
        if($this->is_user()||$this->is_admin()){
          return true;
        }else{
          return false;
        }
      }
      
      public function redirect($url){           
          header("Location: " . $url);
      }

}

?>
