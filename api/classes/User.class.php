<?php
/*
 * User class
*/

class User
{
    private $login;
    private $password;
    private $email;
    private $name;
    private $salt;
    private $isAuthorized = false;

    function __construct($login, $password, $email, $name, $salt) {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
        $this->salt = $salt;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function getIsAuthorized() {
        return $this->isAuthorized;
    }

    public function setIsAuthorized($isAuthorized) {
        $this->isAuthorized = $isAuthorized;
    }

    public function __toString()
   {
     return $this->login . ' '. $this->password . ' '. $this->email . ' '. $this->name . ' '. $this->salt. ' '. $this->isAuthorized;
   }
}

?>