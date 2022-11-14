<?php
/*
 * validation of User data
*/
class UserValidator
{
    private $patternLogin = '/^(?=^.{6,}$)([а-яёa-z0-9]+)$/iu';
    private $patternPassword = '/^(?=^.{6,}$)(([0-9]+[a-zа-яё]+)|([a-zа-яё]+[0-9]+))+$/iu';
    private $patternName = '/^[a-zа-яё]{2}$/iu';
    private $patternEmail = '/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i';

    public function validateLogin($login){
        return preg_match($this->patternLogin, $login) > 0 ? true : false;
    }

    public function validatePassword($password){
    	return preg_match($this->patternPassword, $password) > 0 ? true : false;
    }

    public function validateEmail($email){
    	
    	return preg_match($this->patternEmail, $email) ? true : false;
    }

    public function validateName($name){
    	
    	return preg_match($this->patternName, $name) ? true : false;
    }
}

