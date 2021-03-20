<?php
require_once 'vars.php';
       function randCode(){
        $txt = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
        $l = null;
        $str = str_split($txt);
        for($i = 1; $i <= 8; $i++){
        $l .= $str[array_rand($str)];
        }
        return $l;
        }
        function checkText($txt)
        {
            if(in_array($txt, ['back', 'برگشت']))
            return "back";
            elseif(in_array($txt, ['Account', 'حساب کاربری']))
            return "account";
             elseif(in_array($txt, ['upload file', 'اپلود فایل']))
            return "upload";
             elseif(in_array($txt, ['upload history', 'تاریخچه اپلود']))
            return "history";
             elseif(in_array($txt, ["Select Language", 'انتخاب زبان']))
            return "Select Language";
             elseif(in_array($txt, ['end', 'اتمام']))
            return 'end';
             elseif(in_array($txt, ['panel', 'پنل']))
            return 'panel';
             elseif(in_array($txt, ['ارسال همگانی', 'send all']))
            return 'sendall';
             elseif(in_array($txt, ['فوروارد همگانی', 'forward all']))
            return 'forall';
        }
