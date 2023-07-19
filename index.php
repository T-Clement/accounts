<?php
try {
    $fileContent = file_get_contents("notifs.json");
    $notifs = json_decode($fileContent, true);
} catch (Exception $e) {
    echo "Something went wrong with json file...";
    exit;
}


require '_includes/_database.php';
require '_includes/_functions.php';
// var_dump($_ENV);

session_start();
$token = md5(uniqid(mt_rand(), true));
$_SESSION['token'] = $token;


// id_transaction, name, amount, date_transaction, id_category

date_default_timezone_set('Europe/Paris');

$date = new DateTime();
// var_dump($date);



// get all the transactions from the current month
$query = $dbCo->prepare("SELECT * 
FROM transaction
	LEFT JOIN category USING (id_category)
WHERE date_transaction LIKE :current_month
ORDER BY date_transaction DESC");
$isOk = $query->execute([
    "current_month" => $date->format("Y-m").'%'
]);
$transactionsMonths = $query->fetchAll();
// var_dump($transactionsMonths);

$query = $dbCo->prepare("SELECT SUM(amount) AS 'account_amount' FROM transaction WHERE DATE_FORMAT(date_transaction, '%Y-%m') <= DATE_FORMAT(NOW(), '%Y-%m')");
$isOk = $query->execute();
$accountAmount = $query->fetch();


//------------------------------------------------------------------
//------------------------------------------------------------------
//------------------------------------------------------------------
$notifData = [];
if (isset($_GET["notif"])) {
    foreach ($notifs as $notification) {
        $notificationKey = $notification['notification_key'];
        $notificationText = $notification['notification_txt'];
        if ($notificationKey == $_GET["notif"]) {
                $notifData[$notificationKey] = $notificationText;
                break;
            } else {
                // var_dump("Aucune correspondance");
            }
        }
    }
    
//------------------------------------------------------------------
//------------------------------------------------------------------
//------------------------------------------------------------------
//------------------------------------------------------------------

?>

<?php require '_includes/_header.php'?>

    <div class="container">
        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h2 class="my-0 fw-normal fs-4">Solde aujourd'hui</h2>
            </div>
            <div class="card-body">
                <p class="card-title pricing-card-title text-center fs-1"><span class="js-account-amount"><?=implode($accountAmount)?></span> €</p>
            </div>
        </section>
        <div id="notif" class="notif">
            <?php
            if (isset($_GET["notif"])) {
                $cssClassNotif = array_search($notifData[$_GET["notif"]], $notifData);
                echo "<p class='notif-style $cssClassNotif active  js-notif'>" . $notifData[$_GET["notif"]] . "</p>";
            }
            ?>
        </div>
        

        <?php
        $formOperationTitle = "Modifier une opération";
        $formValidation = "Enregistrer la modification";
        $formCssClass = "form-update js-update-form";
        $formLink = "actions.php?action=update";
        require '_includes/_form.php';
        ?>
         


        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h1 class="my-0 fw-normal fs-4">Opérations de Juillet 2023</h1>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">Opération</th>
                            <th scope="col" class="text-end">Montant</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($transactionsMonths as $transaction) {
                            $dateTransaction = new DateTime($transaction["date_transaction"]);
                            echo '<tr class="js-transaction-row" data-category="'. $transaction["category_name"] .'">
                                    
                                    <td width="50" class="ps-3">
                                        <i class="bi bi-' . $transaction["icon_class"] .' fs-3"></i>
                                    </td>
                                    <td>
                                        <time datetime="' . $dateTransaction->format("Y-m-d") . '" class="d-block fst-italic fw-light js-operation-date">' . $dateTransaction->format("d-m-Y") . '</time>
                                        <span class="js-operation-txt">' . $transaction['name'] . '</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="rounded-pill text-nowrap js-operation-amount ' . applyColorToOperation($transaction["amount"]) . ' px-2 js-transaction-amount" data-id="' . $transaction["id_transaction"] . '">
                                            '. $transaction['amount'] .'
                                        </span>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <a class="btn btn-outline-primary btn-sm rounded-circle js-update" data-id="' . $transaction["id_transaction"] . '">
                                            <i class="bi bi-pencil"></i>
                                        </a>';
                                        echo '<a href="actions.php?action=delete&id='. $transaction["id_transaction"].'" class="btn btn-outline-danger btn-sm rounded-circle js-delete" data-id="'. $transaction["id_transaction"] .'">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav class="text-center">
                    <ul class="pagination d-flex justify-content-center m-2">
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="bi bi-arrow-left"></i>
                            </span>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">Juillet 2023</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.html">Juin 2023</a>
                        </li>
                        <li class="page-item">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.html">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </div>
    <script src="script.js"></script>
    <?php require '_includes/_footer.php'?>