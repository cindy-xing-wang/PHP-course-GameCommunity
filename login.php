<?php
$session = new LoggingByEmailSession();
require_once 'config/config.php';
$file = 'config/'. $session->get('lang') . ".ini";
$lang = parse_ini_file($file);
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
        <li><a href="index.php">Home</a></li>
      </ul>
    </nav>
    <section class="container">
      <h1 class="large text-primary">Sign In</h1>
      <p class="lead">Sign into Your Account</p>
      <form class="form" action="require.php" method="POST">
        <div class=" my-1">
          <input
            type="email"
            placeholder="Email Address"
            name="email"
            required
          />
        </div>
        <div class=" my-1">
          <input
            type="password"
            placeholder="Password"
            name="password"
          />
        </div>
        <div>

          <span><?= $data['emailOrPass_err']; ?></span>
        </div>
        <input type="submit" name="login" class="btn btn-primary" value="Login" />
      </form>
       <p class="my-1">
         Don't have an account?
         <a href="requireRegister.php">Sign Up</a>
       </p>
    </section>
  </body>
</html>
