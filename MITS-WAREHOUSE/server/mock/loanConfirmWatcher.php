<?php
$filename = 'aragorn.txt';
$response  =array();
if (file_exists($filename)) {
    echo "The file $filename exists";
    $response[] = array('status'=> true,"loanStatus"=> true);
} else {
    echo "The file $filename does not exist";
    
    $response[] = array('status'=> true,"loanStatus"=> false);
}

echo json_encode($response);
?>