<?php
session_start();

try {

    $db = new PDO('mysql:host=localhost;dbname=my_recipes;charset=utf8', 'root', '');

} catch (Exception $e) {

    die('Erreur : ' .$e->getMessage());

}

//recuperer la recette
$sqlQuery = 'SELECT * FROM recipes WHERE recipe_id = :recipe_id';
$recipeStatement = $db->prepare($sqlQuery);
$recipeStatement->execute([
    'recipe_id'=>$_GET['id'],
]);
$recipe = $recipeStatement->fetchAll();
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
        <h1>Edition <?php echo $recipe[0]['title']; ?></h1>
        <form action="../edit_recipe_confirmation.php" method="POST">
            <label for="recipe_id">Identifiant recette</label>
            <input type="hidden" name="recipe_id" value="<?php $_GET['id']?>">
            <div class="mb-3">
                <label for="title" class="form-label">Titre de la recette</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="mb-3">
                <label for="recipe" class="form-label">La recette</label>
                <textarea class="form-control" placeholder="Commencer par casser des oeufs..." name="recipe"></textarea>
            </div>
            <div class="mb-3">
                <label for="is_enabled" class="form-label">is_enabled</label>
                <input type="checkbox"  name="is_enabled">
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        <br />
    </div>

    <?php include_once('footer.php'); ?>
</body>
</html>
