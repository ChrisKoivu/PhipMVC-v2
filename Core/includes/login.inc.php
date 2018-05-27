

    <?php

   

    // Define variables and initialize with empty values

    $username = $password = "";

    $username_err = $password_err = "";

     

    // Processing form data when form is submitted

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = validate_username($_POST["username"]);
        $password = validate_password($_POST['password']);
        validate_login($username, $password);

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
            $password = trim($password);
           }
        }
        
        function get_password_error(){
            global $password_err;
            return $password_err;
        }

        function validate_login($username, $password){
        global $password_err, $username_err;
        $conn = db_connect();
        if(empty($username_err) && empty($password_err)){
            $sql = "SELECT username, password FROM users WHERE username = ?";
            

            if($stmt = $conn->prepare($sql)){

                // Bind variables 
                $stmt->bind_param("s", $pUsername);               

                $pUsername = $username;               

                // execute the prepared statement

                if($stmt->execute()){
                    $stmt->store_result();                  

                    // if username exists, verify password

                    if($stmt->num_rows == 1){                 

                        // Bind result variables
                        $stmt->bind_result($username, $hashed_password);

                        if($stmt->fetch()){
                            if(password_verify($password, $hashed_password)){
                                /* Password is correct, so start a new session and
                                save the username to the session */
                                session_start();
                                $_SESSION['username'] = $username;    
                                header("location: welcome.php");
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

            }
            $stmt->close();

           }
        }
        

        // Close connection
        $mysqli->close();

    }

    function logout(){
       // Initialize the session
      session_start();
 

      // Unset all of the session variables
      $_SESSION = array();

 

      // Destroy the session.
      session_destroy();

 

     // Redirect to login page
     header("location: login.php");

     exit;
  }

?>