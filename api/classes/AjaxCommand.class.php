<?php
/*
 * ajax command handler
*/

require_once 'User.class.php';
require_once 'AjaxWorker.class.php';
require_once 'ServiceCommand.class.php';
require_once 'SessionWorker.class.php';
require_once 'UserValidator.class.php';

class AjaxCommand extends AjaxWorker
{
    public $actions = array(
        "login" => "login",
        "logout" => "logout",
        "register" => "register",
    );

    public function login()
    {
        $command = new ServiceCommand();
        SessionWorker::checkRequestMethod();

        setcookie("sid", "");

        $login = $this->getRequestParam("loginAuth");
        $password = $this->getRequestParam("passwordAuth");

        if (empty($login)) {
            $this->setFieldError("loginAuth", "Enter login");
            return;
        }

        if (empty($password)) {
            $this->setFieldError("passwordAuth", "Enter password");
            return;
        }

        
        $auth_result = $command->authorizeCommand($login, $password);

        if (!$auth_result) {
            $this->setFieldError("main", "Invalid login or password");
            return;
        }

        $this->status = "ok";
        $this->setResponse("redirect", ".");
    }

    public function logout()
    {
        SessionWorker::checkRequestMethod();

        setcookie("sid", "");

        $command = new SessionWorker();
        $command->logout();

        $this->setResponse("redirect", ".");
        $this->status = "ok";
    }

    public function register()
    {
        SessionWorker::checkRequestMethod();

        setcookie("sid", "");

        $login = $this->getRequestParam("loginReg");
        $password = $this->getRequestParam("passwordReg");
        $confPassword = $this->getRequestParam("confPassReg");
        $email = $this->getRequestParam("emailReg");
        $name = $this->getRequestParam("nameReg");

        $validator = new UserValidator();


        if (empty($login)) {
            $this->setFieldError("loginReg", "Enter login");
            return;
        }elseif(!($validator->validateLogin($login))){
            $this->setFieldError("loginReg", "Must be 6 characters minimum");
            return;
        }

        if (empty($password)) {
            $this->setFieldError("passwordReg", "Enter password");
            return;
        }elseif(!($validator->validatePassword($password))){
            $this->setFieldError("passwordReg", "Must be 6 characters minimum (contains numbers and letters)");
            return;
        }

        if (empty($confPassword)) {
            $this->setFieldError("confPassReg", "Enter confirm password");
            return;
        }

        if ($password !== $confPassword) {
            $this->setFieldError("confPassReg", "Confirm password is not match");
            return;
        }

        if (empty($email)) {
            $this->setFieldError("emailReg", "Enter email");
            return;
        }elseif(!($validator->validateEmail($email))){
            $this->setFieldError("emailReg", "Must be email");
            return;
        }

        if (empty($name)) {
            $this->setFieldError("nameReg", "Enter name");
            return;
        }elseif(!($validator->validateName($name))){
            $this->setFieldError("nameReg", "Must be 2 characters minimum (only letters)");
            return;
        }


        $command = new ServiceCommand();

        try {
            $new_user_id = $command->registrateCommand($login, $password, $email, $name);
        } catch (\Exception $e) {
            $this->setFieldError("main", $e->getMessage());
            return;
        }
        $command->authorizeCommand($login, $password);
        $this->setResponse("redirect", "/index.php");
        $this->status = "ok";
    }
}
?>