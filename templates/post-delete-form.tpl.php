<?php
  $nonce = New Nonce ();
  $cnonce = $nonce->get_nonce();
?> 
<div class="form-wrapper">

<h1>Delete Post</h1>

<p><?php echo $confirm; ?></p>

   <p><?php echo '<div class = "help-block">' . $error . '</div>'; ?></p>
   <?php if(!empty ($title)){ echo '<h3>Post Title: ' . trim($title) . '</h3>';}?>
   <?php  if(!empty ($body)){ echo '<p>' . trim($body) .'</p>';}?>


<form action="" method="post">
     <div class="form-group">
        <?php if(!empty ($title)){
           If($nonce->verify_nonce ($cnonce)){
             echo '<input type="submit" class="btn btn-primary" value="Delete">';
           } else {
             echo '<div class = "help-block"> Invalid Request !</div>';
           }
        }else{
            echo '<a class="btn btn-secondary" href="/post/index/" role="button">Return &raquo;</a>';
        }  
        ?>  
        
        </div>
 </form>
        


</div>    <!-- close wrapper -->