<?php
require_once 'config/config.php';
include('libraries/Database.php');

$now = time();

if ($now > $_SESSION['expire']) {
    session_destroy();
    header("location: require.php");
} else {
  $DB = new Database;
  $DB->selectDatabase();
  $sql = "SELECT id, title, content, date FROM post;";
  $result = $DB->query($sql);
  $_SESSION["displayTitle"] = false ;
  $emptyArea = '';
  $id;
if($_SERVER["REQUEST_METHOD"] == "POST") {

  // order by time ;
if (isset($_POST['order'])) {
      $_SESSION["displayTitle"] = false;
      $sql = "SELECT id, title, content, date FROM post order by date desc;";
      $result = $DB->query($sql);
      // $displayTitle ;
} elseif (isset($_POST['displayTitle'])) {
      $_SESSION["displayTitle"] = true;
      $sql = "SELECT id, title ,date FROM post;";
      $result = $DB->query($sql);
}
if (isset($_POST['createPost'])) {
    if (!empty(trim($_POST["title"])) && !empty(trim($_POST["content"]))) {
                $title = htmlspecialchars(trim($_POST["title"]));
                $content = htmlspecialchars(trim($_POST["content"]));
                date_default_timezone_set('Pacific/Auckland');
                $current_time = $date = date('Y-m-d H:i', time());
                $sql = "INSERT INTO post (id, title, content, date)
                VALUES (null, '$title', '$content', '$current_time')";
                $DB->query($sql);
                header("location: postUser.php");
      } else {
        $emptyArea = '<p class="text-danger">'. $lang['emptyArea'] .'</p>';
    }
  }

}
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
          <a href="requireLogout.php"><?php echo $lang['logout']; ?></a>
        </li>
      </ul>
    </nav>
    <section class="container">
      <h1 class="large text-primary">
        <?php echo $lang['posts']; ?>
      </h1>
      <p class="lead"><?php echo $lang['welcome']; ?></p>

      <div class="post-form">
        <div class="bg-primary p">
          <h3><?php echo $lang['say']; ?></h3>
        </div>
        <form class="form my-1" action="postUser.php" method="POST">
          <textarea
            class="my-1"
            name="title"
            cols="30"
            rows="1"
            placeholder="<?php echo $lang['postTitle']; ?>"
            required
          ></textarea>
          <textarea
            name="content"
            cols="30"
            rows="5"
            placeholder="<?php echo $lang['createPost']; ?>"
            required
          ></textarea>
          <input type="submit" name="createPost"class="btn btn-primary btn-outstanding my-1" value="<?php echo $lang['submit']; ?>" />
          <span><?= $emptyArea; ?></span>
        </form>
      </div>

      <div class="posts">
        <form action="postUser.php" method="POST">
          <input name="order" type="submit" class="btn my-top orderby" value="<?php echo $lang['orderByTime']; ?>" />
          <input name="displayTitle" type="submit" class="btn my-top orderby" value="<?php echo $lang['displayTitle']; ?>" />
        </form>
        <?php
        if ($_SESSION["displayTitle"] == true) { ?>
          <?php   while ($row = $result->fetch()){ ?>

              <div class="post bg-white p-1 my-1">
                <div>
                  <h4><?php echo $row["title"]; ?></h4>
                </div>

                <div>
                   <p class="post-date">
                      <?php echo $lang['postOn'];  echo date('Y F j H:i', strtotime($row["date"])); ?>
                  </p>

                      <form  action="editPost.php" method="POST">
                        <input hidden name="id" id="id" value = '<?php echo $row["id"]; ?>'/>
                        <button type="submit" name="edit" class="btn btn-primary my-1" > <?php echo $lang['edit']; ?> </button>
                      </form>

                      <button type="submit"id="id" value = '<?php echo $row["id"]; ?>' name="delete" class="btn btn-danger" onclick="confirmation()"> <?php echo $lang['delete']; ?> </button>
                  </div>

              </div>
            </div>
        <?php  } ?>
      <?php  }  else {

        while ($row = $result->fetch()) {
         ?>
           <div class="post bg-white p-1 my-1">
          <div>
              <h4><?php echo $row["title"]; ?></h4>
          </div>
          <div>
            <p class="my-1">
              <?php echo $row["content"]; ?>
            </p>
             <p class="post-date">
                <?php echo $lang['postOn']; ?> <?php echo date('Y F j H:i', strtotime($row["date"])); ?>
            </p>
            <form  action="editPost.php" method="POST">
              <input hidden name="id" id="id" value = '<?php echo $row["id"]; ?>'/>
            <button type="submit" name="edit" class="btn btn-primary my-1" > <?php echo $lang['edit']; ?> </button>
            </form>
              <button type="submit" id="id" value = '<?php echo $row["id"]; ?>' name="delete" class="btn btn-danger" onclick="confirmation()"> <?php echo $lang['delete']; ?> </button>
          </div>
        </div>
      <?php } }?>

      </div>
    </section>
  </body>
</html>
<script type="text/javascript">
    function confirmation()
    {
      var x = confirm(" Do you want to delete this post?");
      if( x == true)
      {
        var id = document.getElementById('id').value ;
        window.location.href = "deletePost.php?id=" + id
      } else {
        window.location.href = "postUser.php"
      }
    }
</script>
