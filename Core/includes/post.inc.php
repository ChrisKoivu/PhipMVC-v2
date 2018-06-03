
 <?php

    $post_title = $post_body = "";
    $title_err = $body_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        global $post_title, $post_body, $title_err, $body_err;

        $post_title = $_POST['post_title'];
        $post_body = $_POST['post_body'];

        if(empty($post_title)){
          $title_err = "Title cannot be blank";
        }

        if(empty($post_body)){
           $body_err = "Body cannot be blank";
        }


    } /* end of server request method method post */
   

    
?>