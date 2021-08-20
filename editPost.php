<?php
require_once 'config/config.php';
include('libraries/Database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DB = new Database;
    $DB->selectDatabase();
    if (isset($_POST["id"])) {
        $_SESSION['editId'] = $_POST["id"];
    }
    if (isset($_POST['edit'])) {
        $emptyArea = '';
        $id = $_SESSION["editId"];
        $sql = "SELECT title, content FROM post where id = '$id'";
        $result = $DB->query($sql);
        $row = $result->fetch();
    } elseif (isset($_POST['submitPost'])) {
        $emptyArea = '';

        if (!empty(trim($_POST["title"])) && !empty(trim($_POST["content"]))) {
            $editId = $_SESSION['editId'];
            $title = trim($_POST["title"]);
            $content = trim($_POST["content"]);
            date_default_timezone_set('Pacific/Auckland');
            $current_time = $date = date('Y-m-d H:i', time());
            $sql = "UPDATE post set title = '$title', content = '$content', date = '$current_time' where id = $editId ";
            $DB->query($sql);
            header("location: postUser.php");
        } else {
            header("location: editPost.php");
        }
    }
} else {
          $DB = new Database;
          $DB->selectDatabase();
          $emptyArea = '';
          $id = $_SESSION["editId"];
          $sql = "SELECT title, content FROM post where id = '$id'";
          $result = $DB->query($sql);
          $row = $result->fetch();
          $emptyArea = '<p class="text-danger">'.  $lang['emptyArea'].'</p>';
}

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
     <nav class="navbar bg-primary">
         <a href="index.php"> <img class="logo round-img" src="img/<?php echo $lang['logo']; ?>.png" alt="logo"></a>
       <ul>
         <li><a href="index.php"><?php echo $lang['home']; ?></a></li>
         <li>
           |
           <a href="logout.php"><?php echo $lang['logout']; ?></a>
         </li>
       </ul>
     </nav>
     <section class="container">
       <h1 class="large text-primary">
         <?php echo $lang['posts']; ?>
       </h1>
       <p class="lead"> <?php echo $lang['welcome']; ?></p>

       <div class="post-form">
         <div class="bg-primary p">
           <h3><?php echo $lang['editPost']; ?></h3>
         </div>
         <form class="form my-1" action="editPost.php" method="POST">
           <textarea
             class="my-1"
             name="title"
             cols="30"
             rows="1"
             placeholder="<?php echo $lang['postTitle']; ?>"
             required
           ><?php echo $row['title']; ?></textarea>
           <textarea
             name="content"
             cols="30"
             rows="5"
             placeholder="<?php echo $lang['createPost']; ?>"
             required
           ><?php echo $row['content']; ?></textarea>
           <input type="submit" name="submitPost"class="btn btn-primary btn-outstanding my-1" value="<?php echo $lang['submit']; ?>" />
           <span><?= $emptyArea; ?></span>
         </form>
       </div>
     </section>
   </body>
 </html>
