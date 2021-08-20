<?php
declare(strict_types = 1);
require_once 'ISession.php';

abstract class AbstractSession implements ISession {
  public function get(string $key) {
      if ($this->isKeySet($key)) {
         return $_SESSION[$key];
      } else {
          return NULL;
      }
  }

  public function set($key, $value) {
      $_SESSION[$key] = $value;
  }

  public function isKeySet(string $key):bool {
      return isset($_SESSION[$key]);
  }

  public function clear() {
      foreach ($_SESSION as $key=>$value) {
          unset($_SESSION[$key]);
      }
      session_destroy();
  }

  abstract function isLoggedIn(): bool;
}
