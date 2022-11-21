<?php
if(isset($_POST["nameSender"]) && isset($_POST["mailSender"]) && isset($_POST['subject']) && isset($_POST['message']) && isset($_POST['verifNb1']) && isset($_POST['verifNb2']) && isset($_POST['verifRep'])){
    if(($_POST['verifNb1'] + $_POST['verifNb2']) == $_POST['verifRep']){

        $_POST["nameSender"] = filter_var($_POST["nameSender"],FILTER_SANITIZE_STRING);
        $_POST["mailSender"] = filter_var($_POST["mailSender"],FILTER_VALIDATE_EMAIL);
        $_POST['subject'] = filter_var($_POST['subject'],FILTER_SANITIZE_STRING);
        $_POST['message'] = filter_var($_POST['message'],FILTER_SANITIZE_STRING);

        if(!$_POST["nameSender"] || !$_POST["mailSender"] || !$_POST['subject'] || !$_POST['message']){
            $error_msg = 'Un ou plusieurs champs saisie sont incorrects, veuillez vérifier : ';
            if(!$_POST["nameSender"]){
                $error_msg .= "<br>- votre nom";
            }
            if(!$_POST["mailSender"]){
                $error_msg .= "<br>- votre adresse mail";
            }
            if(!$_POST['subject']){
                $error_msg .= "<br>- le sujet du message";
            }
            if(!$_POST['message']){
                $error_msg .= "<br>- votre message";
            }
            echo '<span style="color: #865757">Erreur rencontrée : '.$error_msg.'<br><br>Veuillez réessayer ou me contacter via mon adresse mail : portaro.lucas@gmail.com si le problème persiste.</span>';
        }
        else{
            $message = "
            <html>
                <body style='font-family: Arial,Helvetica,sans-serif;'>
                    <h2>Message envoyé par : <b>{$_POST["nameSender"]}</b> (mail: {$_POST["mailSender"]})</h2>
                    <h3>Sujet : {$_POST['subject']}</h3>
                    <br>
                    <u>Contenu du message :</u>
                    <p>{$_POST['message']}</p>
                    <br>
                    <br>
                    <h5>Message envoyé depuis <a href=\"http://portarolucas.fr\" target=\"_blank\">portarolucas.fr</a></h5>
                </body>
            </html>
            ";

            $header = "MIME-Version: 1.0\r\n";
            $header .= 'Content-type: text/html; charset="utf-8"';

            $success = mail('portaro.lucas@gmail.com', 'portarolucas.fr | MESSAGE', $message, $header);
            if (!$success) {
                echo '<span style="color: #865757">Erreur rencontrée : '.error_get_last()['message']."<br>Veuillez réessayer ou me contacter via mon adresse mail : portaro.lucas@gmail.com si le problème persiste.</span>";
            }
            else{
                echo '<span style="color: #206522; text-transform: uppercase;">Votre message a bien été envoyé.</span>';
            }
        }
    }
    else{
        echo '<span style="color: #865757">Erreur rencontrée : Champs de vérification invalide.<br>Veuillez réessayer ou me contacter via mon adresse mail : portaro.lucas@gmail.com si le problème persiste.</span>';
    }
}
else{
    echo '<span style="color: #865757">Erreur rencontrée : Des champs sont manquants, incomplets ou invalides.<br>Veuillez réessayer ou me contacter via mon adresse mail : portaro.lucas@gmail.com si le problème persiste.</span>';
}
?>