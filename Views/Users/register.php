<?php

include($this->header);   
/* greeting is data that was passed to this view
from the HomeController index method */
//Print $greeting;
include HOME . '/templates/content.php';
include($this->footer); 



?>