
 	



  <?php include($this->header); ?>
    
  <div class = "content">
     <h3> This is the admin page </h3> 
     <?php if(!empty($error)){ ?>
        <div class="help-block"> <?php echo $error;?> </div>
        <a class="btn btn-secondary" href="/home/index/" role="button">Return &raquo;</a> 
     <?php } ?>
  </div>
 <?php include($this->footer); ?>