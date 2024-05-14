<?php
$filename = 'aragorn.txt';
$response  =array();
if (file_exists($filename)) {
    $response[] = array('status'=> true,"loanStatus"=> true);
} else {    
    $response[] = array('status'=> true,"loanStatus"=> false);
}

echo json_encode($response);
?>