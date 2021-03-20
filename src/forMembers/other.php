<?php
if(checkText($text) == "account") 
{
    $vip = (dataBase::isVip($fromId)) ? "vip" : $LANGUAGE->other->text_vip;
     $txt_send = str_replace(['%href', '%id', '%username', '%vip', '%te'], ["<a href='$fromId'>$fromFirstName</a>", "\t".$fromId, "\n@".$fromUsename, "\t".$vip, "\t".count(dataBase::getHistory($fromId))], $LANGUAGE->other->text_account);
                        telegram::sendMessage([
                        'text' => $txt_send,
                        'reply_to_message_id' => $message_id
                       ]);
    
}
else if(checkText($text) == 'history')
{
    $Result = $LANGUAGE->history->upload."\n";
    $count = 0;
    $check = dataBase::getHistory($fromId);
    if(count($check) != 0){
    foreach($check as $code){
        $Result .= ++$count . "- https://t.me/".CONFIG['BOT_USERNAME']."?start=".$code['code']."\n";
    }
} 
else $Result = $LANGUAGE->history->notUpload;

                  telegram::sendMessage([
                        'text' => $Result,
                        'reply_to_message_id' => $message_id
                       ]);
}