<?php 
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=CRUD_PHP_MYSQL_GIT_GITHUB', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit; 
}

$statement = $pdo->prepare('DELETE FROM projet WHERE id = :id');
$statement -> bindValue(':id',$id);
$statement-> execute();
header("Location: index.php");
//echo'<pre>';
//var_dump($id);
//echo'</pre>';
?>