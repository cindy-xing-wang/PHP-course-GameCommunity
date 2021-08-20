<?php
require_once 'config/config.php';
 ?>
 <!DOCTYPE html>
 <html lang="en">
   <head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <link rel="stylesheet" href="css/style.css" />
     <title><?php echo $lang['sitename']; ?></title>
   </head>
   <body>
     <header class="home-header bg-primary">
       <img class="logo round-img" src="img/<?php echo $lang['logo']; ?>.png" alt="logo">
     </header>
     <section class="home-section">
       <h1 class="large text-primary"><?php echo $lang['welcome']; ?></h1>
       <p class="m-1 text-primary medium"><?php echo $lang['subTitle']; ?></p>
     </section>
     <section class="home-section">
       <a class= " btn btn-primary enter" href="require.php"><?php echo $lang['enter']; ?></a>
     </section>
   </body>
 </html>
