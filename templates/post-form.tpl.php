<?php include HOME . '/Core/includes/post.inc.php'; ?> 
    
    
<div class="form-wrapper">

<h2>Add Post</h2>

<p>Please complete this form</p>

<form action="" method="post">
    <div class="form-group"> 
        <label>Title</label> 
        <input type="text" class="form-control" id="post-title" placeholder="Title of your post"> 
     </div>
     
     <div class="form-group">  
        <label>Post Body</label>
        <textarea class="form-control" id="post-body" rows="10">
        </textarea> 
     </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" value="submit">
     </div>
 </form>
        


</div>    <!-- close wrapper -->
