<?php
/*
 * User DAO class
*/
require_once 'JsonWorker.php';
require_once 'User.php';

class UserDAO
{

    private function createUser($arrUser) {
        $login = $arrUser['login'];
        $password = $arrUser['password'];
        $email = $arrUser['email'];
        $name = $arrUser['name'];
        $salt = $arrUser['salt'];
        return new User($login, $password, $email, $name, $salt);  
    }

    public function passwordHash($password, $salt = null)
    {
        $salt || $salt = uniqid();
        $hash =  $salt . md5($password);

        return array('hash' => $hash, 'salt' => $salt);
    }
    
    public function getUsers()
    {
        $db = new JsonWorker();
        $arrayUsersObj = new ArrayObject();
        try{
            $users = $db->readJson();
            foreach ($users as $user) {
                $arrayUsersObj->append($this->createUser($user));
            }
            return $arrayUsersObj;
        }
        catch (Exception $ex)
        {
            throw new Exception("Error getting all users.");
        }
    }

    public function getUserByLogin($login) {
        try{
            $users = $this->getUsers();
            foreach ($users as $user) {
                if ($user->getLogin() == $login) {
    
                    return $user;
                }
            }
        }
        catch (Exception $ex)
        {
            throw new Exception("Error getting user by login: '$login'.");
        }
    }

    public function getUserByEmail($email) {
        try{
            $users = $this->getUsers();
            foreach ($users as $user) {
                if ($user->getEmail() == $email) {
    
                    return $user;
                }
            }
        }
        catch (Exception $ex)
        {
            throw new Exception("Error getting user by email: '$email'.");
        }
    }

    public function getSalt($login) {
        try{
            $users = $this->getUsers();
            foreach ($users as $user) {
                if ($user->getLogin() == $login) {
    
                    return $user->getSalt();
                }
            }
        }
        catch (Exception $ex)
        {
            throw new Exception("Error getting salt.");
        }
    }

    public function registerUser($login, $password, $email, $name, $salt) 
    {
        try{
            $db = new JsonWorker();
            $user = array( "login" => $login, "password" => $password, "email" => $email, "name" => $name, "salt" => $salt);
            $db->putJson($user);
            return true;
        }
        catch (Exception $ex)
        {
            throw new Exception("Error during insert user in DB.");
        }
    }

    public function authorizeUser($login, $password) 
    {
        try{
            $userExistByLogin = $this->getUserByLogin($login);
            if ($userExistByLogin && $userExistByLogin->getPassword() == $password) {
                return $userExistByLogin;
            }
        }
        catch (Exception $ex)
        {
            throw new Exception("Error during authorization.");
        }
    }
}
