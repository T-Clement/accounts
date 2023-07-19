<?php
require '_includes/_database.php';

session_start();
header('Content-Type:application/json');
$data = json_decode(file_get_contents('php://input'), true);
$isOk = false;

// DELETE
if ($data["action"] === "delete") {
    $query = $dbCo->prepare("DELETE FROM transaction WHERE id_transaction = :id");
    $isOk = $query->execute([
        'id' => $data['idTransaction']
    ]);

    echo json_encode([
        'result' => $isOk,
        'idTransaction' => $data['idTransaction'],
        'notif' => 'del_ok',
        'notifTxt' => 'Votre transaction a été supprimée'
    ]);
    exit;
}

// UPDATE ACCOUNT AMOUNT 
if($data["action"] === "getTotalAmount") {
    $query = $dbCo->prepare("SELECT SUM(amount) AS 'account_amount' FROM transaction WHERE DATE_FORMAT(date_transaction, '%Y-%m') <= DATE_FORMAT(NOW(), '%Y-%m')");
    $isOk = $query->execute();
    $accountAmount = $query->fetch();

    echo json_encode([
        'result'=>$isOk,
        'amount'=> $accountAmount
    ]);
    exit;
}
