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
 Class HtmlBuilder {
 
        protected static $tags = array(
		'meta' => '<meta%s>',
		'metalink' => '<link href="%s"%s/>',
		'link' => '<a href="%s"%s>%s</a>',
		'mailto' => '<a href="mailto:%s" %s>%s</a>',
		'form' => '<form action=%s %s>',
		'input' => '<input name="%s"%s/>',
                'textbox' => '<input type="text" name=%s %s />',   
                'tb-password' => '<input type="password" name=%s %s />',
		'textarea' => '<textarea name="%s"%s>%s</textarea>',
		'hidden' => '<input type="hidden" name="%s"%s/>',
		'checkbox' => '<input type="checkbox" name="%s" %s/>',
		'radio' => '<input type="radio" name="%s" id="%s"%s />%s',
		'select' => '<select name="%s"%s>',		
		'closetag' => '</%s>',
		'optiongroup' => '<optgroup label="%s"%s>',
		'password' => '<input type="password" name="%s" %s/>',
		'file' => '<input type="file" name="%s" %s/>',
		'submit' => '<input %s/>',
		'submitimage' => '<input type="image" src="%s" %s/>',
		'button' => '<button %s>%s</button>',
		'image' => '<img src="%s" %s/>',
		'th' => '<th %s>%s</th>',	
                'title' => '<title%s>%s</title>',
                'label' => '<label for=%s>%s</label>',
		'td' => '<td %s>%s</td> ',
                'a' => '<a %s> %s </a>',
                'h5'=> '<h5 %s> %s </h5>',
                'h4'=> '<h4 %s> %s </h4>',
                'h3'=> '<h3 %s> %s </h3>',
                'h2'=> '<h2 %s> %s </h2>',
                'h1'=> '<h1 %s> %s </h1>',                
		'tr' => '<tr %s> ',                
                'div' => '<div %s> %s </div>',
		'pgraph' => '<p%s>%s</p>',         
		'label' => '<label for="%s">%s</label>',
		'css' => '<link rel="%s" type="text/css" href="%s" %s/>',
		'style' => '<style type="text/css"%s>%s</style>',
		'charset' => '<meta http-equiv="Content-Type" content="text/html; charset=%s" />',
		'ul' => '<ul%s>%s</ul>',
		'ol' => '<ol%s>%s</ol>',
		'li' => '<li%s>%s</li>',                              
                'span' => '<span %s>%s</span>',
                'br' => '<br>',
		'javascript' => '<script%s>%s</script>',		
		'js' => '<script type="text/javascript" src="%s"%s></script>'		
	);

 
    
       /**
     * creates html tag(s) for desired element(s). this gives us
     * the ability to sanitize entries
     * @param type $tag name of html tag to insert, ex. entering 'div'. generates id = <div>
     * @param type $id Id name of element, ex. entering 'sidebar'. generates id = "sidebar"
     * @param type $class css class identifier, entering 'sidebar'. generates class = "sidebar"
     * @param type $style css style identifier, entering 'font-weight:bold;'. generates style = "font-        
       weight:bold;"
     * @param type $text text you wish to appear between the tags    
     */
   public static function insert_html_tag($tag, $id=NULL, $class=NULL, $style=NULL, $text=''){
       $options = self::options($id, $class, $style);
       $newtext = wordwrap($text, 45, "<br />\n");
       $tag = filter_var($tag, FILTER_SANITIZE_STRING);
       $text = filter_var($newtext, FILTER_SANITIZE_STRING);
       printf(self::$tags[$tag], $options, $text);
       print PHP_EOL;
  }    
  
  public static function insert_error_panel(){
       $error= Session::get_error_output();
       if(!empty($error)){
           print '<table><tr><td style = "padding-left: 15px; color: red;">' . 
           $error . '</td></tr></table>' . PHP_EOL;
       }      
  }
  
  public static function insert_image($src, $alt, $class) {
    print '<img src="' . $src . '" alt ="'.$alt.'" class="' . $class . '"/>';      
    print PHP_EOL;
  }
  
  public static function insert_jscript($javascript_name){
      $js = filter_var($javascript_name, FILTER_SANITIZE_STRING);     
      print '<script src="/Views/js/'. $javascript_name . '"></script>';      
      print PHP_EOL;
  }
  
  public static function insert_meta_tag($field_value_array){
      //<meta http-equiv=&#34;content-type&#34;  content=&#34;text/html; charset=UTF-8&#34; >
      $out ='';
      foreach ($field_value_array as $key => $val) {
         $key = filter_var($key, FILTER_SANITIZE_STRING);
         $val = filter_var($val, FILTER_SANITIZE_STRING); 
         if($val !=""){
           $out .= ' ' . $key .  '="' . $val . '" ';           
         }
       }
       print '<meta' .   $out . '>';
       print PHP_EOL;
  }
  
 
  public static function insert_button($type, $class, $default_name='',$button_caption=''){    
       $_type = filter_var($type, FILTER_SANITIZE_STRING);
       $_class = filter_var($class, FILTER_SANITIZE_STRING);
       $_default_name = filter_var($default_name, FILTER_SANITIZE_STRING);
       $_button_caption = filter_var($button_caption, FILTER_SANITIZE_STRING);            
       print '<button type="' . lcfirst($_type) . '" class="' .$_class.'" name="' 
               . $_default_name . '">' . $_button_caption . 
               PHP_EOL;
     
  } // end of insert button method
   /**
     * creates html tag(s) for html link. this gives us
     * the ability to sanitize entries. The links are limited to
     * the paths of our app.     
     * @param type $id Id name of element, ex. entering 'sidebar'. generates id = "sidebar"
     * @param type $class css class identifier, entering 'sidebar'. generates class = "sidebar"
     * @param type $style css style identifier, entering 'font-weight:bold;'. generates style = "font-   
       weight:bold;"
     * @param type $text text you wish to appear between the tags    
*/
   public static function insert_link($url, $id=NULL, $class=NULL, $style=NULL, $text=''){
       $elem = '<a href="' . $url . '" %s>%s';
       $newtext = wordwrap($text, 45, "<br />\n");
       $options = self::options($id, $class, $style);      
       printf($elem, $options, $newtext);    
       print PHP_EOL;
  }    
  
  public static function insert_css($css_name){
      $css = filter_var($css_name, FILTER_SANITIZE_STRING);
      print '<link href="/Views/css/' . $css . '" rel="stylesheet">';
      print PHP_EOL;
  }
  /**
     * creates html tag(s) for desired element(s). this gives us
     * the ability to sanitize entries    
     * @param type $id Id name of element, ex. entering 'sidebar'. generates id = "sidebar"
     * @param type $class css class identifier, entering 'sidebar'. generates class = "sidebar"
     * @param type $style css style identifier, entering 'font-weight:bold;'. generates style = "font-         

       weight:bold;"     
 */
  private function options($id=NULL, $class=NULL, $style=NULL) {  
  $out ='';
  $options =  Array (
     'id'  => $id,
     'class' => $class,
     'style' => $style
   );
   

   $filters = array
  (
  "id" => array
    (
    "filter"=>FILTER_SANITIZE_STRING
    ),
   "class" => array
    (
    "filter"=>FILTER_SANITIZE_STRING
    ),
   "style" => array
    (
    "filter"=>FILTER_SANITIZE_STRING
    )
   );

   $filtered_vals = filter_var_array($options, $filters);
   foreach ($filtered_vals as $key => $val) {
       if($val !=""){
         $out .= $key .  '="' . $val . '" ';
       }
   }
   return $out;
}
  public static function start_view_block($tag, $id=NULL, $class=NULL, $style=NULL){
       $tag = filter_var($tag, FILTER_SANITIZE_STRING);
       $element = '<' . $tag . ' %s>';
       $options = self::options($id, $class, $style);
       printf($element, $options);
       /* send newline */
       print PHP_EOL;
  }    
  
   public static function end_view_block($tag){
       $tag = filter_var($tag, FILTER_SANITIZE_STRING);
       print '</' . $tag. '>'. PHP_EOL;
  }    
  
    public static function insert_textarea($name = NULL, $id=NULL){
        print '<textarea name ="' . $name . '" rows="10" cols = "100" id="' 
                  . $id . '" style="margin-left: auto; margin-right: auto; " >';         
        print '</textarea>'. PHP_EOL;
    }
    
   /**
     * formats the inputs to forms. for any input errors, a column is 
     * added with special formatting to display the error adjacent to
     * the input with the incorrect input
     * @param type $type input type, ie, text.
     * @param type $field_name the name of the column input, ie, username
     * @param type $default_value the default value when form id displayed
     */
    public static function insert_form_input($type, $field_name, $default_value='', $style=''){    
       $tag = filter_var($field_name, FILTER_SANITIZE_STRING);
       $text = filter_var($default_value, FILTER_SANITIZE_STRING);
       $_type = filter_var($type, FILTER_SANITIZE_STRING);
       print '<div class = "form-group"><label for="' . lcfirst($tag) . '">' . ucwords($tag) . ':</label>';
       print '<input style="' . $style . '" type="' . lcfirst($_type) . '"  name="' . $tag . '" '
          . 'value="' . $text . '" id="' . $tag . '"/>';      
       print '</div>' . PHP_EOL;        
    } // end of insert form input method
    
  
  public static function start_form($controller, $action, $method){
      $_controller = filter_var($controller, FILTER_SANITIZE_STRING);
      $_action = filter_var($action, FILTER_SANITIZE_STRING);
      $_method = filter_var($method, FILTER_SANITIZE_STRING);
      $form_action ='/' . $_controller . '/' . $_action;
      print '<form action="' . $form_action. '" method="' . $_method . '">' . PHP_EOL;
  }
  }    
        
 

  




 
 




 

 