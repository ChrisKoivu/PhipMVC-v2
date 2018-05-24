<?PHP
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
  * This class is for the buffer class to convert the string functions
  * inserted in the view files to HTML. We dont want to put raw data
  * into our views, so we are sanitizing the functions and the text 
  * data in the view files and then calling the insert functions 
  * to translate the string values into HTML for the view
  */
 Class Components {
 
    public static function insert_comment_form(){
         HtmlBuilder::start_view_block('div', '',' ' , 'background-color:white;'
                 . 'height:100%; width: 100%; padding: 30px;border-style:'
                 . 'solid;border-width:2px;border-radius:5px;');
         HtmlBuilder::start_form('posts', 'add_post', 'post');
        
         
        
        HtmlBuilder::insert_textarea('comment', 'comment');
        HtmlBuilder::start_view_block('div', '','input-group' , '');
        HtmlBuilder::insert_button("submit", "btn btn-default", "submit","submit");       
        self::insert_glyphicon('glyphicon-share');
        HtmlBuilder::end_view_block('button');    
        HtmlBuilder::end_view_block('div');
        HtmlBuilder::end_view_block('form');
        HtmlBuilder::end_view_block('div');
    }
    
    public static function insert_glyphicon($glyph_name,$text=''){
        print '<span class="glyphicon ' . $glyph_name .'"></span>' . $text;
    }
    
    public static function insert_image($image_name,$img_height='228px', $img_width='304px'){
      print '<img src="' . $image_name . '" ' . '  style="width: ' . $img_width . '; height:' . $img_height. '; ">';
    }
    public static function insert_login_form($controller, $action, $form_method, $form_heading){       
       HtmlBuilder::start_view_block('div', 'main','' , "padding-left: 30px;");       
       HtmlBuilder::insert_html_tag('h2', '', '','' , ucwords($form_heading));
       HtmlBuilder::start_form($controller, $action, $form_method);
       
       HtmlBuilder::insert_form_input('text', 'username', '','position: relative;left:25px; top: 5px;');
       HtmlBuilder::insert_form_input('password', 'password', '','position: relative; left: 25px;top: 5px;');
       
      
        
       HtmlBuilder::insert_html_tag('pgraph');
       HtmlBuilder::insert_html_tag('pgraph');
       HtmlBuilder::insert_html_tag('pgraph');
       /* insert twitter-bootstrap submit button */
       HtmlBuilder::insert_button("submit", "btn btn-primary", "submit","Login"); 
       HtmlBuilder::end_view_block('button');    
       HtmlBuilder::start_view_block('p', '','' , '');
       HtmlBuilder::insert_link('login', '', '', '','Cancel');
       print ' | ';
       HtmlBuilder::insert_link('/users/forgot_password', '', '', '','Forgot password');
       HtmlBuilder::end_view_block('p');    
       /* end of login form */
       HtmlBuilder::end_view_block('form');  
       HtmlBuilder::end_view_block('div');
    }
    
     public static function insert_registration_form($controller, $action, $form_method, $form_heading){
        HtmlBuilder::start_view_block('div', 'main','' , "padding-left: 30px;");  
        HtmlBuilder::insert_html_tag('h2', '', '','' , ucwords($form_heading));
        HtmlBuilder::start_form($controller, $action, $form_method);
         
        HtmlBuilder::insert_form_input('text', 'username', '','position: relative; left: 85px;top: 5px;');
        HtmlBuilder::insert_form_input('text', 'email', '','position: relative; left: 115px;top: 5px;');
        HtmlBuilder::insert_form_input('password', 'password', '','position: relative; left: 85px;top: 5px;');
        HtmlBuilder::insert_form_input('password', 'confirm_password', '','position: relative; left: 25px;top: 5px;');
        
        HtmlBuilder::insert_html_tag('pgraph');
        HtmlBuilder::insert_html_tag('pgraph');
        HtmlBuilder::insert_html_tag('pgraph');
        HtmlBuilder::insert_button("submit", "btn btn-primary", "submit","submit"); 
        HtmlBuilder::end_view_block('button');    
        HtmlBuilder::start_view_block('p', '','' , '');
        HtmlBuilder::insert_link('login', '', '', '','Cancel');
        HtmlBuilder::end_view_block('p');
        /* end of login form */
        HtmlBuilder::end_view_block('form');
        HtmlBuilder::end_view_block('div');         
     }
     
     public static function insert_table($array, $id, $class, $style, $table_heading=''){      
        $fields = array_keys($array[1]);
        HtmlBuilder::insert_html_tag('h3', '', '','' , ucwords($table_heading)); 
        /* start table */
         HtmlBuilder::start_view_block('div', '',' ' , 'background-color:white; '
                 . 'height:250px; width: 100%; padding-left: 30px;border-style:'
                 . 'solid;border-width:2px;border-radius:5px;');  
        HtmlBuilder::start_view_block('table', $id, $class, $style);     
        /* insert header row */
        HtmlBuilder::start_view_block('tr', '', '', '');   
        /* add column names to table */ 
        for($x=1; $x < sizeof($fields); $x++)       
        {          
          HtmlBuilder::insert_html_tag('th', '', '','' , ucwords($fields[$x]));           
        }
        HtmlBuilder::end_view_block('tr');
        /* start data rows */
        foreach ($array as $value){
          HtmlBuilder::start_view_block('tr', '', '', '');         
           
           /* insert the associative key names as id="" tag */
           for($x=1; $x < sizeof($fields); $x++)       
           {
             HtmlBuilder::insert_html_tag('td', $fields[$x], '','' , $value[$fields[$x]]);   
           }           
           HtmlBuilder::end_view_block('tr');      
           }    
           HtmlBuilder::end_view_block('table'); 
           HtmlBuilder::end_view_block('div'); 
     }   // end insert table
    
      public static function insert_panel($headingName, $array){    
        /*get associative key names from array */
        $fields = array_keys($array[1]);  

        HtmlBuilder::insert_html_tag('h2', '', '','' , ucwords($headingName));
        HtmlBuilder::start_view_block('div', '','panel panel-default' , 'border-radius:5px;border-style:solid;border-width:2px; height: 100%;');
        HtmlBuilder::start_view_block('div', '','panel-heading' , '');       
        HtmlBuilder::insert_link('#', '', 'pull-right', '', 'View All');
        HtmlBuilder::end_view_block('a'); 
        HtmlBuilder::end_view_block('div'); 
        HtmlBuilder::start_view_block('div', '','panel-body' , '');
        HtmlBuilder::start_view_block('ul', '','list-group' , '');

   
          foreach ($array as $value){
            HtmlBuilder::start_view_block('li', '','list-group-item' , '');
               
             /*using span tags as formatting hooks for styling */
            /* insert the associative key names as id="" tag */
             for($x=1; $x < sizeof($fields); $x++)   
             {
                HtmlBuilder::insert_html_tag('span',  $fields[$x], '','' , $value[$fields[$x]]);
                HtmlBuilder::insert_html_tag('br', '', '','' , '');                
             }           
             HtmlBuilder::end_view_block('li');          
          }  
         HtmlBuilder::end_view_block('ul');          
         HtmlBuilder::end_view_block('div');  
         HtmlBuilder::end_view_block('div'); 
    }//end insert posts panel function
    
    public static function insert_posts_panel($headingName, $array){    
       
        HtmlBuilder::insert_html_tag('h2', '', '','' , ucwords($headingName));
        HtmlBuilder::start_view_block('div', '','panel panel-default' , 'border-radius:5px;border-style:solid;border-width:2px; height: 100%;');
        HtmlBuilder::start_view_block('div', '','panel-heading' , '');       
        HtmlBuilder::insert_link('#', '', 'pull-right', '', 'View All');
        HtmlBuilder::end_view_block('a'); 
        HtmlBuilder::end_view_block('div'); 
        HtmlBuilder::start_view_block('div', '','panel-body' , '');
        HtmlBuilder::start_view_block('ul', '','list-group' , '');

   
          foreach ($array as $value){
            HtmlBuilder::start_view_block('li', '','list-group-item' , '');
            HtmlBuilder::insert_html_tag('span',  'username', '','font-weight:bold;' ,  $value['title']);
            HtmlBuilder::insert_html_tag('span',  'created', '','float: right;' ,  'Posted on ' . $value['created']);
            HtmlBuilder::insert_html_tag('br', '', '','' , ''); 
            HtmlBuilder::insert_html_tag('span',  'message', '','' , $value['body']);
            HtmlBuilder::end_view_block('li');          
          }  
         HtmlBuilder::end_view_block('ul');          
         HtmlBuilder::end_view_block('div');  
         HtmlBuilder::end_view_block('div'); 
    }//end insert posts panel function
   
    public static function insert_carousel_block(){
        $img_path = DEFAULT_WEBSITE_URL . DS . 'Views' . DS;
        $top_image = '..//Views//Images/top.jpg';
        
        $pic_array = array(
            'picture 1'  => '..//Views//Images/pic1.jpg', 
            'picture 2'  => '..//Views//Images/pic2.jpg',  
            'picture 3'  => '..//Views//Images/pic3.jpg',  
            'picture 4'  => '..//Views//Images/pic4.jpg'
        );
        self::generate_carousel_block($top_image, $pic_array);
    }
    
    public static function generate_carousel_block($top_image, $picture_array){
        print '<div id = "myCarousel" class = "carousel slide" data-ride = "carousel">';
        print '<ol class = "carousel-indicators">';
        print '<li data-target = "#myCarousel" data-slide-to = "1"></li>';
        print '<li data-target = "#myCarousel" data-slide-to = "2"></li>';
        print '<li data-target = "#myCarousel" data-slide-to = "3"></li>';
        print '<li data-target = "#myCarousel" data-slide-to = "4"></li>';
        print '<li data-target = "#myCarousel" data-slide-to = "5"></li>';
        print '</ol>';
        print '<div class="carousel-inner" role="listbox">';
        
        print '<div class = "item active">';
       HtmlBuilder::insert_image($top_image,'top image' , '');
        print '</div>';
        foreach ($picture_array as $key=>$val){
          print '<div class = "item">';
          HtmlBuilder::insert_image($val, $key,'');  
          print '</div>';
        }
        HtmlBuilder::end_view_block('div');
        self::add_carousel_controls();        
        print '</div>';
    }
    
    private function add_carousel_controls() {      
        print '<a  class = "left carousel-control" href="#myCarousel" role = "button" data-slide="prev">';
        print '<span class = "glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
        print '<span class = "sr-only">Previous</span>';   
        print '</a>';
        
        print '<a  class = "right carousel-control" href="#myCarousel" role = "button" data-slide="next">';
        print '<span class = "glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
        print '<span class = "sr-only">Next</span>';   
        print '</a>';         
    }
    
    public static function insert_fader_block(){
        $img_path = DEFAULT_WEBSITE_URL . DS . 'Views' . DS;
        $top_image = '..//Views//Images/top.jpg';
        
        $pic_array = array(
            'picture 1'  => '..//Views//Images/pic1.jpg', 
            'picture 2'  => '..//Views//Images/pic2.jpg',  
            'picture 3'  => '..//Views//Images/pic3.jpg',  
            'picture 4'  => '..//Views//Images/pic4.jpg'
        );
        self::generate_fader_block($top_image, $pic_array);
    }
    
    public static function generate_fader_block($top_image, $picture_array){
        HtmlBuilder::start_view_block('div', 'fader','','');
        HtmlBuilder::insert_image($top_image,'top image' , 'active');      
        foreach ($picture_array as $key=>$val){
          HtmlBuilder::insert_image($val, $key,'');  
        }
        HtmlBuilder::end_view_block('div');
    }
 }
 
 
 ?>