<?php
require_once 'AbstractSession.php';

class LoggingByEmailSession extends AbstractSession {
    function isLoggedIn() : bool {
        if (isset($_SESSION['email'])) {
            return true;
        } else {
            return false;
        }
    }
}
