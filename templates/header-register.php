
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

     <title><?php echo SITE_TITLE ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo STYLESHEET_DIR . 'styles.css' ?>">
  </head>
  <div id="header">

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#"><?php echo SITE_TITLE ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/home/index">Home <span class="sr-only">(current)</span></a>
          </li>
          <?php $session = New Session();?>
          <?php if ($session->is_admin()){ ?> 
            <?php print '<li class="nav-item">' . PHP_EOL;?>
            <?php print '<a class="nav-link" href="/user/admin/">Admin</a>'.PHP_EOL;?>
            <?php print '</li>' . PHP_EOL; ?>
          <?php } ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Post</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="/post/index/">Read Posts</a>
              <a class="dropdown-item" href="/post/add_post/">Add Post</a>
            </div>
              </li>
        </ul>
      </div>
      
      <?php 
         $session = New Session();
         if($session->is_logged_in()){
           $link_text = "Logout";
           $link = "/user/logout";
         }else{
          $link_text = "Login";
          $link = "/user/login";
         }
      ?>
       <div class = "navbar-right"><a href="<?php echo $link; ?>" class="nav-link"><?php echo $link_text; ?> </a>
      </div>
    </nav>
  </div>
<body>