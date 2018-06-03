

    <?php

    // Define variables and initialize with empty values
    $session = NULL;
    $username = $password = "";
    $username_err = $password_err = "";
    // Processing form data when form is submitted

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = validate_username($_POST["username"]);
        $password = validate_password($_POST['password']);
        if (validate_login($username, $password)){
             /* Password is correct, so redirect to user page */
            global $session;
            $session->redirect('/home/index'); 
        }
        
        

        
    } /* end of server request method method lock */



    function validate_username($username) {
        global $username_err;
       // Check if username is empty

       if(empty(trim($_POST["username"]))){
         $username_err = 'Please enter username.';
       } else{
         return trim($username);
       }

     }

        
    function get_username_error(){
        global $username_err;
        return $username_err;
    }


    function validate_password($password) {
       global $password_err;
       // Check if password is empty
       if(empty(trim($password))){
         $password_err = 'Please enter your password.';
       } else{
         return trim($password);
       }
    }
    
    function get_password_error(){
        global $password_err;
        return $password_err;
    }

    
    function validate_login($username, $password){
    global $password_err, $username_err, $session;
    require_once 'Database.php';
    $db = New Database();
    $conn = $db->db_connect();
        if(empty($username_err) && empty($password_err)){
            // prepare and bind
            $stmt = $conn->prepare("SELECT username, pw, role_id FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
                if($stmt->execute()){
                    $stmt->store_result();                  
                    // if username exists, verify password
                    if($stmt->num_rows == 1){                 
                        // Bind result variables
                        $stmt->bind_result($username, $hashed_password, $role_id);
                        if($stmt->fetch()){
                            if(password_verify($password, $hashed_password)){ 
                                $session = New Session();
                                $session->set_session_value('username', $username);
                                $session->set_session_value('role_id', $role_id);
                                return true;   
                            // header("location: welcome.php");
                            } else{
                                // Display an error message if password is not valid
                                $password_err = 'The password you entered was not valid.';
                            }
                        }
                    } else{
                        // Display an error message if username doesn't exist
                        $username_err = 'No account found with that username.';
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            
            $stmt->close();
            // Close connection
            $conn->close();    
        }/* end of entry validation block */
    }/* end of validate login function */
    
?>