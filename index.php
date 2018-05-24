<?php

/* ///////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright (c) June 28, 2015. Christopher M Koivu.


Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, or distribute copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED 
TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL 
THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
////////////////////////////////////////////////////////////////////////////////////////////////////////// */

/*

   #########   ENABLE URL REWRITING  ##########


   This is how this framework works. The .htaccess file in the
   root folder sends all route requests to this index.php file. 
   The URL is rewritten in the address bar in the browser.
   The Core.php file uses the get method to parse the url for
   the controller class, the class method, any query key and
   value passed to the url. The autoloader in this file loads
   the Controller (class) called in through the url so that
   they will not need to be included manually. Every file in
   this framework is for all intents and purposes included
   into this php file which handles all the magic. The view
   files are written to the output buffer which is then
   printed out to present the view. In the recommended
   configuration, I have set the default page to a 
   subfolder on the root, and placed the .htaccess-root file
   on the root. I have set the default directory to
   'phipmvc' in this file and the .htaccess-root file. 
   rename the .htacess-root file to .htaccess. rename
   the .htaccess-subfolder file to .htaccess and leave
   in the subfolder.
   the .htacess file in the root and the DEFAULT_PAGE constant 
   in this file would need to be changed to a different subfolder
   if desired



*/


/* define environmental constants */ 
define ('DS', DIRECTORY_SEPARATOR);
define ('HOME', dirname(__FILE__));

 
/* define our default configuration. */
require_once HOME . DS . 'Config'.  DS . 'Config.php';

/* this file processes the mvc requests as they come in */
require_once HOME . DS .'Core' . DS . 'Core.php';



 
function __autoload($class)
{
    if (file_exists(HOME . DS . 'Core' . DS . $class . '.php'))
    {
        require_once HOME . DS . 'Core' . DS . $class . '.php';
    }
    elseif (file_exists(HOME . DS . 'Libraries' . DS . $class . '.php'))
    {
        require_once HOME . DS . 'Libraries' . DS . $class . '.php';
    }
    else if (file_exists(HOME . DS . 'Models' . DS . $class . '.php'))
    {
        require_once HOME . DS . 'Models' . DS . $class  . '.php';
    }
    else if (file_exists(HOME . DS . 'Controllers' . DS . $class . '.php'))
    {
        require_once HOME . DS . 'Controllers' . DS . $class . '.php';
    }
    else if (file_exists(HOME . DS . 'Views' . DS . 'Layout' . DS . $class . '.php'))
    {
        require_once HOME . DS . 'Views' . DS . 'Layout' . DS . $class . '.php';
    }
}

?>
