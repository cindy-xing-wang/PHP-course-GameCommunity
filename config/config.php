<?php
// Database params
  define('HOST', 'localhost:8111');
  define('USERNAME', 'root');
  define('PASSWORD', '');
  define('DBNAME', 'gameCommunity');

  require_once 'LoggingByEmailSession.php';
  // Create Session
  session_start();

  //set language
  $session = new LoggingByEmailSession();
  if (!$session->isKeySet('lang')) {
    $session->set('lang', 'en');
  } elseif (isset($_GET['lang']) && $session->get('lang') != $_GET['lang'] && !empty($_GET['lang'])) {
    if ($_GET['lang']== "en") {
      $session->set('lang', 'en');
    } elseif ($_GET['lang']== "hindi") {
      $session->set('lang', 'hindi');
    }
  }

  $file = $_SESSION['lang'] . ".ini";
  $lang = parse_ini_file($file);
