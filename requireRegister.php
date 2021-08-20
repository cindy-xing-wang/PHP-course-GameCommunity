<?php
  require_once 'libraries/Database.php';
  require_once 'config/config.php';
  require_once 'libraries/Controller.php';
  require_once 'controllers/Users.php';

  $session = new LoggingByEmailSession();
  // Create User controller
  $userController = new Users($session);
   $userController->register();
