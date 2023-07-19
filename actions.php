<?php


require '_includes/_database.php';
var_dump($_GET);
var_dump(extract($_GET));

// DELETE
if ($action === "delete") {
    $query = $dbCo->prepare("DELETE FROM transaction WHERE id_transaction = :id");
    $isOk = $query->execute([
        'id' => $id
    ]);
    header("Location: index.php?del_ok");

    // echo json_encode([
    //     'result' => $isOk,
    //     'idTransaction' => $data['idTransaction'],
    //     'notif' => 'del_ok',
    //     'notifTxt' => 'Votre transaction a été supprimée'
    // ]);
    // exit;
}