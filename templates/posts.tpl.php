


<div class="content container">  

    <?php 
    print_r($posts);
    print sizeof ($posts);
    if (!empty($posts))  { ?>
        <div class="post">
          <div class="col-md-12  ">
            <h3><?php echo $posts['title']; ?></h3>
            <p><?php echo $posts['body'];?></p>
            <p><a class="btn btn-secondary" href="<?php echo $post_value['post_link']; ?>" role="button">View details &raquo;</a></p>
            <hr>          
          </div>     
        </div><!-- end of post section -->
      
    <?php  } else {   
       echo 'there are no posts yet';  
    }
 ?>    
</div> <!-- /container -->

      