<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nimi    = $_POST['Nimi'] ?? '';
    $email   = $_POST['E-mail'] ?? '';
    $telefon = $_POST['Telefon'] ?? '';
    $teema   = $_POST['teema'] ?? '';
    $sonum   = $_POST['Message'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // SMTP seaded Zone.ee mailboxi jaoks
        $mail->isSMTP();
        $mail->Host       = 'smtp.zone.ee';    // Zone.ee SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'no-reply@koodiorav.eu'; // mailboxi kasutajanimi
        $mail->Password   = 'seFs8u4JDjW8Zkv';       // mailboxi parool
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Saatja ja vastuse aadressid
        $mail->setFrom('no-reply@koodiorav.eu', 'Kodulehe päring');
        $mail->addAddress('marttiorav@gmail.com'); // klient saab kirja
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mail->addReplyTo($email, $nimi);
}       // kui vastatakse, läheb külastaja aadressile

        // Kirja sisu
        $mail->Subject = $teema;
        $mail->Body    = "Nimi: $nimi\nE-post: $email\nTelefon: $telefon\n\nSõnum:\n$sonum";

        $mail->send();
        echo "Sõnum on saadetud!";
    } catch (Exception $e) {
        echo "Sõnumit ei saadetud. Viga: {$mail->ErrorInfo}";
    }
}
?>

