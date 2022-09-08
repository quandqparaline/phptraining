<?php

function setSessionAdmin($key, $value)
{
    $_SESSION['admin'][$key] = $value;
}

function getSessionAdmin($key)
{
    return $_SESSION['admin'][$key];
}

function setSessionUser($key, $value)
{
    $_SESSION['user'][$key] = $value;
}

function getSessionUser($key)
{
    return $_SESSION['user'][$key];
}

function checkAdminLogin()
{
    return !empty(getSessionAdmin($_SESSION['session_user']['id']));
}

function checkUserLogin()
{
    return !empty(getSessionUser($_SESSION['session_user']['id']));
}

function basicUserSetter($data){
    $_SESSION['session_user']['id'] = $data[0]['id'];
    $_SESSION['session_user']['name'] = $data[0]['name'];
    $_SESSION['session_user']['email'] = $data[0]['email'];
    $_SESSION['session_user']['avatar'] = $data[0]['avatar'];
}

function isLoggedIn(){
    if (isset($_SESSION['admin'])) {
        header('Location: /admin/home');
        exit;
    }

    if (isset($_SESSION['user'])) {
        header('Location: /user/home');
        exit;
    }
}

function showLog($data, $continue = false)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";

    if (!$continue) {
        die();
    }
}

function buildURL($url)
{
    return getServerProtocol() . SERVER_DOMAIN . '/' . $url;
}

function getServerProtocol()
{
    return (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://' : 'http://';
}

function getMessage()
{
    $_errorMessages = '';
    //get all possible error messages
    if (empty($_errorMessages)) {
        $_errorMessages = require ROOT . '/config/error_message.php';
    }

    $arguments = func_get_args();
    $first = array_shift($arguments);

    //check if message exist
    if (!isset($_errorMessages[$first])) {
        return null;
    }

    $message = $_errorMessages[$first];

    //For multi-level of message
    while (true) {
        //If there is no more level in $argument, return the message
        if (!$arguments) {
            return $message;
        }

        //If next level of argument is null or $message is an array -> return null
        //Otherwise, the message is gotten.
        $key = array_shift($arguments);
        if (!is_array($message) || !isset($message[$key])) {
            return null;
        }
        $message = $message[$key];
    }
}

function handleFlashMessage($message)
{
    $tempMessage = null;

    //check if there is any unread message
    if (isset($_SESSION['flash_message']) && empty($_SESSION['flash_message'])){
        unset($_SESSION['flash_message']);
        return $tempMessage;
    }

    //if ['flash_message'] . . . exist and has item
    //then check if ['flash_message']['item'].... contain message
    //only print first message from that ['item'][...] array
    //remove that section from 'flash_message'
    if(isset($_SESSION['flash_message']) && !empty($_SESSION['flash_message'])){
        if (!empty($_SESSION['flash_message'][$message])){
            $arrayMessage = $_SESSION['flash_message'][$message];
            $tempMessage = array_shift($arrayMessage);
        }
        unset($_SESSION['flash_message'][$message]);
    }

    return $tempMessage;
}

function handleOldData($targetInfo)
{
    $tempInput = null;

    if (isset($_SESSION['old_data'][$targetInfo])) {
        $tempInput = $_SESSION['old_data'][$targetInfo];
        unset($_SESSION['old_data'][$targetInfo]);
    }
    return $tempInput;
}

function oldData($field, $default = '')
{
    $data = handleOldData($field);
    return isset($data) ? $data : $default;
}