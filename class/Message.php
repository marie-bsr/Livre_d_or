<?php

class Message{
    const LIMIT_USERNAME= 3;
    const LIMIT_MESSAGE = 10;
    private $username;
    private $message;
    private $date;


 public function __construct(string $username,string $message,?Datetime $date= null)
 {
    $this->username = $username;
    $this->message = $message;
    $this->date = $date?:new DateTime(); 
 }

 public function isValid():bool{
  
    return empty($this->getErrors());
 }

 public function getErrors():array{
     $errors=[];
     if(strlen(htmlentities($this->username))< self::LIMIT_USERNAME){
         $errors['username'] = "votre pseudo est trop court";
     }if(strlen(htmlentities($this->message))< self::LIMIT_MESSAGE){
        $errors['message'] = "votre message est trop court";
    }
    return $errors;
 }

 public function toHTML(): string{
     $username = htmlentities($this->username);
     $message = htmlentities($this->message);
      //on met une timezone qui nous arrange
      $this->date->setTimeZone(new DateTimeZone('Europe/Paris'));
     $date = $this->date->format('d/m/y à H:i');
     
           
return 
"<p> <strong> {$username}</strong><em>{$date}</em>
{$message}
</p>"
;
 }

 public function toJSON():string{
    return json_encode( [
         'username' => $this->username,
         'message' => $this->message,
         'date' => $this->date->getTimestamp()
     ]);
 }

}