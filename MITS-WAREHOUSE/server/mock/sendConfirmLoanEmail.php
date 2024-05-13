<?php
$FROMEMAIL = '"itsloan" <itsloan@itsmalignani.it>';
$TOEMAIL = "andrea.millenovecentonovanta@gmail.com";
$PLAINTEXT = "TEST";
$ORGANIZATION = "itsMalignani";

// Basic headers
$headers = "From: " . $FROMEMAIL . "\n";
$headers .= "Reply-To: " . $FROMEMAIL . "\n";
$headers .= "Return-path: " . $FROMEMAIL . "\n";
$headers .= "X-Mailer: Your Website\n";
$headers .= "Organization: " . $ORGANIZATION . "\n";
$headers .= "MIME-Version: 1.0\n";

// Add content type (plain text encoded in quoted printable, in this example)
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

// Create a BASE64 encoded subject
$subject = "=?UTF-8?B?" . base64_encode("TEST ITS LOAN") . "?=";

// Send email
mail($TOEMAIL, $subject, $PLAINTEXT, $headers, "-f" . $FROMEMAIL);

/*
try {
    $to = "andrea.millenovecentonovanta@gmail.com";
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
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <mitsLoan@itsmalignani.it>' . "\r\n";

    mail($to, $subject, $message, $headers);
} catch (Exception $e) {
    echo "" . $e->getMessage() . "";
}*/

$response = array('status' => 'success', 'borrowerMail' => 'andrea.millenovecentonovanta@gmail.com', 'newLoanid' => 99);
echo json_encode($response);
?>