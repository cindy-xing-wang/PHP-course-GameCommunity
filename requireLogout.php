<?php
  require_once 'libraries/Database.php';
  require_once 'config/config.php';
  require_once 'libraries/Controller.php';
  require_once 'controllers/Users.php';

 // Logout
 $session = new LoggingByEmailSession();
 $userController = new Users($session);
 $userController->logout();
