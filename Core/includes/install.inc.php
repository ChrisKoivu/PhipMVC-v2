<?php 
    include "db.inc.php";
  
 

      install_db();
 
    function install_db(){
        create_database();

        $sql_users = "
        CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            username varchar(50) DEFAULT NULL,
            password varchar(256) DEFAULT NULL,
            email varchar(128) DEFAULT NULL,
            role_id INT NOT NULL
        )";
        create_table($sql_users);

        $sql_roles = "
        CREATE TABLE IF NOT EXISTS roles (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            role_name varchar(50) DEFAULT NULL
        ) 
        ";
        create_table($sql_roles);
    }
?>