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
 


/*
 * This class is used to encrypt and decrypt user data 
 *  
 */


class Encryption {    
   
   
   public static function init(){
      /*   key should be changed for each application  */
     define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
   
   }       

   public static function encrypt($val, $key){
       $encrypt = serialize($encrypt);
       $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
       $key = pack('H*', $key);
       $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
       $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
       $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
       return $encoded;
   }

   public static function decrypt($val, $key){
     $decrypt = explode('|', $decrypt.'|');
     $decoded = base64_decode($decrypt[0]);
     $iv = base64_decode($decrypt[1]);
     if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ 
        return FALSE; 
     }
     $key = pack('H*', $key);
     $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
     $mac = substr($decrypted, -64);
     $decrypted = substr($decrypted, 0, -64);
     $calc_mac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
     if($calc_mac!==$mac){ 
       return FALSE; 
     }
     $decrypted = unserialize($decrypted);
     return $decrypted;
   }
   
   public static function generate_encryption_key()
    {
       return (md5(uniqid(rand(), true)) . md5(uniqid(rand(), true)));    
    }
    
} // end of class 

?>