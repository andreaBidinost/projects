<?php

$responsibles = array();
$i = 0;
while ($i < 3) {

    $responsibles[] = array('id' => $i, 'name' => "Resp n." . $i);
    $i++;
}


// Restituisci l'elenco dei responsabili come dati JSON
echo json_encode($responsibles);
?>