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
 

class View
{
    Protected $file;   
    Private $data = array();
    Protected $header;
    Protected $footer;
   
    
    public function __construct($file )
    {
        $this->file = $file;            
    }
     
     public function clear_val($key) {
       unset($this->data[$key]);
    }
    
    public function set_header($header_name='header.php'){
      $this->header = HOME . DS . 'templates' . DS . $header_name;
    }
    
    public function set_footer($footer_name='footer.php'){
      $this->footer = HOME . DS . 'templates' . DS . $footer_name;
    }
    /**
     * this is the setter. sets the value to be stored in the array
     * @param type $key array key for the value
     * @param type $value value to be set
     */
    public function set($key, $value)
    {
       $this->data[$key] = $value;     
    }
     
   
    /**
     * this is a getter, to get value . if value is an array
     * within the data array, we will return the array's key
     * @param type $key key in the array where data is stored
     * @return value that is received from the array
     */
    public function get($key)
    {   
       if (isset($this->data[$key]))           
         return $this->data[$key];      
    } 
    
    /**
     * refreshes page every 10 seconds
     */
    Public function refresh (){
      $page = $_SERVER['PHP_SELF'];
      $sec = "10";
      header("Refresh: $sec; url=$page");  
    }

    
    /**
     * renders view into a webpage
     * @throws Exception if include file (header or footer) are not found
     */
    public function render()
    {
       if (!file_exists($this->file))
        {
            throw new Exception("View file: " . $this->file . " doesn't exist.");
        }
        //output to buffer for rendering
        extract($this->data);
        ob_start();
        include($this->file);       
        $output = ob_get_contents();    
        ob_end_clean();        
        echo $output;               
    }
    
     
}
