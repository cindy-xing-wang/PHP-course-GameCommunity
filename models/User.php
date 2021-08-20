<?php
  class User {
    private $db;
    public function __construct() {
      $this->db = new Database;
      $this->db->selectDatabase();
    }

    public function register($data) {
          $username = $data["username"];
          $email = $data["email"];
          $password = $data["password"];
          $sql = "INSERT INTO postuser (username, email, password) VALUES ('$username', '$email', '$password')";
           if ($this->db->query($sql)) {
             echo "register";
               return true;
           } else {
             echo "failregister";
               return false;
           }
       }

    public function login($email, $password) {
      $sql = "SELECT email,password FROM postuser where email = '$email'";
      $result = $this->db->query($sql);
      $hashedPassword = $result->fetch()["password"];
      if (password_verify($password, $hashedPassword)) {
        return true;
      } else {
        return false;
      }
    }

    public function findUserByEmail($email) {
      $sql = "SELECT email FROM postuser where email = '$email'";
      $result = $this->db->query($sql);
      if ($result->size() != 0) {
        return true;
      } else {
        return false;
      }
    }
  }
