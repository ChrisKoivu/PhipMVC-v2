<?php

include($this->header);   
/* greeting is data that was passed to this view
from the HomeController index method */
//Print $greeting;
include HOME . '/templates/register.tpl.php';
include($this->footer); 



?>