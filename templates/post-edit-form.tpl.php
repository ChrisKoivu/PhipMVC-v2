<?php include HOME . '/Core/includes/post.inc.php'; ?> 
<div class="form-wrapper">

<h1>Edit Post</h1>

<p>Please complete this form</p>
 
<h3><?php echo 'Post Title: ' . trim($title)?></h3>
<form action="" method="post">
    <div class="form-group">  
        <textarea class="form-control" name="post_body" rows="10"><?php echo trim($body);?></textarea> 
        <span class="help-block"><?php echo $body_err; ?></span>
     </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" value="submit">    
     </div>
 </form>
        


</div>    <!-- close wrapper -->
