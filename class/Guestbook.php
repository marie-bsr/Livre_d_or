<?php
require_once "Message.php";

class Guestbook
{

    public $file;

    public function __construct(string $file)
    {
        $directory = dirname($file);
        //si le dossier n'existe pas, on le créé avec mkdir
        //si le fichier dans le dossier n'existe pas, on le créé avec touch
        //quand tout cela est ok on initialise avec le fichier passé en paramètre
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        if (!file_exists($file)) {
            touch($file);
        }
        $this->file = $file;
    }

    public function addMessage(Message $message)
    {
        
            file_put_contents($this->file, $message->toJSON().PHP_EOL, FILE_APPEND);
        
    }

    public function getMessages(): array
    {
      //la derniere ligne des messages est tjs vide donc on la supprime avec trim
        $content = trim(file_get_contents($this->file)); 
    //on découpe le tableau content en plusieurs lignes, le separateur étant le saut de ligne
        $lines = explode(PHP_EOL, $content);
        $messages =[];
        foreach( $lines as $line){
            $data = json_decode($line, true);
            
            $messages[] = new Message($data['username'], $data['message'], new DateTime("@". $data['date']));
        }
        return array_reverse($messages);
    }
}
