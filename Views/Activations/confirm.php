
   
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
        HtmlBuilder::start_view_block('div', '', 'jumbotron','');
        HtmlBuilder::insert_html_tag('h2', '', '', '', $this->get('act_heading'));
        HtmlBuilder::insert_html_tag('pgraph', '', '', '', $this->get('output'));
        HtmlBuilder::start_view_block('div', '', 'jumbotron','');
        HtmlBuilder::insert_link($this->get('button_link'),'', 'btn btn-info btn-lg', '', '');
        Components::insert_glyphicon($this->get('glyph_name'), ' '.$this->get('button_text'));
        HtmlBuilder::end_view_block('a');
        HtmlBuilder::end_view_block('div');   
        include($this->footer); 
?>  
       