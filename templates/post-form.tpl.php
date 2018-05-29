    <?php include HOME . '/Core/includes/login.inc.php'; ?> 
    
    
<div class="form-wrapper">

<h2>Add Post</h2>

<p>Please complete this form</p>

<form action="" method="post">

    <div class="form-group"> 
        <label for="exampleFormControlInput1">Email address</label> 
        <input type="text" class="form-control" id="post-title" placeholder="Title of your post"> 
     </div>
     
     <div class="form-group">  
        <label for="exampleFormControlTextarea1">Example textarea</label> 
        <textarea class="form-control" id="post-body" rows="10">
        </textarea> 
     </div>
     <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit">
     </div>
 </form>
        


</div>    <!-- close wrapper -->
