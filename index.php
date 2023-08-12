<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=CRUD_PHP_MYSQL_GIT_GITHUB', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$search = $_GET['search'] ?? '';
if ($search) {
  $statement = $pdo->prepare('SELECT * FROM projet WHERE nom_projet LIKE :nom_projet ORDER BY id DESC');
  $statement->bindValue(':nom_projet', "%$search%");
} else {
  $statement = $pdo->prepare('SELECT * FROM projet ORDER BY id DESC');
}

$statement->execute();
$projets = $statement->fetchAll(PDO::FETCH_ASSOC);



?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" integrity="sha384-PJsj/BTMqILvmcej7ulplguok8ag4xFTPryRq8xevL7eBYSmpXKcbNVuy+P0RMgq" crossorigin="anonymous">

  <!-----my-css--
  <link rel="stylesheet" href="app.css">------>
  <title>Product CRUD</title>
</head>


<body>
  <h1>Projet CRUD</h1>
  <p>
    <a href="create.php" class="btn btn-success"> Create Projet</a>
  </p>

  <form>
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search for Projet" name="search" value="<?php echo $search ?>">
      <button class="btn btn-outline-secondary" type="submit">Search</button>
    </div>
  </form>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Nom projet</th>
        <th scope="col">Nom group</th>
        <th scope="col">Nombre membre groupe</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($projets as $i => $projet) : ?>
        <tr>
          <th scope="row">
            <?php echo $i + 1 ?>
          </th>
          <td>
            <img style="width: 50px;" src="images/4EGD0JKK/airBnB MVP.PNG" alt="">
            <!---- <img class="thumb-image" src="<?php echo $projet['image'] ?>"> --->
          </td>
          <td>
            <?php echo $projet['nom_projet'] ?>
          </td>
          <td>
            <?php echo $projet['nom_groupe'] ?>
          </td>
          <td>
            <?php echo $projet['nombre_membre'] ?>
          </td>
          <td>
            <a href="update.php?id=<?php echo $product['id'] ?>" type="button" class="btn btn-sm btn-outline-primary">Edite</a>
            <form action="delete.php" method="post" style="display:inline-block">
              <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
              <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>

</html>