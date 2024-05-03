<?php
// Connessione al database e altre operazioni necessarie

$users = array();
$i = 0;
while ($i < 5) {

    $users[] = array('id' => $i, 'name' => "User n." . $i);
    $i++;
}
echo json_encode($users);
?>