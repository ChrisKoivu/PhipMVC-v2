<?php 
    /**
      This class was designed to include a node for a customizable object like 
      the entity methodology used in Drupal 7, for customizable data types, instead
      of a standard pre-defined node.    
    */
    
    class Node{
       private static $field_data_array = array();
     
     
       // node constructor
       public static function  __construct($this_array = NULL){ 
          if (! empty(self::$field_data_array) {
            self::$field_data_array[] = $this_array;           
          }
       }
 
        // add data field and value to node
       public static function addData($field, $data){		
	     self::$field_data_array[$field] = $data;        
       }
       
       // returns data
       public static function getData($field){		
	     return self::$field_data_array[$field];        
       }
	 
       //standard Java-like toString function
       public static function __toString() {
         print_r($field_data_array);
       }
 
    }

?>