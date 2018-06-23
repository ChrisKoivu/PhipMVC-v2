<?php //include HOME . '/Core/includes/post.inc.php'; ?> 
<div class="form-wrapper">

<h1>Delete Post</h1>

<p>Are you sure you want to delete this post?</p>
 
<h3><?php echo 'Post Title: ' . trim($title);?></h3>
<p>  
   <?php echo trim($body);?>
</p>


<form action="" method="post">
     <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Delete">    
     </div>
 </form>
        


</div>    <!-- close wrapper -->
