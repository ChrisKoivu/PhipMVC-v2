<?php include HOME . '/Core/includes/post.inc.php'; ?> 

<style>
.form-group{
    margin-top: 10px;
}
</style>

<div class="form-wrapper">

<h2>Add Post</h2>

<p>Please complete this form</p>
<span class="help-block"><?php echo $error; ?></span>
<form action="" method="post">
    <div class="form-group"> 
        <label>Title</label> 
        <input type="text" class="form-control" name="post_title" value="<?php echo trim($post_title); ?>"> 
        <span class="help-block"><?php echo $title_err; ?></span>
     </div>
     
     <div class="form-group">  
        <label>Post Body</label>
        <textarea class="form-control" name="post_body" rows="10"><?php echo trim($post_body);?></textarea> 
        <span class="help-block"><?php echo $body_err; ?></span>
     </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" value="submit">    
     </div>
 </form>
        


</div>    <!-- close wrapper -->
