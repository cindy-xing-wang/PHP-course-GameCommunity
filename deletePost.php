<?php
require_once 'config/config.php';
include('libraries/Database.php');
if ($_GET['id']) {
      $id = $_GET['id'];
      session_start();
      $DB = new Database;
      $DB->selectDatabase();
      $sql = "DELETE FROM post where id = '$id'";
      $DB->query($sql);
      header("location: postUser.php");
}
?>

 <!DOCTYPE html>
 <html lang="en">
   <head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <link rel="stylesheet" href="css/style.css" />
     <title><?php echo SITENAME; ?></title>
   </head>
   <body>
     <nav class="navbar bg-primary">
         <a href="index.php"> <img class="logo round-img" src="img/logo.png" alt="logo"></a>
       <ul>
         <li><a href="index.php">Home</a></li>
         <li>
           |
           <a href="logout.php">Logut</a>
         </li>
       </ul>
     </nav>
     <section class="container">
       <h1 class="large text-primary">
         Posts
       </h1>
       <p class="lead"> Welcome to the community!</p>

       <div class="post-form">
         <div class="bg-primary p">
           <h3>Say Something...</h3>
         </div>
         <form class="form my-1" action="deletePost.php" method="POST">
           <textarea
             class="my-1"
             name="title"
             cols="30"
             rows="1"
             placeholder="Post title"
             required
           ><?php echo $row['title']; ?></textarea>
           <textarea
             name="content"
             cols="30"
             rows="5"
             placeholder="Create a post"
             required
           ><?php echo $row['content']; ?></textarea>
           <input type="submit" name="submitPost"class="btn btn-primary btn-outstanding my-1" value="Submit" />
           <span><?= $emptyArea; ?></span>
         </form>
       </div>
     </section>
   </body>
 </html>
