<?php


// Define variables and initialize with empty values
$username = $email = $password =$confirm_password= "";
$username_err = $password_err = $confirm_password_err = $email_err = ""; 



// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
   require_once 'Database.php';
   
   $username = validate_username($_POST["username"]);   
   $password = validate_password($_POST['password']);
   $confirm_password = $_POST["confirm_password"];
   $email = validate_email($_POST['email']);
   
   // will return false if password doesnt match
   if(verify_password_match($password, $confirm_password)) {
       insert_user($username, $password, $email);
   }
} /* end of server request method */

function get_email_error(){
    global $email_err;
    return $email_err;
}

function get_username_error(){
    global $username_err;
    return $username_err;
}

function get_confirm_password_error(){
    global $confirm_password_err;
    return $confirm_password_err;
}

function get_password_error(){
    global $password_err;
    return $password_err;
}

function validate_email($email){
   global $email_err;

   // Remove all illegal characters from email
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate e-mail
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        $email_err = $email . ' is not a valid email address' ;
    }
}

function validate_username($username){
    
    global $username_err;

     // Validate username
    if(empty(trim($username))){
        $username_err = "Please enter a username.";
    } else{
        $db = New Database();
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";        
        $conn = $db->db_connect();

        if($stmt = $conn->prepare($sql)){

            // Bind variables
            $stmt->bind_param("s", $username);            

            // Set parameters
            $username = filter_input_value(trim($username));            

            // execute the prepared statement
            if($stmt->execute()){     
                $stmt->store_result();               

                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                   return $username;
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }        

        // Close query
        $stmt->close();
        $conn->close(); 
    } 
      
}

function validate_password($password) {
   global $password_err;

   if(empty(trim($password))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($password)) < 8){
        $password_err = "Password must have at least 8 characters.";
    } else{
        return filter_input_value(trim($password));
    }  
    
}



function verify_password_match($password, $confirm_password) {
    global $confirm_password_err;

    if(empty(trim($confirm_password))){
        $confirm_password_err = 'Please confirm password.';   
    } else{
        $confirm_password = filter_input_value(trim($confirm_password));

        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
            return false;
        }  else {
            return true;
        }
    }
}

function insert_user($username, $password, $email) {
    
     // check for invalid inputs 
     if(empty(get_username_error()) && empty(get_email_error()) && empty(get_password_error()) && empty(get_confirm_password_error())){  
        $db = New Database();
        $conn = $db->db_connect();
        
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, pw, email, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $pw, $email, $role_id);
       
        // set parameters and execute
        $pw = password_hash($password, PASSWORD_DEFAULT);
        $role_id = USER_ID;

        $stmt->execute();
        unset($db);
        $stmt->close();
        $conn->close();
      } // end of check input block
     
      
} //end of insert user function

 /* remove all html tags and characters */
 function filter_input_value($str) {
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return $str;
  }

?>