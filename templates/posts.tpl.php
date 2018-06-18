


<div class="content container">  

    <?php if (!empty($posts))  { ?>
       <?php foreach($posts as $post) {?>
          <div class="post">
            <div class="col-md-12  ">
               <h3><?php echo $post['title']; ?></h3>
               <p><?php echo $post['body'];?></p>
               <p><a class="btn btn-secondary" href="<?php echo $post['post_link']; ?>" role="button">View details &raquo;</a></p>
               <hr>          
            </div>     
          </div><!-- end of post section -->
        <?php } ?>
    <?php  } else {   
       echo 'there are no posts yet';  
    }
 ?>    
</div> <!-- /container -->

      