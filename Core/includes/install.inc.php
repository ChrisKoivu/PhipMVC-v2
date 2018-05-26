<?php 
    require_once "Database.php";
  
 

      install_db();
      create_admin_user();
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
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $pw = password_hash(DEFAULT_ADMIN_PASSWORD, PASSWORD_DEFAULT);
        $username = DEFAULT_ADMIN_USERNAME;
        $email = DEFAULT_ADMIN_EMAIL;
        $role_id = ADMIN_ID;


        $sql = "INSERT INTO users (username, pw, email, role_id)
        VALUES ('fred','$2y$10$2YhalZ59ndrYjAQSMFxbD./m7DoUtHKk.03f3SnfdmOrbO29JmbCS','mail@mail.com' , 'ahdgf87')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();

    }

    function populate_role_table(){

    }

?>