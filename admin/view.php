<?php
require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

$db = Database::connect();
$statement = $db->prepare('SELECT i.id, i.name, i.price, i.description, i.image, c.name AS category FROM items AS i LEFT JOIN categories AS c ON i.category = c.id 
                        WHERE i.id = :id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$item = $statement->fetch();
Database::disconnect();


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
            <div class="col-sm-6">
                <h1 class="mb-5"><strong>Voir un item</strong></h1>

                <form>
                    <div class="form-group">
                        <label class="form-label my-3">Nom :</label> <?php echo ' ' . $item['name']; ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label my-3">Description :</label> <?php echo ' ' . $item['description']; ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label my-3">Prix :</label> <?php echo ' ' . number_format((float)$item['price'], 2, '.', '').' €'; ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label my-3">Catégorie :</label> <?php echo ' ' . $item['category']; ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label my-3">Image :</label> <?php echo ' ' . $item['image']; ?>
                    </div>
                </form>
                <div class="form-actions">
                    <a href="index.php" class="btn btn-primary mt-5"><i class="fas fa-arrow-left"></i> Retour</a>
                </div>

            </div>

            <div class="col-sm-6 site">
                <div class="img-thumbnail">
                    <img src="<?php echo '../images/' . $item['image'];?>" class="img-fluid" alt="...">
                    <div class="price"><?php echo number_format((float)$item['price'], 2, '.', '') . ' €';?></div>
                    <div class="caption">
                        <h4><?php echo $item['name']; ?></h4>
                        <p><?php echo $item['description']; ?></p>
                        <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span>
                            Commander</a>
                    </div>
                </div>
            </div>
        </div>



    </div>
    </div>
</body>

</html>