<?php


require '_includes/_database.php';
extract($_GET);

// DELETE
if ($action === "delete") {
    $query = $dbCo->prepare("DELETE FROM transaction WHERE id_transaction = :id");
    $isOk = $query->execute([
        'id' => $id
    ]);
    header("Location: index.php?del_ok");
    exit;

}

// UPDATE
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