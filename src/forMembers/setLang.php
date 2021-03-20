<?php
if(checkText($text) == "Select Language")
{
telegram::sendMessage([
        'text' => $LANGUAGE->txt_setlang,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "english", 'callback_data' => "setlang_english"], ['text' => "فارسی", 'callback_data' => "setlang_persian"]]
                ]
            ])
    ]);
}
if(isset($dataCall))
{
    if(preg_match("/setlang_(.*)/", $dataCall, $array))
    {
        $lang = $array[1];
        $LANGUAGE = simplexml_load_file("language/".$lang.".xml") or die();
        dataBase::setLang($fromId, $lang);
        $txt = str_replace("%l", $lang, $LANGUAGE->lang_set);
        telegram::answer(str_replace("%l", $lang, $txt));
        $txt = $LANGUAGE->keyboard_start->one;
    $txt2 = $LANGUAGE->keyboard_start->two;
    $txt3 = $LANGUAGE->keyboard_start->three;
    $txt4 = $LANGUAGE->keyboard_start->four;
        telegram::editMessage([
            'chat_id' => $callChatId,
            'text' => $txt,
            'message_id' => $callMsgId,
            'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "$txt2"], ['text' => "$txt"]],
                [['text' => "$txt3"], ['text' => "$txt4"]],
                ]
            ])
            ]);
    }
}
echo 'tsts';