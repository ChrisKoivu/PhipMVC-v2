
 	
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
 


class PostModel extends Model
{


    function __initialize ()
{
  $this->create_tables();
}


 function create_tables()
 {
      $sql ="CREATE TABLE IF NOT EXISTS posts "
        . "(id INT NOT NULL AUTO_INCREMENT, "
        . "title VARCHAR(50), "
        . "body TEXT, "
        . "created datetime, "
        . "modified datetime, "
        . "PRIMARY KEY (id))";        
      $this->_setSql($sql);
      $this->createTable();
  }


     function add_post($title, $body)
    {
       $datetime = $this->get_datetime();
       $new_post = "INSERT INTO posts (title, body, created, modified) VALUES (?, ?, ?, ?)";
       $this->_setSql($new_post);
       $this->add_record(array($title, $body, $datetime, $datetime));
    }
 
    public function getPosts()
    {
       
        $sql = "SELECT
                    a.id,
                    a.title,                    
                    a.body,
                    a.created,
                    a.modified
                FROM
                    posts a              
                ORDER BY a.created DESC";
         
        $this->_setSql($sql);
        $posts = $this->fetch_all();
         
        if (empty($posts))
        {
            return false;
        }
         
        return $posts;
    }
     
    public function getPostById($id)
    {
       $sql = "SELECT
                    a.id,
                    a.title,                    
                    a.body,
                    a.created,
                    a.modified
                FROM
                    posts a            
                WHERE
                    a.id = ?";
         
        $this->_setSql($sql);
        $postDetails = $this->fetch_record(array($id));
         
        if (empty($postDetails))
        {
            return false;
        }
         
        return $postDetails;
    }
}
