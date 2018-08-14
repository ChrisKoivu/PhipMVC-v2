# README #


                  CONTROLLER   <---  User
                 /          \     
               MODEL        VIEW              


* Quick summary: 
This project is a PHP MVC framework that has twitter bootstrap integrated into the views. The design includes hashing and encryption algorithms for security, as well as URL rewriting to hide the directory structure. For the Models, I am using PDO database drivers and prepared statements to guard against SQL injection attacks. I also am integrating JSON, Ajax, CSV, and PDF creation utilities.

* Version # 2



### How do I get set up? ###
    1. Setup
        * Copy the items in your 'place-in-root-folder'
        folder to your server's root directory.
        * Rename .htaccess - root to .htaccess
        * Rename index - root.php to index.php
        * all other project files remain in 'phipmvc' 
        folder.
        
    2. Configuration
        * enable url rewriting for your server software. For Apache,
        visit: http://httpd.apache.org/docs/2.0/misc/rewriteguide.html
        
    3. Database configuration
       * MySql is the default database. Set your database settings in the
       /Config/config.php file.
       
    4. System configuration
       * setup your passwords, your default settings in the /Config/config.php file.
       
    5. Route configuration
       * set your default webpage settings in the index.php file in the root folder. 
       this determines what page is the default page to launch when the http 
       address is entered in the address bar





