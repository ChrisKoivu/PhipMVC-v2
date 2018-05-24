
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
 
$controller = null;
$action = null;
$query = null;
$key = null;
ini_set ('display_errors', DEBUG);
require_once HOME . DS .'Core'.DS. 'includes' . DS . 'install.inc.php';

if (isset($_GET['url']))
{
    $params = array();
    $params = explode("/", filter_var($_GET['url'],FILTER_SANITIZE_URL));
 
    // 1st parameter from the query string is the controller name
    $controller = ucwords($params[0]);
     
    if (isset($params[1]) && !empty($params[1]))
    {
        // 2nd parameter from the query string is the controller action to take
        $action = $params[1];
    }
     
    if (isset($params[2]) && !empty($params[2]))
    {
        // 3rd parameter from the query string is the query to perform, in this case,  we are using this query to verify
        // a key enclosed in an email to verify email address
        $query = $params[2];
    }
    
    if (isset($params[3]) && !empty($params[3]))
    {
        // 4th parameter from the query string is the key, a hash enclosed in the body of the email
        $key = '&' . $params[3];       
    }
}

$modelName = $controller;
$controller .= 'Controller';
$query .= $key;
      
try{
    if (file_exists(HOME . '/Controllers/' . $controller.'.php' )){
        $load = new $controller($modelName, $action); 
        
        if (method_exists($load, $action))
        {     
            /* load the controller and its action. if query key is used, 
            pass it with the values */
            $load->$action($query);          
        }
     }else{
           /* invalid or null route go to the default page */
           Session::redirect(DEFAULT_PAGE);
     }
} catch(Exception $e){
     echo 'Error: ' .$e->getMessage();
}

