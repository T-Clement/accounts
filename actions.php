<?php


require '_includes/_database.php';
// var_dump($_GET);
// var_dump(extract($_GET));
extract($_GET);

// DELETE
if ($action === "delete") {
    $query = $dbCo->prepare("DELETE FROM transaction WHERE id_transaction = :id");
    $isOk = $query->execute([
        'id' => $id
    ]);
    header("Location: index.php?del_ok");
    exit;






    // echo json_encode([
    //     'result' => $isOk,
    //     'idTransaction' => $data['idTransaction'],
    //     'notif' => 'del_ok',
    //     'notifTxt' => 'Votre transaction a été supprimée'
    // ]);
}


if ($action == "update") {
    extract($_POST);
  
    $query = $dbCo->prepare("
    UPDATE transaction 
    SET name = :name,
    date_transaction = :date,
    amount = :amount
    WHERE id_transaction = :id");
    $isOk = $query->execute([
        'id'=> intval($id),
        'name' => $name,
        'date'=> $date,
        'amount'=> $amount
    ]);
    header("Location: index.php?notif=update_ok");
    exit;
}