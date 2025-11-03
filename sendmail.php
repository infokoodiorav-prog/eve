<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer6.12.0/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer-6.12.0/src/SMTP.php';
require __DIR__ . '/../PHPMailer-6.12.0/src/Exception.php';

$tulemus_msg = "";
$success = null;

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
        <h2>Hinnapäring</h2>
        <p><strong>Nimi:</strong> $nimi</p>
        <p><strong>E-post:</strong> $email</p>
        <p><strong>Telefon:</strong> $telefon</p>
        <p><strong>Teema:</strong> $teema</p>
        <p><strong>Sõnum:</strong><br>$sonum</p>
        ";

        $mail->AltBody = "Nimi: $nimi\nE-post: $email\nTelefon: $telefon\nTeema: $teema\nSõnum:\n$sonum";
        $mail->send();
        $success = true;
        $tulemus_msg = "✔️ Sinu sõnum on edukalt saadetud.<br>Võtame Sinuga esimesel võimalusel ühendust.<br>Aitäh!";
    } catch (Exception $e) {
        $success = false;
        $tulemus_msg = "❌ Sõnumit ei saadetud. Viga: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Kontaktvorm</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f4f4f4; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
        }

        .message-box {
            padding:1,5rem;
            border: 2px solid #28a745;
            background-color: #e0e0e0;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            color: #333;
            max-width: 600px;
            min-width: 300px;    
            font-size: 16px;
            margin: 2rem auto;
            line-height: 1.5;
        }

        .message-box p {
            margin: 10px 0;
        }

        .back-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #218838;
        }
        @media (max-width: 600px) {
    .message-box {
        font-size: 20px;       /* suurem tekst telefonis */
        padding: 25px;
    }
}
    </style>
</head>
<body>

<?php if ($success !== null): ?>
    <div class="message-box">
        <?= $tulemus_msg ?>
        <br>
        <button class="back-btn" onclick="window.history.back();">← Tagasi</button>
    </div>
<?php endif; ?>

</body>
</html>


