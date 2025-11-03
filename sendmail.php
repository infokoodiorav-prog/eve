<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer6.12.0/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer-6.12.0/src/SMTP.php';
require __DIR__ . '/../PHPMailer-6.12.0/src/Exception.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nimi    = htmlspecialchars($_POST['Nimi'] ?? '');
    $email   = filter_var($_POST['E-mail'] ?? '', FILTER_SANITIZE_EMAIL);
    $telefon = htmlspecialchars($_POST['Telefon'] ?? '');
    $teema   = htmlspecialchars($_POST['teema'] ?? '');
    $sonum   = htmlspecialchars($_POST['Message'] ?? '');

    $mail = new PHPMailer(true);
     $mail->CharSet = 'UTF-8';
    $mail->Subject = "Kodulehe päring";

     try {
        // SMTP seaded Zone.ee mailboxi jaoks
        $mail->isSMTP();
        $mail->Host       = 'localhost';    // Zone.ee SMTP server
        $mail->SMTPAuth   = false;
   
        $mail->Port       = 25;

        // Saatja ja vastuse aadressid
        $mail->setFrom('no-reply@koodiorav.eu', 'Hinnapäring');
        $mail->addAddress('aivarnurme73@gmail.com'); // klient saab kirja
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mail->addReplyTo($email, $nimi);
}       // kui vastatakse, läheb külastaja aadressile
        $mail->isHTML(true);
$mail->Body = "
<h2>Kodulehe päring</h2>
<p><strong>Nimi:</strong> $nimi</p>
<p><strong>E-post:</strong> $email</p>
<p><strong>Telefon:</strong> $telefon</p>
<p><strong>Teema:</strong> $teema</p>
<p><strong>Sõnum:</strong><br>$sonum</p>
";

$mail->AltBody = "Nimi: $nimi\nE-post: $email\nTelefon: $telefon\nTeema: $teema\nSõnum:\n$sonum";
        $mail->send();
        echo "Sõnum on saadetud!";
    } catch (Exception $e) {
        echo "Sõnumit ei saadetud. Viga: {$mail->ErrorInfo}";
    }
}
?>

