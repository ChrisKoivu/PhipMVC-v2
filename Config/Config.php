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


/* database settings */
define ('DB_HOST',  'localhost');
define ('DB_NAME',  'phipmvc');
define ('DB_USER',   'root');
define ('DB_PASS',   'zdrnko114');

/* 
  manually provided salt for encryption algorithm.
  should be changed for each application for security
  salt generated from https://api.wordpress.org/secret-key/1.1/salt/
*/
define ('SALT',  'Hpg&&OKyp@glZ6wluJ]0*8+zyG&3Nl~K[;Hycv<-;K%/Y!iQB2*;g}N:;;9-sUI1');

/* 
    This is the settings for the Superuser of the application.
    There is only one superuser/admin for this application, and
    it is defined here. All other users created by the app are
    designated as standard users with limited access.
*/
define('DEFAULT_ADMIN_USERNAME',  'chriskoi');
define('DEFAULT_ADMIN_PASSWORD',  'zdrnko114');
define('DEFAULT_ADMIN_EMAIL',  'admin@admin.com');

/*set the key value that will identify the user access as admin*/
define('ADMIN_ID', 'vs785adMin');

/*set the key value that will identify the user access as a regular user */
define('USER_ID', '456tverf');


/* this is the folder where your installation resides 
  this is for convenience in designating included css 
  and js files see STYLESHEET DIR for example
*/ 
define('DEFAULT_WEBSITE_URL', 'http://localhost/phipmvc');

/* this is a setting for convenience */
define('DEFAULT_HOSTNAME',  'chriskoivu.com');

/* define title for site */
define ('SITE_TITLE', 'PHIP MVC v2');

/* set the default route in the event of a invalid path */
define('DEFAULT_PAGE', '/Home/index');

/* set the path to the stylesheets and javascript files */
define('STYLESHEET_DIR', DEFAULT_WEBSITE_URL . '/css/');
define('STYLESHEET_DIR', DEFAULT_WEBSITE_URL . '/js/');

/* 
  set debug to 1 for development, 0 for live
*/
DEFINE ('DEBUG', 1);

check_config_setup();

function check_config_setup() {
  if(! check_db_settings ()){     
    print 'Please enter your Database credentials in  config.php file in the Config folder<br>';
  }

  if(! check_salt()){
    print 'Please enter your manually created salt in config.php file in the Config folder<br>';
  }

  if(! check_server_settings ()){
    print 'Please enter your Server credentials in  config.php file in the Config folder<br>';
  }

 
}


function check_db_settings () {
   if(DB_USER == NULL ||DB_PASS == NULL){
      return FALSE;
   } else {
      return TRUE;
   }   
}

function check_salt () {
   if(SALT == NULL){
      return FALSE;
   } else {
      return TRUE;
   }   
}

function check_server_settings() {
  if(DEFAULT_ADMIN_PASSWORD == NULL ||DEFAULT_ADMIN_EMAIL == NULL ||DEFAULT_HOSTNAME == NULL){
     return FALSE;
  } else {
    return TRUE;    
  }
}


