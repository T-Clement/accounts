<?php require '_includes/_database.php'?>
<?php require '_includes/_header.php'?>
<?php
session_start();
if (!(array_key_exists('HTTP_REFERER', $_SERVER)) && str_contains($_SERVER['HTTP_REFERER'], $_ENV["URL"])) {
    header('Location: index.php?msg=error_referer');
    exit;
}

// else if ($_SESSION['token'] !== $_REQUEST["token"]) {
//     // var_dump($_SESSION['token'], $_REQUEST['token']);
//     header('Location: index.php?msg=error_csrf');
//     exit;
// }


if(!empty($_POST)) {
    $query = $dbCo->prepare("INSERT INTO transaction (name, amount, date_transaction, id_category) VALUES (:name, :amount, :date_transaction, :category)");
    $isOk = $query->execute([
        'name'=> trim(strip_tags($_POST['name'])),
        'amount'=> intval(trim(strip_tags($_POST['amount']))),
        'date_transaction'=> $_POST['date'],
        'category'=> $_POST['category']
    ]);
    if(!$isOk) {
        header('Location: index.php?notif=add_error');
    } else {
        header('Location: index.php?notif=add_ok');
    }
    var_dump($isOk);
}

?>
    <?php 
    $formOperationTitle = "Ajouter une opération";
    $formValidation = "Ajouter";
    $formCssClass = "";
    $formLink = "add.php";
    ?>


    <div class="container">
        <?php require '_includes/_form.php'?>
    </div>

    <?php require '_includes/_footer.php'?>