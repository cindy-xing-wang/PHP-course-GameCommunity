<?php
  require_once 'libraries/Database.php';
  require_once 'LoggingByEmailSession.php';
  require_once 'config/config.php';
  require_once 'libraries/Controller.php';
  require_once 'controllers/Users.php';

   // Create User controller
   $session = new LoggingByEmailSession();
   $userController = new Users($session);
   $userController->login();
   // Check user login status
   if ($session->isLoggedIn()) {
     header('location:postUser.php');
   }
