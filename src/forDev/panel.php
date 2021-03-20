<?php
if($fromId == CONFIG['DEV'])
{
if(checkText($text) == 'panel')
{
            $txt = $LANGUAGE->panel->keyboard->one;
        $txt2 = $LANGUAGE->panel->keyboard->two;
     telegram::sendMessage([
        'text' => $LANGUAGE->panel->text,
        'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "$txt2"], ['text' => "$txt"]],
                [['text' => "back"]],
                ]
            ])
    ]);
}
if(checkText($text) == 'back')
{
    dataBase::setStep(CONFIG['DEV'], "null");
}
if(checkText($text) == 'sendall')
{
    dataBase::setStep(CONFIG['DEV'], "sendall");
     telegram::sendMessage([
        'text' => $LANGUAGE->panel->sendall->text,
        'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "back"]],
                ]
            ])
    ]);
}
if(checkText($text) == 'forall')
{
    dataBase::setStep(CONFIG['DEV'], "forall");
     telegram::sendMessage([
        'text' => $LANGUAGE->panel->forall->text,
          'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "back"]],
                ]
            ])
    ]);
}
$step = dataBase::getStep(CONFIG['DEV']);
if(($step == 'sendall' or $step == 'forall') and checkText($text) != 'forall' and checkText($text) != 'sendall')
{
    $user = dataBase::getUsers();
    foreach($user as $id):
         telegram::sendMessage([
        'text' => $LANGUAGE->panel->anjam
    ]);
        if($step == 'sendall')
        {
             telegram::sendMessage([
                 'chat_id' => $id['id'],
                        'text' => $text,
                       ]);
        }
         else if($step == 'forall')
         {
             telegram::sendRequest("forwardMessage", [
'chat_id' => $id['id'], 
 "from_chat_id"=> $chatId,
 "message_id" => $messageId
]);
         }
        endforeach;
        $txt = $LANGUAGE->panel->keyboard->one;
        $txt2 = $LANGUAGE->panel->keyboard->two;
        telegram::sendMessage([
        'text' => $LANGUAGE->panel->anjamend,
        'reply_markup' => json_encode([
            'keyboard' => [
                [['text' => "$txt2"], ['text' => "$txt"]],
                [['text' => "back"]],
                ]
            ])
    ]);
    dataBase::setStep(CONFIG['DEV'], "null");
}
}