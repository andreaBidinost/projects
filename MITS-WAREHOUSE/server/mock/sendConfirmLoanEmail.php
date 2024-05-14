<?php
require 'server/PHPMailer/src/PHPMailer.php';
require 'server/PHPMailer/src/SMTP.php';
require 'server/PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->Timeout = 10;
$mail->SMTPAuth   = true;
$mail->Username = 'andrea.bidinost@itsmalignani.it';
$mail->Password = 'AndBid37!!';
$mail->SetFrom('andrea.bidinost@itsmalignani.it', 'MITS Gestione Prestiti');
$mail->addAddress('andrea.millenovecentonovanta@gmail.com', 'Andrea Bidi');
//$mail->SMTPDebug  = 3;
//$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";}; //$mail->Debugoutput = 'echo';
$mail->IsHTML(true);

$mail->Subject = 'MITS - Conferma presa in carico materiale';
$mail->Body    = "
<html>
<body>
<h1>Presa in carico di materiale MITS</h1>
</h3>Lista materiale dato in prestito a Andrea Bidinost:
<ol>
<li>Display Waveshare 7 pollici</li>
</ol>
</h3>
<p>Controlla lo stato del materiale una volta ricevuto e segnala immediatamente eventuali anomalie.</p>
<p>Gli eventuali allegati alla presente email ti aiuteranno a controllare lo stato dei materiali</p>
<div style='text-align:center; width:100%;background-color:yellow'>
<p>Clicca il seguente link per confermare la presa in carico del materiale.</p>
<a href='https://" . $_SERVER['SERVER_NAME'] . "/server/mock/confirmNewLoan.php?id=99&borrowerId=" . $_POST['borrowerId'] . "'>Conferma presa in carico per </a>
</div>
</body>
</html>
";

$response = array();

if(!$mail->send()) {
    $response[] = array('status' => 'failure', 'error' => json_encode($mail->ErrorInfo));
} else {
    $response[] = array('status' => 'success', 'borrowerMail' => 'andrea.millenovecentonovanta@gmail.com', 'newLoanid' => 99);
}

echo json_encode($response);
/*
$subject = "MITS - Conferma presa in carico materiale";
$message = "
<html>
<body>
<h1>Presa in carico di materiale MITS</h1>
</h3>Lista materiale dato in prestito a Andrea Bidinost:
<ol>
<li>Display Waveshare 7 pollici</li>
</ol>
</h3>
<p>Controlla lo stato del materiale una volta ricevuto e segnala immediatamente eventuali anomalie.</p>
<p>Gli eventuali allegati alla presente email ti aiuteranno a controllare lo stato dei materiali</p>
<div style='text-align:center; width:100%;background-color:yellow'>
<p>Clicca il seguente link per confermare la presa in carico del materiale.</p>
<a href='https://" . $_SERVER['SERVER_NAME'] . "/server/mock/confirmNewLoan.php?id=99&borrowerId=" . $_POST['borrowerId'] . "'>Conferma presa in carico per </a>
</div>
</body>
</html>
";

// Always set content-type when sending HTML email


*/
?>