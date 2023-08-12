<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=CRUD_PHP_MYSQL_GIT_GITHUB', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$errors = [];
$nom_projet = '';
$nombre_membre = '';
$nom_groupe = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_projet = $_POST['nom_projet']; //test
    $nom_groupe = $_POST['nom_groupe'];
    $nombre_membre = $_POST['nombre_membre'];



    if (!$nom_projet) {
        $errors[] = 'projet nom_projet is required';
    }
    if (!$nombre_membre) {
        $errors[] = 'projet nombre_membre  is required';
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {

        $image = $_FILES['image']  ?? null;
        $imagePath = '';


        if ($image  && $image['tmp_name']) {

            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        $statement = $pdo->prepare("INSERT INTO projet (nom_projet,image,nom_groupe,nombre_membre)
              VALUES(:nom_projet,:image,:nom_groupe,:nombre_membre)
    ");
        $statement->bindValue(':nom_projet', $nom_projet);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':nom_groupe', $nom_groupe);
        $statement->bindValue(':nombre_membre', $nombre_membre);
        $produitCreer = $statement;
        $statement->execute();
        header('Location: index.php');
    }
}

function randomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" integrity="sha384-PJsj/BTMqILvmcej7ulplguok8ag4xFTPryRq8xevL7eBYSmpXKcbNVuy+P0RMgq" crossorigin="anonymous">

    <!-----my-css-------->
    <link rel="stylesheet" href="app.css">
    <title>Creer un nouveau projet</title>
</head>

<body>
    <h1>Create New Projet</h1>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) : ?>
                <div>
                    <?php echo $error ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nom projet</label>
            <input type="text" class="form-control" name="nom_projet" value="<?php echo $nom_projet ?>">
        </div>

        <div class="mb-3">
            <label>Choisisez une image qui illustre le projet</label>
            <br>
            <input type="file" name="image">
        </div>



        <div class="mb-3">
            <label>Nom du groupe qui realise le projet </label>
            <textarea type="text" name="nom_groupe" class="form-control"> </textarea>
        </div>

        <div class="mb-3">
            <label>Nombre de membre du groupe qui realise le projet </label>
            <input type="number" name="nombre_membre" step=".01" value="<?php echo $nombre_membre ?>" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Creer</button>
    </form>
</body>

</html>