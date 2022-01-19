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
    <link rel="stylesheet" href="css/style.css">
    <title>Burger Code</title>
</head>

<body>
    <div class="container site">
        <h1 class="text-logo">
            <i class="fas fa-utensils"></i> Burger Code <i class="fas fa-utensils"></i>
        </h1>

        <?php
        require 'admin/database.php';
        echo ' <nav>
                 <ul class="nav nav-pills" role="tablist">';
        $db = Database::connect();
        $statement = $db->query('SELECT * FROM categories');
        $categories = $statement->fetchAll();
        foreach ($categories as $category) {
            if ($category['id'] == '1') {
                echo ' <li role="presentation" class="nav-item">
                <a role="tab" class="nav-link active" aria-current="page" data-bs-toggle="pill" data-bs-target="#tab' . $category['id'] . '">' . $category['name'] . '</a>
            </li>';
            } else {
                echo ' <li role="presentation" class="nav-item">
                <a role="tab" class="nav-link" aria-current="page" data-bs-toggle="pill" data-bs-target="#tab' . $category['id'] . '">' . $category['name'] . '</a>
            </li>';
            }
        }

        echo '</ul>
        </nav>';

        echo '<div class="tab-content">';
        foreach ($categories as $category) {
            if ($category['id'] == '1') {
                echo ' <div class="tab-pane active" id="tab' . $category['id'] . '" role="tabpanel">';
            } else {
                echo ' <div class="tab-pane" id="tab' . $category['id'] . '" role="tabpanel">';
            }

            echo ' <div class="row">';

            $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
            $statement->execute(array($category['id']));

            while ($item = $statement->fetch()) {
                echo '<div class="col-md-6 col-lg-4">
                <div class="img-thumbnail">
                    <img src="images/' . $item['image'] . '" class="img-fluid" alt="...">
                    <div class="price">' . number_format($item['price'], 2, '.', '') . '</div>
                    <div class="caption">
                        <h4>' . $item['name'] . '</h4>
                        <p>' . $item['description'] . '</p>
                        <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span>
                            Commander</a>
                    </div>
                </div>
            </div>';
            }

            echo '   </div>
            </div>';
        }

        Database::disconnect();

        echo '</div>';

        ?>


    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>