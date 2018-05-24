
 	
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




  include($this->header);   
 
    //start_view_block($tagName, $id=NULL, $class=NULL, $style=NULL)
    HtmlBuilder::insert_html_tag('h3', '', '', '',  $this->get('forgot_pw_header'));
    HtmlBuilder::start_form('users', 'forgot_password', 'post');
    
    if ($this->get('show_email_textbox'))
      HtmlBuilder::insert_form_input('text', 'email', '','');
    HtmlBuilder::insert_html_tag('pgraph');
       /* insert twitter-bootstrap submit button */
       HtmlBuilder::insert_button("submit", "btn btn-primary", "submit","Submit");   
       HtmlBuilder::start_view_block('p', '','' , '');
       HtmlBuilder::insert_link('', '', '', '','Cancel');
       HtmlBuilder::end_view_block('p');    
       /* end of login form */
    HtmlBuilder::end_view_block('form');
    print $this->get('error');
     include($this->footer); 
?>