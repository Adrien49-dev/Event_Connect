<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../Core/PHPMailer-master/src/Exception.php';
require_once '../Core/PHPMailer-master/src/PHPMailer.php';



require_once '../Controllers/Controller.php';



class ContactController extends Controller
{
    /**
     * Afficher le formulaire de contact
     */
    public function showContactFormAction()
    {
        // Affiche la vue du formulaire de contact
        $this->render('formContact');
    }

    /**
     * Traiter l'envoi du formulaire de contact
     */
    public function sendMessageAction()
    {
        // Préparer l'envoi du message
        $mail = new PHPMailer(true);
        // var_dump($mail);

        $nom = (isset($_POST['name'])) ? $_POST['name'] : null;
        $prenom = (isset($_POST['prenom'])) ? $_POST['prenom'] : null;
        $email = (isset($_POST['email'])) ? $_POST['email'] : null;
        $sujet = (isset($_POST['subject'])) ? $_POST['subject'] : null;
        $message = (isset($_POST['message'])) ? $_POST['message'] : null;

        // var_dump($_POST);


        // Validation des données
        if (empty($nom) || empty($prenom) || empty($email) || empty($sujet) || empty($message)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        // Valider le format de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Adresse email invalide.";
            return;
        }

        try {


            //Recipients
            $mail->setFrom('adrien.l129@gmail.com', 'Mailer');
            $mail->addAddress($email);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content

            //Set email format to HTML
            $mail->Subject = $sujet;
            $mail->Body    = $nom . ' ' . $prenom . ' <br><br> ' . 'Son mail :' . ' ' . $email .  '<br><br>' . 'Sujet :' . ' ' . $sujet . '<br><br>' . 'Message:' . ' ' . $message;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            var_dump($mail->Body); // Vérifie le contenu du corps du mail
            var_dump($mail->Subject); // Vérifie le contenu du sujet
            $mail->send();
            echo 'Votre message a bien été envoyé !';
        } catch (Exception $e) {
            echo "Le message n'a pas été envoyé : {$mail->ErrorInfo}";
        }
    }
}
