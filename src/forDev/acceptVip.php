<?php

if(isset($dataCall) and $fromIdCall == CONFIG['DEV'])
{
    if(preg_match("/setvip_(.*)/", $dataCall, $array))
    {
        $id = $array[1];
        dataBase::setVip($id);
        telegram::answer("با ویژه شدن $id موافقت شد");
        telegram::sendMessage([
             'chat_id' => $id,
        'text' => $LANGUAGE->setVip->text
    ]);
    }
}