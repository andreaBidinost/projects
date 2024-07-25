<?php
$loanHistory = array(
    array(
        "loanId"=>1,
        "startDate" => "2024-01-01",
        "endDate" => "2024-01-10",
        "borrower" => "Mario Rossi",
        "quantity" => 2,
        "lStatus" => 0
    ),
    array(
        "loanId"=>5,
        "startDate" => "2024-02-01",
        "endDate" => "2024-02-15",
        "borrower" => "Giuseppe Verdi",
        "quantity" => 1,
        "lStatus" => 1
    ),
    array(
        "loanId"=>4,
        "startDate" => "2024-03-10",
        "endDate" => "2024-03-20",
        "borrower" => "Paolo Neri",
        "quantity" => 3,
        "lStatus" => 2
    ),
    array(
        "loanId"=>3,
        "startDate" => "2024-04-05",
        "endDate" => "2024-04-15",
        "borrower" => "Anna Verdi",
        "quantity" => 1,
        "lStatus" => 0
    ),
    array(
        "loanId"=>2,
        "startDate" => "2024-05-01",
        "endDate" => "2024-05-10",
        "borrower" => "Luca Neri",
        "quantity" => 2,
        "lStatus" => 1
    )
);

echo json_encode($loanHistory);
?>
