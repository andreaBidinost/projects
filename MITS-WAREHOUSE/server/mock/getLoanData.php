<?php
//Se arriva loanId o se arriva borrowerid+productid
echo json_encode(array('status' => "success",
 'qty' =>1, 
 'startDate'=>'2024-05-15', 
 'endDate'=>'2024-05-17',
 'responsibleName'=>'Responsabile n.3',
 "borrower" => "Giuseppe Verdi",
 'lStatus'=>1,
 'loanId' => 888));
?>