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
 

Class Validate {

  public function validate_int($value){
    try {
      if (! is_int($value))  
        throw new Exception("Value is not an integer!");
      return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
    catch(Exception $e) {
      echo 'Error: ' .$e->getMessage();
    }
  }

  public function validate_float($value){
    try {
      if (! is_float($value))  
         throw new Exception("Value is not a float!");
      return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
    }
    catch(Exception $e) {
      echo 'Error: ' .$e->getMessage();
    }
  }

  public function validate_numeric($value){
    try {
      if (! is_numeric($value))  
        throw new Exception("Value is not numeric!");
      return $value;
    }
    catch(Exception $e) {
      echo 'Error: ' .$e->getMessage();
    }
  }

  public function validate_null($value){
    try {
      if (! is_null($value))  
         throw new Exception("Value is not null!");
      return NULL;
    }
    catch(Exception $e) {
      echo 'Error: ' .$e->getMessage();
    }
  }

  public function validate_string($value){
    try {
      if (! is_string($value))  
        throw new Exception("Value is not a string!");
      return filter_var($value,FILTER_SANITIZE_STRING);
    }
    catch(Exception $e) {
      echo 'Error: ' .$e->getMessage();
      return FALSE;
    }
  }

  public static function validate_string_match($str1, $str2) {
      try {   
          $str1 = filter_var($str1, FILTER_SANITIZE_STRING);
          $str2 = filter_var($str2, FILTER_SANITIZE_STRING);
          if(!is_string($str1)){
             /* convert to string if necessary */
             $str1 = "'" . $str1 . "'";
          }

          if(!is_string($str2)){
             /* convert to string if necessary */
             $str2 = "'" . $str2 . "'";
          }

        
         if (strcmp($str1, $str2)==0){
             return TRUE;
         } else {
             throw new Exception("Entries do not match !!");               
         } 
      }catch (Exception $e) {
           echo $e->getMessage();
           return FALSE;
      } // end of try-catch block 
   }
   
   
  public static function validate_email($email){
   try {
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)) 
        throw new Exception("Email Address: " . $email . "is not valid!");
      return filter_var($email, FILTER_SANITIZE_EMAIL);      
    }
    catch(Exception $e) {
      echo 'Error: ' .$e->getMessage();
    }
  }
  
  /* 
 * This function verifies that the request processed is for a file
 * on this host. It stops redirection to another link on another 
 * website. This is to stop Cross-Site Scripting (XSS)
*/
public static function validate_url($url){
  $url = filter_var($url, FILTER_SANITIZE_URL);

  // Validate url
  if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
     return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
  }
}


  public static function validate_array($value){
    try {
      if (! is_array($value))  
        throw new Exception("Value is not an Array!");
      return self::filter_array($value);
    }
    catch(Exception $e) {
      echo 'Error: ' .$e->getMessage();
    }
  }
  
  
  private static function filter_array($inp_array){
if(is_array($inp_array)) {
  $out = ''; 
  foreach ($inp_array as $val){
   $out .= filter_var($val, FILTER_SANITIZE_STRING).',';
  }
  $out = rtrim(self::out, ',');
  $out_array = explode(',', self::out);
  return $out_array;
} 
  /* not an array */
  return false;
}


}