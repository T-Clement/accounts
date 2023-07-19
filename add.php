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
    require '_includes/_form.php'
    ?>
    <!-- <div class="container">
        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h1 class="my-0 fw-normal fs-4">Ajouter une opération</h1>
            </div>
            <div class="card-body">
                <form action="add.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'opération *</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Facture d'électricité" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date *</label>
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Montant *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="amount" id="amount" required>
                            <span class="input-group-text">€</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Catégorie</label>
                        <select class="form-select" name="category" id="category">
                            <option value="" selected>Aucune catégorie</option>
                            <option value="1">Nourriture</option>
                            <option value="2">Loisir</option>
                            <option value="3">Travail</option>
                            <option value="4">Voyage</option>
                            <option value="5">Sport</option>
                            <option value="6">Habitat</option>
                            <option value="7">Cadeaux</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Ajouter</button>
                    </div>
                </form>
            </div>
        </section>
    </div> -->
    <script src="script.js"></script>
    <?php require '_includes/_footer.php'?>