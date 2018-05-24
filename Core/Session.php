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
       
      

        Public static function init() {
          // check for current session
          if (!self::get('session'))
          { 
            //create session if non-existent, suppress errors.
            @Session_start();
	    // set flag that session was created
            self::set('session',TRUE);            
          }          
        
        } 
    
     public static function set_user_data($username, $uid, $admin=FALSE){        
        self:: set('username', $username);
        self::set('uid', $uid);
        self::set('admin', $admin);
     }



public static function clear_user_data( ){
  self::set('username', NULL);
  self::set('uid', 0);
  self::set('admin', FALSE);
}
	 Public static function set($key, $value)
	 {
	    $_SESSION[$key]=filter_var($value,FILTER_SANITIZE_STRING);                     
	 }
         
	 Public static function get($key){
          if(isset($_SESSION[$key]))
	     Return $_SESSION[$key];
	 }
         
         Public static function get_session_id(){         
	     Return session_id();
	 }
         
   
         
    public static function clear_session_output(){
   if(isset($_SESSION['output']))
    $_SESSION['output']=NULL;
 }


 public static function get_session_output(){
   if(! isset($_SESSION['output']))
     $_SESSION['output']=NULL;
   return $_SESSION['output'];
 }


 Public static function set_session_output($value)
 {
   $_SESSION['output']=filter_var($value,FILTER_SANITIZE_STRING);                     
 }
 
 public static function clear_error_output(){
   if(isset($_SESSION['error']))
      $_SESSION['error']=NULL;
 }

 public static function get_error_output(){
   if(! isset($_SESSION['error']))
     $_SESSION['error']=NULL;
   return $_SESSION['error'];
 }


 Public static function set_error_output($value)
 {
   $_SESSION['error']=filter_var($value,FILTER_SANITIZE_STRING);                     
 }
         
         
	 Public static function destroy() {      
            self::clear_user_data( );
	    Session_destroy();
	 }
	 
         Public static function redirect($url){           
            header("Location: " . $url);
         }

}

?>
