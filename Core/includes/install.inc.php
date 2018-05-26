<?php 
    require_once "Database.php";
  
 

      install_db();
      if(!admin_exists()){
        create_admin_user();
      }
      insert_roles();
    function install_db(){
        $db = New Database();

        $sql_users = "
        CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            username varchar(128) NOT NULL,
            pw TEXT NOT NULL,
            email varchar(128) DEFAULT NULL,
            role_id varchar(128) NOT NULL
        )";
        $db->create_table($sql_users);

        $sql_role = "
        CREATE TABLE IF NOT EXISTS role (
            id varchar(128) NOT NULL PRIMARY KEY,
            role_name varchar(50) NOT NULL
        ) 
        ";
        $db->create_table($sql_role);
    }

    function create_admin_user(){
        $db = New Database();
        $conn = $db->db_connect();
        
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, pw, email, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $pw, $email, $role_id);
       
        // set parameters and execute
        $pw = password_hash(DEFAULT_ADMIN_PASSWORD, PASSWORD_DEFAULT);
        $username = DEFAULT_ADMIN_USERNAME;
        $email = DEFAULT_ADMIN_EMAIL;
        $role_id = ADMIN_ID;

        $stmt->execute();
        unset($db);
        $stmt->close();
        $conn->close();
    }

    function insert_roles(){
        $db = New Database();
        $conn = $db->db_connect();
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO role(id, role_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $id, $role_name);
       
        // set parameters and execute
        $id = ADMIN_ID;
        $role_name='admin';
        $stmt->execute();

        $id = USER_ID;
        $role_name='user';
        $stmt->execute();


        unset($db);
        $stmt->close();
        $conn->close();

    }

    function admin_exists(){
        $db = New Database();
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";        
        $conn = $db->db_connect();

        if($stmt = $conn->prepare($sql)){

            // Bind variables
            $stmt->bind_param("s", $pUsername);            

            // Set parameters
            $pUsername = $db->filter_input_value(trim( DEFAULT_ADMIN_USERNAME));            

            // execute the prepared statement
            if($stmt->execute()){     
                $stmt->store_result();               
                $conn->close();
                if($stmt->num_rows < 1){
                    return false;
                } 
                return true;
            }
        }
    }
?>