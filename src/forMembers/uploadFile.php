<?php

if(checkText($text) == 'upload')
{
    if(dataBase::isVip($fromId))
    {
         dataBase::setStep($fromId, "upload");
        $txt = $LANGUAGE->upload->keyboard;
      telegram::sendMessage([
        'text' =>  $LANGUAGE->upload->text,
        'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "$txt"]]
                ]
            ])
    ]);
    
    }
        else{
    $txt = $LANGUAGE->notVip->keyboard;
             telegram::sendMessage([
        'text' => $LANGUAGE->notVip->text,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "$txt", 'callback_data' => "requestvip"]]
                ]
            ])
    ]);
        }
}
if(checkText($text) == "end")
{
    dataBase::setStep($fromId);
        telegram::sendMessage([
        'text' => $LANGUAGE->upload->end,
        'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "back"]]
                ]
            ])
    ]);
}
if(isset($dataCall))
{
    if(preg_match("/requestvip/", $dataCall, $array))
    {
         telegram::answer($LANGUAGE->notVip->text_send);
         telegram::sendMessage([
             'chat_id' => CONFIG['DEV'],
        'text' => "کاربر <a href='tg://user?id=$fromIdCall'>$fromIdCall</a> درخواست ویژه شدن دارن موافقت میکنید؟",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "موافقم", 'callback_data' => "setvip_$fromIdCall"]]
                ]
            ])
    ]);
    }
}
if(dataBase::getStep($fromId) == "upload")
{
    $code = randCode();
                     if(isset($update['message']['photo'])){
                    $ff = $update['message']['photo'];
                    $fileId = $ff[count($ff)-1]['file_id'];
                    dataBase::pushSaveFile($fileId, $code, "photo", $fromId);
                    $txt_send = str_replace("%link", "\nhttps://t.me/".CONFIG['BOT_USERNAME']."?start=$code", $LANGUAGE->upload->text_upload);
                 }
                 if (isset($update['message']['video']))
                 {
                     dataBase::pushSaveFile($fileId, $code, "video", $fromId);
                    $fileId = $update['message']['video']['file_id'];
                   $txt_send = str_replace("%link", "\nhttps://t.me/".CONFIG['BOT_USERNAME']."?start=$code", $LANGUAGE->upload->text_upload);

                 }
                        if(isset($message['animation']))
                        {
                            $fileId = $message['document']['file_id'];
                            dataBase::pushSaveFile($fileId, $code, "document", $fromId);
               $txt_send = str_replace("%link", "\nhttps://t.me/".CONFIG['BOT_USERNAME']."?start=$code", $LANGUAGE->upload->text_upload);
                        }
                        
                        if(isset($txt_send))
                        {
                            telegram::sendMessage([
                        'text' => $txt_send,
                        'disable_web_page_preview' => true,
                        'reply_to_message_id' => $message_id
                       ]);
                        }
}