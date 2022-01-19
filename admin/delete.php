<?php
require 'database.php';

if(!empty($_GET['id'])){
    $id = checkInput($_GET['id']);
}

if(!empty($_POST)){
    $id = checkInput($_POST['id']);
    $db = Database::connect();
    $statement = $db->prepare('DELETE FROM items WHERE id = ?');
    $statement->execute(array($id));
    Database::disconnect();
    header('Location: index.php');
}


function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8455767180.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Burger Code</title>
</head>

<body>
    <h1 class="text-logo">
        <i class="fas fa-utensils"></i> Burger Code <i class="fas fa-utensils"></i>
    </h1>

    <div class="container admin">
        <div class="row">

            <h1 class="mb-5"><strong>Supprimer un item</strong></h1>
            <br>

            <form class="form" method="post" action="delete.php" role="form">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <p class="alert alert-warning mb-4">Etes-vous sûr de vouloir supprimer ? </p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-warning"></i>Oui</button>
                    <a href="index.php" class="btn btn-outline-secondary"></i> Non</a>
                </div>
            </form>


        </div>
    </div>
</body>

</html>