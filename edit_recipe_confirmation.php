<?php
session_start();

try {

    $db = new PDO('mysql:host=localhost;dbname=my_recipes;charset=utf8', 'root', '');

} catch (Exception $e) {

    die ('Erreur : ' .$e->getMessage());

}

$sqlQuery = 'UPDATE recipes SET title = :title, recipe = :recipe WHERE recipes.recipe_id = :recipe_id';
$recipeStatement = $db->prepare($sqlQuery);
$recipeStatement->execute([
    'title'=>$_POST['title'],
    'recipe'=>$_POST['recipe'],
    'recipe_id'=>$_POST['recipe_id']
]);

$recipe = $recipeStatement->fetch(PDO::FETCH_ASSOC);

echo $_POST['title'];
echo $_POST['recipe'];
echo $_POST['recipe_id'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Edition de Recettes</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <?php include_once('header.php'); ?>

        <p>Recette modifiée !</p>

        <p>Retour à l'<a href="index.php">Accueil</a></p>

    </div>

    <?php include_once('footer.php'); ?>
</body>
</html>
