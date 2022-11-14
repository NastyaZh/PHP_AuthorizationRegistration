<?php
/*
 * command handler
*/

require_once 'UserDAO.php';
require_once 'User.php';
require_once 'SessionWorker.php';

class ServiceCommand
{
    public function authorizeCommand($login, $password)
    {
        $userDAO = new UserDAO();
        $session = new SessionWorker();
        $salt = $userDAO->getSalt($login);
        if (!$salt) {
            return false;
        }

        $hashes = $userDAO->passwordHash($password, $salt);
        $user = $userDAO->authorizeUser($login, $hashes['hash']);
        
        if (($user instanceof User)) {
            $user->setIsAuthorized(true);
            $session->saveSession($user);
            return true;
        } 
        return false;
    }


    public function registrateCommand($login, $password, $email, $name) {
        $userDAO = new UserDAO();
        $userExistByLogin = $userDAO->getUserByLogin($login);
        $userExistByEmail = $userDAO->getUserByEmail($email);
        $hashes = $userDAO->passwordHash($password);
        
        if ($userExistByLogin) {
            throw new Exception("Login exists: " . $login, 1);
        }
        if ($userExistByEmail) {
            throw new Exception("Email exists: " . $email, 1);
        }
        $isRegistrated = $userDAO->registerUser($login, $hashes['hash'], $email, $name, $hashes['salt']);
        return $isRegistrated;
    }
}
