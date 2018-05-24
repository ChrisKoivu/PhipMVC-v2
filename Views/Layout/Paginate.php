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
 
 /**
 *  
 */
  
 Class Paginate {
     public static function paginate($items_per_page, $input_array) {
   $array = array_chunk($input_array, $items_per_page);
   
   print '<form action="action_page.php">';
   foreach($array as $key) {
      $page_number = $key + 1;
      print '<input type="submit" class="link_input" name="page number" value="Page ' . 
      $page_number  . '"  /> ' ;     
      self::print_entries($key, $input_array);
    }
    print'</form>';
}


private static function print_entries($page_number, $array) {
   foreach($array[$page_number] as $value) {
       print $value;
   }
}
 
 
 
 
 
 
 
 
 
 
 
 
 }
 
 ?>