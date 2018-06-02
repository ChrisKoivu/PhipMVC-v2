


<div class="content container">  
    <?php  if ($posts)  {   ?>

        <?php foreach($posts as $post_value) {?>
        <div class="post">
          <div class="col-md-12  ">
            <h3><?php echo $post_value['title']; ?></h3>
            <p><?php echo $post_value['body'];?></p>
            <p><a class="btn btn-secondary" href="<?php echo $post_value['post_link']; ?>" role="button">View details &raquo;</a></p>
            <hr>          
          </div>     
        </div><!-- end of post section -->
        <?php } ?>
    <?php  } else {   
       echo 'there are no posts yet';  
    }
 ?>    
</div> <!-- /container -->

      