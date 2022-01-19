<?php
require 'database.php';

$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = '';

if (!empty($_POST)) {
    $name = checkInput($_POST['name']);
    $description = checkInput($_POST['description']);
    $price = checkInput($_POST['price']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILES['image']['name']);
    $imagePath = '../images/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;
    $isUploadSuccess = false;

    if (empty($name)) {
        $nameError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($description)) {
        $descriptionError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($price)) {
        $priceError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($category)) {
        $categoryError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($image)) {
        $imageError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    } else {
        $isUploadSuccess = true;
        if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
            $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }
        if (file_exists($imagePath)) {
            $imageError = "Le fichier existe deja";
            $isUploadSuccess = false;
        }
        if ($_FILES["image"]["size"] > 500000) {
            $imageError = "Le fichier ne doit pas depasser les 500KB";
            $isUploadSuccess = false;
        }
        if ($isUploadSuccess) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $imageError = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;
            }
        }
    }

    if($isSuccess && $isUploadSuccess){
        $db = Database::connect();
        $statement = $db->prepare('INSERT INTO items (name, description, price, category, image) VALUES (?,?,?,?,?)');
        $statement->execute(array($name, $description, $price, $category, $image));
        Database::disconnect();
        header("Location: index.php");
    }
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

            <h1 class="mb-5"><strong>Ajouter un item</strong></h1>

            <form class="form" method="post" action="insert.php" role="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label my-3" for="name">Nom :</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                    <span class="help-inline"><?php echo $nameError; ?></span>
                </div>

                <div class="form-group">
                    <label class="form-label my-3" for="description">Description :</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                    <span class="help-inline"><?php echo $descriptionError; ?></span>
                </div>

                <div class="form-group">
                    <label class="form-label my-3" for="price">Prix (en €) :</label>
                    <input type="number" step="0.10" class="form-control" id="price" name="price" placeholder="price" value="<?php echo $price; ?>">
                    <span class="help-inline"><?php echo $priceError; ?></span>
                </div>

                <div class="form-group">
                    <label class="form-label my-3" for="category">Catégorie :</label>
                    <select class="form-control" name="category" id="category">
                        <?php
                        $db = Database::connect();
                        foreach ($db->query('SELECT * FROM categories') as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                        Database::disconnect();
                        ?>
                    </select>
                    <span class="help-inline"><?php echo $categoryError; ?></span>
                </div>

                <div class="form-group">
                    <label class="form-label my-3" for="image">Sélectionner une image :</label>
                    <input type="file" id="image" name="image">
                    <span class="help-inline"><?php echo $imageError; ?></span>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><i class="fas fa-pen"></i>Ajouter</button>
                    <a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Retour</a>
                </div>
            </form>


        </div>
    </div>
</body>

</html>