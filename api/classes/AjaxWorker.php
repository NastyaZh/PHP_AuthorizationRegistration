<?php

/*
 * working with Ajax requests
*/

class AjaxWorker
{
    public $actions = array();

    public $data;
    public $code;
    public $message;
    public $status;

    public $request;
    public $response;

    public function __construct($request)
    {
        $this->request = $request;
        $action = $this->getRequestParam("act");

        if (!empty($this->actions[$action])) {
            $callback = $this->actions[$action];
            call_user_func(array($this, $callback));
        } else {
            header("HTTP/1.1 400 Bad Request");
            $this->setFieldError("main", "Bad request");
        }

        $this->response = $this->renderToString();
    }



    public function getRequestParam($name)
    {
        if (array_key_exists($name, $this->request)) {
            return $this->request[$name];
        }
        return null;
    }


    public function setResponse($key, $value)
    {
        $this->data[$key] = $value;
    }


    public function setFieldError($name, $message = "")
    {
        $this->status = "err";
        $this->code = $name;
        $this->message = $message;
    }


    public function renderToString()
    {
        $json = array(
            "status" => $this->status,
            "code" => $this->code,
            "message" => $this->message,
            "data" => $this->data,
        );
        return json_encode($json);
    }


    public function showResponse()
    {
        //Content-type: application/json; charset=utf-8 designates the content to be in JSON format, encoded in the UTF-8 character encoding. 
        header("Content-Type: application/json; charset=UTF-8");
        echo $this->response;
    }
}
