<?php
foreach([
    'vars.php',
        'functions.php',
            'Requests/Requests.php',
                'dataBase/dataBase.php',
                        'forMembers/setLang.php',
                            'forMembers/uploadFile.php',
                                    'forDev/acceptVip.php',
                                         'forMembers/other.php',
                                            'forDev/panel.php'
                                             ] as $file):
                                                require_once($file);
                                            endforeach;
telegram::textJoin();
if($chatType == 'private')
{
if ($text == "/start" or checkText($text) == "back")
{
    $txt = $LANGUAGE->keyboard_start->one;
    $txt2 = $LANGUAGE->keyboard_start->two;
    $txt3 = $LANGUAGE->keyboard_start->three;
    $txt4 = $LANGUAGE->keyboard_start->four;
    telegram::sendMessage([
        'text' => $LANGUAGE->text,
        'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "$txt2"], ['text' => "$txt"]],
                [['text' => "$txt3"], ['text' => "$txt4"]],
                ]
            ])
    ]);
}
elseif(preg_match("/^[\/]?start (.*)/", $text, $array))
{
    $code = $array[1];
    $type = dataBase::pullType($code);
   telegram::sendRequest("send$type", [
        'chat_id' => $chatId,
        "$type" => dataBase::pullFileId($code)
    ]);
}
}