<?php

namespace Autoriko\Utils;

use Autoriko\Utils\Writer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail{

  private $c;
  private $response;

  public $from = [];
  public $to = [];
  public $subject = '';
  public $content = '';
  public $content_no_html = '';
  public $replyTo = [];
  public $attachment = [];

  public function __construct($response, $c, array $from, array $to, $subject = null, $content = null, $content_no_html = null, array $replyTo = null, array $attachment = null){
    $this->c = $c;
    $this->response = $response;
    $this->from = $from;
    $this->to = $to;
    $this->subject = $subject;
    $this->content = $content;
    $this->content_no_html = $content_no_html;
    $this->replyTo = $replyTo;
    $this->attachment = $attachment;
  }

  public function makeHtmlMail($title, $content){
    $head = $this->makeHeadHtml();
    $header = $this->makeBodyHeaderHtml($title);
    $body = $content;
    $footer = $this->makeBodyFooterHtml();

    $html = <<<EOT
<!DOCTYPE html>
<html>
<head>
{$head}
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
  <!-- HIDDEN PREHEADER TEXT -->
  <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We're thrilled to have you here! Get ready to dive into your new account. </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
{$header}
{$body}
{$footer}
  </table>
</body>

</html>
EOT;
    return $html;
  }

  public function makeHeadHtml(){
    $html = <<<EOT
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <style type="text/css">
      @media screen {
          @font-face {
              font-family: 'Lato';
              font-style: normal;
              font-weight: 400;
              src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
          }

          @font-face {
              font-family: 'Lato';
              font-style: normal;
              font-weight: 700;
              src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
          }

          @font-face {
              font-family: 'Lato';
              font-style: italic;
              font-weight: 400;
              src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
          }

          @font-face {
              font-family: 'Lato';
              font-style: italic;
              font-weight: 700;
              src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
          }
      }

      /* CLIENT-SPECIFIC STYLES */
      body,
      table,
      td,
      a {
          -webkit-text-size-adjust: 100%;
          -ms-text-size-adjust: 100%;
      }

      .linear-bg-header{
        background: rgb(170,27,187);
        background: linear-gradient(90deg, rgba(170,27,187,1) 0%, rgba(123,45,215,1) 35%, rgba(43,69,238,1) 100%);
      }

      .linear-bg-footer{
        background: rgb(170,27,187);
        background: linear-gradient(90deg, rgba(170,27,187,0.8) 0%, rgba(123,45,215,0.8) 35%, rgba(43,69,238,0.8) 100%);
      }

      table,
      td {
          mso-table-lspace: 0pt;
          mso-table-rspace: 0pt;
      }

      img {
          -ms-interpolation-mode: bicubic;
      }

      /* RESET STYLES */
      img {
          border: 0;
          height: auto;
          line-height: 100%;
          outline: none;
          text-decoration: none;
      }

      table {
          border-collapse: collapse !important;
      }

      body {
          height: 100% !important;
          margin: 0 !important;
          padding: 0 !important;
          width: 100% !important;
      }

      /* iOS BLUE LINKS */
      a[x-apple-data-detectors] {
          color: inherit !important;
          text-decoration: none !important;
          font-size: inherit !important;
          font-family: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
      }

      /* MOBILE STYLES */
      @media screen and (max-width:600px) {
          h1 {
              font-size: 32px !important;
              line-height: 32px !important;
          }
      }

      /* ANDROID CENTER FIX */
      div[style*="margin: 16px 0;"] {
          margin: 0 !important;
      }
  </style>
</head>
EOT;
    return $html;
  }

  public function makeBodyHeaderHtml($title){
    $html = <<<EOT
      <tr>
          <td class="linear-bg-header" align="center">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                      <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                  </tr>
              </table>
          </td>
      </tr>
      <tr>
          <td class="linear-bg-header" align="center" style="padding: 0px 10px 0px 10px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                      <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 0px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                          <img src="cid:logo_enchereauto" style="display: block; border: 0px; padding-bottom: 20px; width: 175px;" />
                          <hr class="linear-bg-header" style="margin-bottom: 30px;">
                          <h1 style="font-size: 36px; font-weight: 400;">{$title}</h1>
                      </td>
                  </tr>
              </table>
          </td>
      </tr>
EOT;
    return $html;
  }

  public function makeBodyFooterHtml(){
    //$link_contact_page = "https://www.enchereauto.fr/contact";
    $frontoffice_link = $this->c['settings']['frontoffice'];
    $link_contact_page = $frontoffice_link . "/contact";
    $html = <<<EOT
      <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <tr>
                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                    <p style="margin: 0;">Bien à vous,<br>L'équipe <b>Autoriko</b></p>
                </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
          <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                      <td class="linear-bg-footer" align="center" style="padding: 20px 20px 20px 20px; border-radius: 4px 4px 4px 4px; color: #ffffff; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <h2 style="font-size: 16px; font-weight: 400; color: #ffffff; margin: 0;">Une question ?</h2>
                          <p style="margin: 0; font-size: 12px;"><a href="{$link_contact_page}" target="_blank" style="color: #ffffff;">On est là pour vous aider</a></p>
                      </td>
                  </tr>
              </table>
          </td>
      </tr>
  </table>
EOT;
    return $html;
  }

  public function makeConfirmMail($link, $hour_limit_confirm_mail){
    $link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link;
    $this->subject = "Confirmation mail - Autoriko.fr";
    $html = <<<EOT
      <tr>
          <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <p style="margin: 0;">Nous sommes heureux de vous avoir parmi nous. Veuillez appuyer sur le bouton ci-dessous pour confirmer votre inscription.</p>
                      </td>
                  </tr>
                  <tr>
                      <td bgcolor="#ffffff" align="left">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                  <td bgcolor="#ffffff" align="center" style="padding: 5px 30px 45px 30px;">
                                      <table border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                              <td align="center" style="border-radius: 3px;" bgcolor="#8925c8"><a href="{$link}" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #8925c8; display: inline-block;">Confirmer mon inscription</a></td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                          </table>
                      </td>
                  </tr> <!-- COPY -->
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <p style="margin: 0;">Si le bouton ne fonctionne pas, veuillez essayer le lien ci-dessous ou le copier/coller dans un nouvel onglet :</p>
                      </td>
                  </tr> <!-- COPY -->
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; max-width: 100%;">
                          <p style="margin: 0;max-width:500px;overflow-wrap: break-word;"><a href="{$link}" target="_blank" style="color: #aa1abb;">{$link}</a></p>
                      </td>
                  </tr>
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <p style="margin: 0;">Vous avez {$hour_limit_confirm_mail} heure(s) pour confirmer votre inscription, au delà de ce délais le lien de validation ci dessus ne sera plus fonctionnelle. Si vous n'êtes pas l'auteur de cette inscription ou ne souhaitez plus confirmer votre compte, ignorez cet e-mail.</p>
                      </td>
                  </tr>
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <p style="margin: 0;">Merci de ne pas répondre à cet e-mail.</p>
                      </td>
                  </tr>
              </table>
          </td>
      </tr>
EOT;
    $mail = $this->makeHtmlMail("Bienvenue !", $html);
    $this->content = $mail;
  }

  public function makeResetPasswordMail($link, $hour_limit_reset_password){
    $link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link;
    $this->subject = "Réinitialisation mot de passe perdu - Autoriko.fr";
    $html = <<<EOT
      <tr>
          <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <p style="margin: 0;">Vous avez fait une demande de réinitialisation de votre mot de passe. Veuillez appuyer sur le bouton ci-dessous pour être redirigé vers la page de modification de mot de passe perdu.</p>
                      </td>
                  </tr>
                  <tr>
                      <td bgcolor="#ffffff" align="left">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                  <td bgcolor="#ffffff" align="center" style="padding: 5px 30px 45px 30px;">
                                      <table border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                              <td align="center" style="border-radius: 3px;" bgcolor="#8925c8"><a href="{$link}" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #8925c8; display: inline-block;">Changer mon mot de passe</a></td>
                                          </tr>
                                      </table>
                                  </td>
                              </tr>
                          </table>
                      </td>
                  </tr> <!-- COPY -->
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <p style="margin: 0;">Si le bouton ne fonctionne pas, veuillez essayer le lien ci-dessous ou le copier/coller dans un nouvel onglet :</p>
                      </td>
                  </tr> <!-- COPY -->
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400;">
                          <p style="margin: 0;max-width:500px;overflow-wrap: break-word;"><a href="{$link}" target="_blank" style="color: #aa1abb;">{$link}</a></p>
                      </td>
                  </tr>
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <p style="margin: 0;">Vous avez {$hour_limit_reset_password} heure(s) pour modifier votre mot de passe, au delà de ce délais le lien de modification de mot de passe ci dessus ne sera plus fonctionnelle. Si vous n'êtes pas l'auteur de cette inscription ou ne souhaitez plus changer votre mot de passe, ignorez ce mail.</p>
                      </td>
                  </tr>
                  <tr>
                      <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                          <p style="margin: 0;">Merci de ne pas répondre à cet mail.</p>
                      </td>
                  </tr>
              </table>
          </td>
      </tr>
EOT;
    $mail = $this->makeHtmlMail("Mot de passe oublié", $html);
    $this->content = $mail;
  }

  public function makeContactFormMail($message, $lastname, $firstname, $phone_number){
    $this->subject = "Réception formulaire de contact - Autoriko.fr";
    $html = <<<EOT
    <!DOCTYPE html>
    <html>
      <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      </head>
      <body>
        <h3>Un utilisateur a envoyé une demande depuis le formulaire de contact :</h3>
        <hr>
        <p><u>Adresse mail</u> : {$this->from['mail']}</p>
        <p><u>Nom</u> : {$lastname}</p>
        <p><u>Prénom</u> : {$firstname}</p>
        <p><u>Numéro de téléphone</u> : {$phone_number}</p>
        <hr>
        <p><u>Message</u> : {$message}</p>
      </body>
    </html>
EOT;
    $this->content = $html;
  }

  public function send_mail(){
    $mail = new PHPMailer(true);
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPOptions = array(
          'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
          )
        );
        $mail->isSMTP();//Send using SMTP
        $mail->Host = gethostbyname('maildev');//Set the SMTP server
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;
        $mail->Port = 25;//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet = 'UTF-8';

        $mail->AddEmbeddedImage('assets/img/logo_enchereauto.png', 'logo_enchereauto');

        //Recipients
        $mail->setFrom($this->from['mail'], $this->from['name']);

        //To
        if(sizeof($this->to) > 0){
          foreach ($this->to as $mail_address => $name) {
            $mail->addAddress($mail_address, $name);
          }
        }else{
          return false;
        }

        //Reply To
        if($this->replyTo != null){
          foreach ($this->replyTo as $mail_address => $name) {
            $mail->addReplyTo($mail_address, $name);
          }
        }

        //Attachments
        if($this->attachment != null){
          foreach ($this->attachment as $name => $lien) {
            $mail->addAttachment($lien, $name);
          }
        }

        //Content
        $mail->isHTML(true);

        if($this->subject)
          $mail->Subject = $this->subject;
        else
          return false;

        if($this->content)
          $mail->Body    = $this->content;
        else
          return false;

        //plain text for non-HTML mail clients
        if($this->content_no_html)
          $mail->AltBody = $this->content_no_html;

        $mail->send();
        return true;
      } catch (\Exception $e) {
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($this->response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
  }
}
