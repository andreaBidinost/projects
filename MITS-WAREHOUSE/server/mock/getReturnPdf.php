<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo "Only POST requests are allowed.";
    exit;
}

// Path to the PDF file on the server
$pdfFilePath = "../../docs/0A1FD_Return.pdf";

// Check if the file exists
if (!file_exists($pdfFilePath)) {
    // If the file does not exist, send a 404 response
    http_response_code(404);
    echo "File not found.";
    exit;
}

// Set headers to force download
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($pdfFilePath) . '"');
header('Content-Length: ' . filesize($pdfFilePath));

readfile($pdfFilePath);

?>