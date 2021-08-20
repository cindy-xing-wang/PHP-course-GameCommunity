<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Welcome To The Game Community</title>
  </head>
  <body>
    <nav class="navbar bg-primary">
            <a href="index.php"> <img class="logo round-img" src="img/game.png" alt="logo"></a>
          <ul>
            <li><a href="index.php">Home</a></li>
          </ul>
        </nav>
    <section class="container">
      <h1 class="large text-primary">Sign Up</h1>
      <p class="lead"> Create Your Account</p>
      <form class="form" action="requireRegister.php" method="POST">
        <div class="form-group my-1">
          <input type="text" placeholder="Name" name="username" required />
          <span><?= $data['username_err']; ?></span>
        </div>
        <div class="form-group my-1">
          <input type="email" placeholder="Email Address" name="email" />
          <span><?= $data['email_err']; ?></span>
        </div>
        <div class="form-group my-1">
          <input
            type="password"
            placeholder="Password"
            name="password"
            minLength="6"
          />
          <span><?= $data['password_err']; ?></span>
        </div>
        <div class="form-group my-1">
          <input
            type="password"
            placeholder="Confirm Password"
            name="password2"
            minLength="6"
          />
          <span><?=$data['confirm_password_err'] ; ?></span>
        </div>
        <input type="submit" name="register" class="btn btn-primary" value="Register" />
      </form>
      <p class="my-1">
        Already have an account? <a href="require.php">Sign In</a>
      </p>
    </section>
  </body>
</html>
