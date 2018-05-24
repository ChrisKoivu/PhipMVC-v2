
 	
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

Class UserModel extends Model {
    private $admin_role_id;     
    public $email_address;    
    function __initialize ()
    {
        $admin_role_id = 1;
        $this->create_tables();
        $this->create_roles($admin_role_id);
        $this->create_admin($admin_role_id);       
    }

   
    /** 
     * Valid User function
     * verifies that user is an authorized user on the system. If they
     * are, then will login the user to the system
     * @param type $username the user's username
     * @param type $password the user's password
     * @return boolean returns true if user is authorized
     */
    public function valid_user($username, $password)
    {    
       /* validate entry format and filter */
      
       $username = Validate::validate_string($username);
       $password = Validate::validate_string($password);
       /* clear username to present on views */
          Session::set('username','');    
          Session::set('uid', NULL);  
          $sql = "SELECT id, 
            password, activation FROM users 
          WHERE 
            username = ? ";
         $this->_setSql($sql); 
         $array = $this->fetch_record(array($username));        
         Session::clear_error_output();
        
         if($this->logged_in($password, $array)){
              Session::set_user_data($username, $array['id']
              );              
              return TRUE;
         }else{
              Session::set_error_output('Invalid login. Please re-enter your password');            
              return FALSE;             
         }
         
       
    }
    
    /**
     * determines whether or not user logged in successfully. If true,
     * user is logged in.
     * @param type $password user entered password, which is compared to the 
     * hashed password
     * @param type $login_array the results array from the valid user query
     * @return boolean returns true if logged in, false if not logged in
     */
    Private function logged_in($password, $login_array){
        $pw_verified=Hash::verify_password_hash($password, 
        $login_array['password']);
        $validated_user = $this->is_activated($login_array['activation']);        
        if ($pw_verified && $validated_user){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * verifies that the email address was confirmed
     *  
     * @param type $key Null or the hashed key value, null if email address was 
     * confirmed
     * @return boolean true if activation key is now null
     * @throws type throws exception if activation key is a MD5 hash
     */
    Private function is_activated($key){
       Try{
          Session::clear_error_output();
          If($key!==NULL){
            throw new Exception("User is not activated !");
          } else {
             return TRUE;
          }
       
       }Catch (Exception $e){
          Session::set_error_output($e->getMessage());         
          return FALSE;
       }
    }
    
    public function forgot_password($email){
        $key =  $this->generate_key();
        $this->reset_activation_code($email, $key);
        $this->send_change_password_email($email, $key);        
    }
    
    protected function parse_url_query($string) {       
        if (! empty($string)) {
          parse_str($string, $array);
          return $array;
        }
    }
    
    public function verify_link($query_string){    
        Session::clear_error_output();
        $query_string = Validate::validate_string($query_string);       
        $array = $this->parse_url_query($query_string);  
        Session::set('email',  $array['email']);
        $key = $array['key'];
        if($this->validate_activation_code($key)){    
           return TRUE;
        }
        Session::set_error_output('Password change link is invalid. Please try again');
        return FALSE;
    }
    
   
   
    
   private function reset_activation_code($email, $activation_key){
         $sql = "UPDATE users "
          . "SET activation='$activation_key' "
          . "WHERE(email ='$email') LIMIT 1";         
         $this->_setSql($sql);
         $this->update_record();  
          if ($this->num_rows > 0 ){            
            return TRUE;
          }else {
            return FALSE;
          }
    }
    
    private function validate_activation_code($key){
        $sql = "UPDATE users "
          . "SET activation=NULL "
          . "WHERE(activation ='$key') LIMIT 1";         
         $this->_setSql($sql);
         $this->update_record(); 
         
        if ($this->num_rows > 0 ){
            return TRUE;
          }else {
            return FALSE;
          }
    }
    
    public function verify_password_match($pass, $conf_pass){      
      return Validate::validate_string_match($pass, $conf_pass);
    }
    
    public function create_new_password($new_password){
         Session::clear_error_output(); 
         $password= Hash::hash_password($new_password);
         $email=Session::get('email');
         $sql = "UPDATE users SET password=? WHERE email = ? "
                 . "LIMIT 1";         
         Session::clear_error_output();
         $this->_setSql($sql);
         $this->update_record(array($password, $email));        
         if ($this->num_rows > 0 ){       
            return TRUE;
          }else {
            Session::set_error_output('unable to set new password, email address ' . Session::get('email') . ' is not valid');
            return FALSE;
          }
    }
    
    private function generate_key(){
      return md5(uniqid(rand(), true));
    }
    
    private function send_change_password_email($email, $email_key){
         $activation = $this->generate_key();
         $message = " To reset your password, please click on this link:\n\n";
         $message .= DEFAULT_WEBSITE_URL . 'Users/change_password/email=' . urlencode(trim($email)) . 
         "/key=$email_key";
         Email::init($email, 'Reset your password', $message);
         Email::send_mail();        
         return TRUE;
    }
    
    
    /**
     * creates our user, role, and user in roles tables
     */
    function create_tables()
    {
        $sql ="CREATE TABLE IF NOT EXISTS users "
          . "(id INT NOT NULL AUTO_INCREMENT, "
          . "username VARCHAR(50), "
          . "password CHAR(40), "
          . "email VARCHAR(20), "
          . "activation VARCHAR(40), "
          . "PRIMARY KEY (id))";        
        $this->_setSql($sql);
        $this->create_table();
        
        $sql ="CREATE TABLE IF NOT EXISTS roles "
          . "(id INT NOT NULL, "
          . "name VARCHAR(50), "
          . "PRIMARY KEY (id))";   
        $this->_setSql($sql);
        $this->create_table();
        
     
        $sql ="CREATE TABLE IF NOT EXISTS users_in_roles "
             . "(id INT NOT NULL AUTO_INCREMENT, "
             . "user_id INT NOT NULL, "
             . "role_id INT NOT NULL, ";
        
        $sql .=" PRIMARY KEY (id), "
             . "FOREIGN KEY (user_id) REFERENCES users(id), "
             . "FOREIGN KEY (role_id) REFERENCES roles(id))";        
        $this->_setSql($sql);
        $this->create_table();      
    }

    /**
     * generates our users in role id's. one value for admin, and 2 for a 
     * regular user
     * @param type $admin_role_id the value id we are assigning to the admin
     */
    function create_roles($admin_role_id)
    {
        $query_check_roles_exist = "SELECT id FROM roles WHERE id <= 2";
        $statement_check_roles_exist = $this->_db->prepare($query_check_roles_exist);
        $statement_check_roles_exist->execute();
        
        if ($statement_check_roles_exist->fetch() == 0)
        {
            $query_insert_roles = "INSERT INTO roles (id, name) VALUES ($admin_role_id, 'admin'), (2, 'user')";
            $statement_inser_roles = $this->_db->prepare($query_insert_roles);
            $statement_inser_roles->execute();
        }
    }

    /**
     * creates an admin user for our application
     * @param type $admin_role_id the role id we are assigning to our admin
     */
    function create_admin($admin_role_id)
    {
        
        // HACK: Storing config values in variables so that they aren't passed by reference later.
        $default_admin_username = DEFAULT_ADMIN_USERNAME;
        $default_admin_password = DEFAULT_ADMIN_PASSWORD;

        $query_check_admin_exists = "SELECT id FROM users WHERE username = ? LIMIT 1";        
        $this->_setSql($query_check_admin_exists);
        $admin_user_id = $this->fetch_record(array($default_admin_username));
         
        if($this->num_rows == 0)
        {
            
            $sql = "INSERT INTO users (username, password) VALUES (?, SHA(?))";                    
            $this->_setSql($sql);
            $admin_user_id = $this->add_record(array($default_admin_username, $default_admin_password));
            
            $role_sql = "INSERT INTO users_in_roles(user_id, role_id) VALUES (?, ?)";
            $this->_setSql($role_sql);
            $this->add_record(array($admin_user_id, $admin_role_id));
          
        }
    }

   
}
?>
