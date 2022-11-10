<?php
/*
 * session command handler
*/

require_once 'User.class.php';

class SessionWorker
{
    public static function isAuthorized()
    {
        if (!empty($_SESSION["login"])) {
            return (bool) $_SESSION["login"];
        }
        return false;
    }

    public static function getNameFromSession()
    {
        if (!empty($_SESSION["name"])) {
            return $_SESSION["name"];
        }
        return "NAME";
    }

    public static function logout()
    {
        if (!empty($_SESSION["login"])) {
            unset($_SESSION["login"]);
        }
    }

    public static function saveSession(User $user, $httpOnly = true, $days = 7)
    {
        $_SESSION["login"] = $user->getLogin();
        $_SESSION["name"] = $user->getName();
        
        // Save session id in cookies
        $sid = session_id();
        
        $expire = time() + $days * 24 * 3600;
        $domain = ""; // default domain
        $secure = false;
        $path = "/";
        
        $cookie = setcookie("sid", $sid, $expire, $path, $domain, $secure, $httpOnly);
    }

    public static function checkRequestMethod()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }
    }
}

?>