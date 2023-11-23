<!-- index.php -->

<?php
    //start a session
    session_start();

    try
    {
	    $db = new PDO('mysql:host=localhost;dbname=my_recipes;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    //recuperer les recettes valides
    $sqlQuery = 'SELECT * FROM recipes WHERE is_enabled = 1';
    $recipesStatement = $db->prepare($sqlQuery);
    $recipesStatement->execute();
    $recipes = $recipesStatement->fetchAll();

    //recuperer les utilisateurs
    $sqlQuery = 'SELECT * FROM users';
    $usersStatement = $db->prepare($sqlQuery);
    $usersStatement->execute();
    $users = $usersStatement->fetchAll();

    //include some variables and functions
    include_once('functions.php');
    
    //Is the user coming from the connection form
    if (isset($_POST['connection'])) {

        //test if $_POST variables exists
        if (!isset($_POST['email']) || !isset($_POST['password'])) {

            echo 'Une des informations du formulaire de connexion est manquante.';

        } else {

            $email = $_POST['email'];
            $password = $_POST['password'];

            //test if the email and passwords are valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($password) == 0) {

                echo 'l\'email ou le mot de passe est syntaxiquement incorrecte.';

            } else {

                $isEmailValid = false;

                //test if the email and password match an account email and password
                foreach ($users as $user) {

                    if ($email == $user['email'] && !$isEmailValid) {

                        $isEmailValid = true;

                        //test password
                        if ($password == $user['password']) {

                            $_SESSION['loggedUser'] = $user;

                        } else {

                            echo 'Le mot de passe est invalide.';

                        }
                    }
                }

                if (!$isEmailValid) {
                    
                    echo 'L\'email est invalide.';

                }
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <?php include_once('header.php'); ?>

        <?php if (isset($_SESSION['loggedUser'])) : ?>

        <h1> Site de recettes</h1>

        <p>Bienvenue <?php echo htmlspecialchars($_SESSION['loggedUser']['full_name']) ?> !</p>

        <?php foreach($recipes as $recipe) : ?>
            <article>
                <h3><?php echo $recipe['title']; ?></h3>
                <div><?php echo $recipe['recipe']; ?></div>
                <i><?php echo displayAuthor($recipe['author'], $users); ?></i>
                <div style="display: flex; width: 230px; justify-content: space-between;">
                    <div style="border: 1px solid orange; text-align: center; width: 100px;">
                        <a href="edit_recipe.php/?id=<?php echo $recipe['recipe_id']; ?>" style="color: orange; text-decoration: none;">Editer</a>
                    </div>
                    <div style="border: 1px solid red; text-align: center; width: 100px;">                                      
                        <a href="delete_recipe.php/?id=<?php echo $recipe['recipe_id']; ?>" style="color: red; text-decoration: none;">Supprimer</a>
                    </div>
                </div>
            </article>
        <?php endforeach ?>

        <p><a href="submit_recipe.php">Soumettre une recette !</a></p>

        <p><a href='seDeconnecter.php'>Se deconnecter</a></p>
        
        <?php endif ?>

        <!--Connection form-->
        <?php 
            if (!isset($_SESSION['loggedUser'])) {
                include_once('login.php');
            }
        ?>

    </div>

    <!-- inclusion du bas de page du site -->
    <?php include_once('footer.php'); ?>
</body>
</html>
