<?php

require_once "class/Message.php";
require_once "class/Guestbook.php";


if(isset($_POST['username'],$_POST['message'])){

    $message = new Message($_POST['username'],$_POST['message']);
    $guestbook = new Guestbook(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'messages');
    if($message->isValid()){
      
        $guestbook->addMessage($message);
        $_POST = [];
} else{
    $error = $message->getErrors();
}

$messages = $guestbook->getMessages();
}

?>

<h1>Livre d'or</h1>

<?php if(!empty($error)):?>
    Formulaire invalide
<?php else: ?>
    Merci pour votre commentaire!
    <?php endif ?>
<form action="" method="post">
<input type="text" name="username" value="<?= htmlentities($_POST['username']??"")?>"> </input>
<?php if(isset($errors['username'])):?>
   <p> <?= $errors['username'] ?></p>
    <?php endif?>
<textarea type="text" name="message" value="<?= htmlentities($_POST['message']??"")?>" > </textarea>
<?php if(isset($errors['message'])):?>
    <p>  <?= $errors['message'] ?></p>
    <?php endif?>
<button type="submit">Envoyer votre message</button>
</form>



<?php if(!empty($messages)):?>
    <h1>Vos messages</h1>
    <?php foreach($messages as $message):?>
        <div>
        <?= $message->toHTML(); ?></div>
        <?php endforeach ?>
    <?php endif ?>