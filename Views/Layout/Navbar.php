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
 
 /**
 * This class is for instantiating the navbar for our views
 */
  
 Class Navbar {
    private static $menu_array;
    private static $border;
    private static $navbar_color;
    
    public static function init() {
       /* color of the navbar in the view */
       self::$navbar_color = 'background-color: #efefef;'; 
       /*options are 'solid' or 'none'*/
       self::$border = 'border-style: none;';
       
       self::$menu_array = array(      
       'home'=>array(       
               'class'=>'active',                     
               'link'=>'#',                      
               'dropdown_items' => NULL                     
               ),
       'page_1'=>array(
               'class'=>'dropdown',
               'link'=>'#',
               'dropdown_items'=>array(
                   'Page_1-1'=>'#', // <- the # is for url 
                   'Page_1-2'=>'#',
                   'Page_1-3'=>'#'
                  )
                ),
       'page_2'=>array(
               'class'=>NULL,
               'link'=>'#', 
               'dropdown_items' => NULL
                ),
       'page_3'=>array(
               'class'=>NULL,
               'link'=>'#', 
               'dropdown_items' => NULL
                )
       
           );
    
    } // end init function
 
    
    public static function insert_navbar($website_name, $website_url){
     print '<nav class="navbar navbar-inverse" style="' . self::$border .
       self::$navbar_color . '">' . PHP_EOL;
     print '<div class="container-fluid">' . PHP_EOL;
     print '<div class="navbar-header">' . PHP_EOL;
     print '<button type="button" class="navbar-toggle" data-toggle="collapse" 
     data-target="#myNavbar">';
     print '<span class="icon-bar"></span><span class="icon-bar"></span>
     <span class="icon-bar"></span> </button>';
     print '<a class="navbar-brand" href="' . $website_url . '">' . 
             $website_name . '</a>' . PHP_EOL;
     print '</div>  <div class="collapse navbar-collapse" id="myNavbar"> '
     . '<ul class="nav navbar-nav">' . PHP_EOL;  
     
     print '<ul class="nav navbar-nav navbar-right">';
     self::add_glyph_link('glyphicon-user', '/registrations/register','Sign Up');
     self::add_glyph_link('glyphicon-log-in', '/users/index','Login');
     self::add_glyph_link('glyphicon-log-out', '/Users/logout','Logout');
     print '</ul>';
     
     /* this line  adds menu items to the navbar */
     self::add_menu_items(self::$menu_array);
     
     /*close out the navbar formatting */
     print '</ul></div></div></nav>' . PHP_EOL;
  }

  
   private static function add_glyph_link($glyph_name, $url_link, $link_label){
       print '<li><a href="' . $url_link . '"><span class="glyphicon ' . 
          $glyph_name . '"></span> ' . $link_label . '</a></li>';
   }
   
   private static function add_menu_items($array){
       foreach($array as $key=>$val) {
          $col_name = ucwords($key);
          $dropdown_array = $array[$key]['dropdown_items'];        
          $class_item = self::add_class_item($array[$key]['class']);        
          self::add_dropdown_menu($col_name, $class_item, $array[$key]['link'], $dropdown_array);
       }       
   }
   
    /**
     * sets class identifier to active, etc. for the parent column depending on 
     * entry in the menu array. The array has a key named 'class' whose value 
     * is set in the array on setup. 
     * @param type $item array index containing the value of the class setting
     */
    private static function add_class_item($item){
        $class ='';
        if (! empty($item)){
           $class = ' class="'. $item . '"'; 
        }
        return $class;
    }
    
    private static function add_dropdown_menu($col_name, $class_item, $col_link, $dropdown_array){
        if(! empty($dropdown_array)){
           print '<li class="dropdown"><a class="dropdown-toggle" data-toggle='
           . '"dropdown" href="' . $col_link. '">'  . $col_name . 
           '<span class="caret"></span></a>'. PHP_EOL;
           print '<ul class="dropdown-menu">'. PHP_EOL;
           foreach($dropdown_array as $key=>$value) {              
             print '<li><a href="' . $value .  '">' . $key . '</a></li>'. 
             PHP_EOL;
           }
           print '</ul></li>'. PHP_EOL;
        }else{
          print '<li' . $class_item . '><a href="' . $col_link . '">' . 
          $col_name . '</a></li>'. PHP_EOL;
        }
    }
 }
 ?>