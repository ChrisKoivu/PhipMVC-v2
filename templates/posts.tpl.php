
<div class="content container">  

    <?php if (!empty($posts))  { ?>
       <?php foreach($posts as $post) {?>
          <?php
              $edit_link = str_replace('index','edit',$post['post_link']);
              $delete_link = str_replace('index','delete',$post['post_link']);
              if($username ===  $post['user_username']){
                $auth = true;
              } else {
                $auth = false;
              }
          ?>
          <div class="post">
            <div class="col-md-12  ">
               <h3><?php echo $post['title']; ?></h3>
               <p><?php echo $post['body'];?></p>
               <?php if ($auth){ echo '<p><a class="btn btn-secondary" href="' . $edit_link . '" role="button">Edit post &raquo;</a>';}?>
               <?php if ($auth){ echo '<a class="btn btn-secondary" href="' . $delete_link . '" role="button">Delete post &raquo;</a>';}?>
               <?php echo '</p>';?>
               </p>

               <hr>          
            </div>     
          </div><!-- end of post section -->
        <?php } ?>
    <?php  } else {   
       echo 'there are no posts yet';  
    }
 ?>    
</div> <!-- /container -->

      