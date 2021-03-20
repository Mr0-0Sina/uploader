<?php
try{
$pdo = new PDO(
    CONFIG['DB_TYPE'].":host=".
        CONFIG['DB_SERVER'].";dbname=".
            CONFIG['DB_NAME'],
                 CONFIG['DB_USERNAME'],
                     CONFIG['DB_PASSWORD']
                    );
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e) {
    die($e);
  }
class dataBase
{
    public static function checkDataBase() : void
    {
        global $pdo;
        try{
            $st = $pdo->prepare("SELECT * FROM user");
            $st->execute();
     } catch(PDOException $e) {
         if(strpos($e, "not found") !== false){
   $sql = "CREATE TABLE user (
    id INT(20) UNSIGNED  PRIMARY KEY,
    step VARCHAR(100) NOT NULL,
    vip VARCHAR(100) NOT NULL,
    lang VARCHAR(100) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
}
  }
  try{
  $st = $pdo->prepare("SELECT * FROM files");
            $st->execute();
     } catch(PDOException $e2) {
         if(strpos($e2, "not found") !== false){
   $sql = "CREATE TABLE files (
    file_id VARCHAR(500) NOT NULL,
    code VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    sender VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
         }
  }
    }
    public static function pushSaveFile(string $fileId = null, string $code = null, string $type = null, string $sender = null) : void
    {
        try{
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO files (file_id, code, type, sender)
        VALUES (:file_id, :code, :type, :sender)");
        $stmt->bindParam(':file_id', $file_id);
        $stmt->bindParam(':code', $coded);
        $stmt->bindParam(':type', $typee);
        $stmt->bindParam(':sender', $send);
        $file_id = $fileId;
        $coded = $code;
        $typee = $type;
        $send = $sender;
        $stmt->execute();
        }catch(PDOException $e) {
            telegram::sendMessage([
                        'text' => $e,
                        'disable_web_page_preview' => true
                       ]);
        }
    }
    public static function checkUser(string $id = null) : bool
    {
        global $pdo;
        $st = $pdo->prepare("SELECT * FROM user WHERE id='$id' LIMIT 1");
         $st->execute();
             if(count($st->fetchAll()) == 0)
                 return false;
                    else 
                     return true;
    }
    public static function insertUser(string $id = null)
    {
        global $pdo;
         if(! self::checkUser($id))
         {
             $st = $pdo->prepare("INSERT INTO user (id, step, vip, lang) VALUES (:id, :step,:vip, :lang)");
             $st->bindParam(":id", $fid);
             $st->bindParam(":step", $step);
             $st->bindParam(":vip", $vip);
             $st->bindParam(":lang", $lang);
             $fid = $id;
             $step = "null";
             $vip = "false";
             $lang = "persian";
             $st->execute();
         }
    }
     public static function isVip(string $id = null) : bool
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id='$id'");
        $stmt->execute();
            if($stmt->fetchAll()[0]["vip"] == "false")
            return false;
                else
                    return true;
    }
   public static function getLang(string $id = null) : string
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id='$id'");
        $stmt->execute();
            return $stmt->fetchAll()[0]["lang"];
    }
     public static function setLang(string $id = null, string $lang = null) : void
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE user SET lang='$lang' WHERE id=$id");
        $stmt->execute();
    }
     public static function setVip(string $id = null, string $Vip = "true") : void
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE user SET vip='$Vip' WHERE id=$id");
        $stmt->execute();
    }
    public static function setStep(string $id = null, string $step = "null") : void
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE user SET step='$step' WHERE id=$id");
        $stmt->execute();
    }
    public static function getStep(string $id = null) : string
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id='$id'");
        $stmt->execute();
            return $stmt->fetchAll()[0]["step"];
    }
public static function getHistory(string $id = null) : array
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT code FROM files WHERE sender='$id'");
        $stmt->execute();
            return $stmt->fetchAll();
    }
    public static function getUsers() : array
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM user");
        $stmt->execute();
            return $stmt->fetchAll();
    }
    public static function pullFileId(string $code = null)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM files WHERE code='$code'");
        $stmt->execute();
            return $stmt->fetchAll()[0]['file_id'];
    }
    public static function pullType(string $code = null)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM files WHERE code='$code'");
        $stmt->execute();
            return $stmt->fetchAll()[0]['type'];
    }
}
