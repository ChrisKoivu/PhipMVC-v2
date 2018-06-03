
<?php 
       include($this->header);
       print '<div class="welcome"><h1>' . $title . '</h1></div>';
       include HOME . '/templates/posts.tpl.php';
       include($this->footer); 
       
?>  
       