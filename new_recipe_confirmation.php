<?php
session_start();

echo 'Bonjour ' .$_SESSION['loggedUser']['full_name']. '.</br>';

$countGood = 0;
if (!isset($_POST['is_enabled'])) {$countGood++;}

foreach ($_POST as $property => $value) {

    if (!empty($_POST[$property])) {

        $countGood++;

    }

}

if ($countGood == 3) {

    echo 'c\'est bon !';

} else {

    echo 'Quelque chose ne va pas...';
    return;

}

$title = $_POST['title'];
$recipe = $_POST['recipe'];
$author = $_SESSION['loggedUser']['email'];
if (isset($_POST['is_enabled']) && $_POST['is_enabled'] == 'on') {$is_enabled = 1;} else {$is_enabled = 0;}

try {

    $db = new PDO('mysql:host=localhost;dbname=my_recipes', 'root', '');

} catch (Exception $e) {

    die('Erreur : ' .$e->getMessage());

}

$mysqlQuery = 'INSERT INTO recipes (title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)';

$insertRecipe = $db->prepare($mysqlQuery);

$insertRecipe->execute([
    'title'=>$title,
    'recipe'=>$recipe,
    'author'=>$author,
    'is_enabled'=>1]);

?>
