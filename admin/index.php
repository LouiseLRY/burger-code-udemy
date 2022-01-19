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
            <h1><strong>Liste des items</strong><a href="insert.php" class="btn btn-success btn-lg ms-4"><i class="fas fa-plus me-2"></i>Ajouter</a></h1>

            <!-- Tableau -->

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'database.php';
                    $db = Database::connect();
                    $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC');
                    while($item = $statement->fetch()){

                        echo '<tr>';
                        echo '<td>' . $item['name'] . '</td>';
                        echo '<td>' . $item['description'] . '</td>';
                        echo '<td>' . number_format((float)$item['price'], 2, '.', '') . '</td>';
                        echo '<td>' . $item['category'] . '</td>';
                        echo '<td width=400>';
                        echo '<a href="view.php?id=' . $item['id'] . '" class="btn btn-outline-dark my-1 my-lg-0 me-2"><i class="fas fa-eye me-1"></i>Voir</a>';
                        echo '<a href="update.php?id=' . $item['id'] . '" class="btn btn-primary my-1 my-lg-0 me-2"><i class="fas fa-pen me-1"></i> Modifier</a>';
                        echo '<a href="delete.php?id=' . $item['id'] . '" class="btn btn-danger my-1 my-lg-0"><i class="fas fa-times me-1"></i>Supprimer</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    Database::disconnect();

                    ?>

                </tbody>
            </table>


        </div>
    </div>
</body>

</html>