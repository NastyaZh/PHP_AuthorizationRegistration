<?php

include 'api/classes/AjaxCommand.php';

if (!empty($_COOKIE['sid'])) {
    session_id($_COOKIE['sid']);
}
session_start();

$ajaxRequest = new AjaxCommand($_REQUEST);
$ajaxRequest->showResponse();

