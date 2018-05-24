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
 
Class ActivationModel extends Model {
    
    
    
  public function activate_user($email, $key){
      if($this->verify_activation($email)){
         Error::set_error('activation', 'User is already activated');
         return FALSE;
      }else{
          /* user not activated, so confirm email */
          $this->confirm_user($email, $key);         
          return TRUE;
      }
  }  
  
  private function confirm_user($email, $key) {
     try {
         
         $sql = "UPDATE users "
          . "SET activation=NULL "
          . "WHERE(email ='$email' AND "
          . "activation='$key')LIMIT 1";
         
         $this->_setSql($sql);
         $this->update_record();        
         return TRUE;
      }
      catch(Exception $e) {
         Error::set_error('activation','Unable to activate user: Invalid key');
         return FALSE;
      }
   } //end validate user function
   
   private function verify_activation($email){
       $sql ="SELECT  
                activation FROM users
              WHERE email= ?";
       $this->_setSql($sql);
       $array = $this->fetch_record(array($email));
       
       if($this->num_rows > 0){
           return ($this->activation_key_null($array['activation']));
       }else{
           Error::set_error('activation','User is not registered');
           return FALSE;
       }
   }
   
   private function activation_key_null($key){
      if(empty($key)){
        return TRUE;
      }else{
        return FALSE;  
      }
   }

}

?>