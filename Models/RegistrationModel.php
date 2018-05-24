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
 
Class RegistrationModel extends Model {
    private $admin_role_id;     
        
    function __initialize ()
    {
        $admin_role_id = 1;            
    }

   public function add_user($username, $password, $email) {
      $activate_key =  $this->generate_key();
      try {
        if(!empty($email)){
           $username = Validate::validate_string($username);
           $_password = Validate::validate_string($password);
           $password = Hash::hash_password($_password);
           $email = Validate::validate_email($email);
         
             if (! $this->check_if_registered($email)) {
               $sql = "INSERT INTO users(username, password, email, "
                . "activation) VALUES (?, ?, ?, ?)";
               $this->_setSql($sql);
               $this->add_record(array($username, $password, $email, 
               $activate_key));
               $this->send_activation_email($email, $activate_key );            
             }  //end of check if registered block        
           }// end of if email value empty block
      }catch(Exception $e) {
        echo 'Error: ' .$e->getMessage();
      }//end of try/catch block
    } //end add user function

    public function verify_password_match($pass, $conf_pass){      
      return Validate::validate_string_match($pass, $conf_pass);
    }
    
    private function check_if_registered($email){
      
         $sql = "SELECT username
                  FROM users 
                 WHERE 
                   email = ? ";
         $this->_setSql($sql); 
         $array = $this->fetch_record(array($email));
         if ($this->num_rows > 0 ){ 
             Error::set_error('email', 'Email: ' . $email . ' is already in use !!');            
         }else{
             return FALSE;
         }
   
    }
    
    public function generate_key(){
      return md5(uniqid(rand(), true));
    }
    
    public function send_activation_email($email, $activate_key){
         $activation = $this->generate_key();
         $message = " To activate your account, please click on this link:\n\n";
         $message .= DEFAULT_WEBSITE_URL . 'Activations/confirm/email=' . urlencode(trim($email)) . 
         "/key=$activate_key";
         Email::init($email, 'Confirm Registration to ' . DEFAULT_HOSTNAME, $message);
         Email::send_mail();        
         return TRUE;
    }

}

?>