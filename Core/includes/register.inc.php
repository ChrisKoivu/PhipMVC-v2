<?php


// Define variables and initialize with empty values
$username = $password =$confirm_password= "";
$username_err = $password_err = $confirm_password_err = ""; 



// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
   require_once 'Database.php';
   
   $username = validate_username($_POST["username"]);
   $password = validate_password($_POST['password']);

   // will return false if password doesnt match
   if(verify_password_match($password, $_POST["confirm_password"])) {
       insert_user($username, $password);
   }

} /* end of server request method */

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
            $stmt->bind_param("s", $pUsername);            

            // Set parameters
            $pUsername = filter_input_value(trim($username));            

            // execute the prepared statement
            if($stmt->execute()){     
                $stmt->store_result();               

                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    return $pUsername;
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
        }
    }
}

function insert_user($username, $password) {
     // check for invalid inputs 
     if(empty(get_username_error()) && empty(get_password_error()) && empty(get_confirm_password_error())){  
          $db = New Database();
          // using prepared statement  
          $sql = "INSERT INTO users (username, password) VALUES (?, ?)"; 
          $conn = $db->db_connect();

          if($stmt = $conn->prepare($sql)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("ss", $pUsername, $pPassword); 
              // Set parameters
              $pUsername = $username;
              // hash password with builtin php hash function 
              $pPassword = password_hash($password, PASSWORD_DEFAULT);
              
              if($stmt->execute()){
                  // Redirect to login page
                  header("location: login.php");
              } else{
                  echo "Something went wrong. Please try again later.";
              }
              
          } // end of  prepare statement block

          // Close query
          $stmt->close();

      } // end of check input block
     
      $conn->close();
} //end of insert user function

/* remove all html tags and characters */
function filter_input_value($str) {
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return $str;
 }

?>