
<html lang="en">
   
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
 
  HtmlBuilder::start_view_block('head', '', '', '');   
   $this->insert_meta_tag(array('http-equiv'=>"content-type",
                          'content'=> "text/html; charset=UTF-8"));
   $this->insert_meta_tag(array('charset'=>"utf-8"));
   $this->insert_meta_tag(array('name'=>"generator",
                                'content'=>"Bootply"));
   $this->insert_meta_tag(array('name'=>"viewport",
                                'content'=>"width=device-width, initial-scale=1, "
                                . "maximum-scale=1"));   
   $this->insert_jscript("jquery-1.11.3.min.js");
   $this->insert_jscript("bootstrap.min.js"); 
   //$this->insert_jscript("fader.js");   
   $this->insert_css("bootstrap.min.css");
   $this->insert_css("styles.css");
   $this->insert_css("carousel.css");
?>           
 
 <?php 
 
       HtmlBuilder::insert_html_tag('title', '','' ,'' , DEFAULT_HOSTNAME);
       Navbar::init();
       Navbar::insert_navbar(DEFAULT_HOSTNAME,'#');
       HtmlBuilder::end_view_block('head');
       HtmlBuilder::start_view_block('body', '', '', '');
       Components::insert_carousel_block();
       HtmlBuilder::start_view_block('div', '', 'container', '');

       
      
       
 ?>
       