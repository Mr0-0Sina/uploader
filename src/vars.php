<?php
define("CONFIG", parse_ini_file("config.ini"));
require_once('dataBase/dataBase.php');
dataBase::checkDataBase();
$update = file_get_contents("php://input");
$updateArray = json_decode($update, true);
if (isset($updateArray['message']))
    {
        $message = $updateArray['message'];
        $text = $message['text'];
        $fromId = $message['from']['id'];
        $chatId = $message['chat']['id'];
        $fromFirstName = $message['from']['first_name'];
        $fromUsename = (isset($message['from']['username']))? $message['from']['username'] : null;
        $chatType = $message['chat']['type'];
        $messageId = $message['message_id'];
    }
    elseif (isset($updateArray['edited_message']))
    {
        $message = $updateArray['edited_message'];
        $text = (isset($message['text']))? $message['text'] : false;
        $fromId = $message['from']['id'];
        $chatId = $message['chat']['id'];
        $fromFirstName = $message['from']['first_name'];
        $fromUsename = (isset($message['from']['username']))? $message['from']['username'] : "یافت نشد";
        $chatType = $message['chat']['type'];
        $chatUserName = $message['chat']['username'];
        $messageId = $message['message_id'];
    }
    elseif (isset($updateArray['callback_query']))
    {
        $call = $updateArray['callback_query'];
        $dataCall = $call['data'];
        $fromIdCall = $call['from']['id'];
        $fromFirstNameCall = $call['from']['first_name'];
        $callChatId = $call['message']['chat']['id'];
        $callChatType = $call['message']['chat']['type'];
        $callText = $call['message']['text'];
        $callUserName = $call['message']['chat']['username'];
        $callMsgId = $call['message']['message_id'];
        $callId = $call['id'];
    }
    if(isset($callChatId) or isset($chatId))
    $chatId = (isset($callChatId)) ? $callChatId : $chatId;
    $fromId = (isset($fromIdCall)) ? $fromIdCall : $fromId;
    if(isset($fromId) and ! dataBase::checkUser($fromId))
     dataBase::insertUser($fromId);
    $LANGUAGE = simplexml_load_file("language/".dataBase::getLang($fromId).".xml") or die();
    if(file_exists("error_log"))
    unlink("error_log");
   