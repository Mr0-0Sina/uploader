<?php
class telegram
{
   public static function sendRequest(string $method, array $data = []) : array
    {
    $curl = curl_init();
    curl_setopt_array($curl, [
         CURLOPT_URL => "https://api.telegram.org/bot" . CONFIG['TOKEN'] ."/$method",
         CURLOPT_POSTFIELDS => $data,
         CURLOPT_RETURNTRANSFER => true]);
        $result = curl_exec($curl);
        if(!curl_error($curl))
            return json_decode($result, true);
    }
        
    public static function sendMessage(array $data = []) : array
    {
        global $chatId;
         if(!isset($data['chat_id']))
            $data['chat_id'] = $chatId;
                if(!isset($data['parse_mode']))
                    $data['parse_mode'] = "HTML";

               return self::sendRequest("sendMessage", $data);
    }
    public static function editMessage(array $data = []) : array
    {
        global $chatId;
        if(!isset($data['chat_id']))
            $data['chat_id'] = $chatId;

       return self::sendRequest("editMessageText", $data);
    }

    public static function answer(string $txt = null) : array
    {
        global $callId;
        return self::sendRequest("answerCallbackQuery", [
            'callback_query_id' => $callId,
            'text' => $txt,
            'show_alert' => true
        ]);
    }
    public static function checkJoin(string $id = null) : bool
    {
    $get = (CONFIG['CHANNEL_1'] != "") ? self::sendRequest("getChatMember",['chat_id'=> "@".CONFIG['CHANNEL_1'], 'user_id'=> $id])['result']['status'] : false;
    $get2 = (CONFIG['CHANNEL_2'] != "") ?self::sendRequest("getChatMember",['chat_id'=> "@".CONFIG['CHANNEL_2'], 'user_id'=> $id])['result']['status'] : false;
        return ($get == "left" or $get2 == "left")? true : false;
    }
    public static function textJoin() : void
    {
        global $fromId;
        if (self::checkJoin($fromId))
        {
            self::sendMessage([
                            'text' => "لطفا قبل از استفاده از ربات ابتدا در کانال ما عضو شوید \n@". CONFIG['CHANNEL_1']."\t\t@".CONFIG['CHANNEL_2'],
                              'reply_markup' => json_encode([
                                'inline_keyboard' => [
                                    [['text' => "برای عضویت", 'url' => "https://t.me/".CONFIG['CHANNEL_1']]],
                                    [['text' => "برای عضویت", 'url' => "https://t.me/".CONFIG['CHANNEL_2']]],
                                    [['text' => "عضو شدم", 'url' => "https://t.me/".CONFIG['BOT_USERNAME']]],
                                ]
                              ])
                            ]);
                            die(); 
        }
    }
}
