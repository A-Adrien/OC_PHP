<!-- index.php -->

<?php
    //include some variables and functions
    include_once('variables.php');
    include_once('functions.php');

    // Is connected ?
    $isConnected = false;
    
    //Is the user coming from the connection form
    if (isset($_POST['connection'])) {

        //test if $_POST variables exists
        if (!isset($_POST['email']) || !isset($_POST['password'])) {

            echo 'Une des informations du formulaire de connexion est manquante.';
            $isConnected = false;

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

                            $isConnected = true;
                            $loggedUser = $user;

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

        <?php if ($isConnected == true) : ?>

        <h1> Site de recettes</h1>

        <p>Bienvenue <?php echo $loggedUser['full_name'] ?> !</p>

        <?php foreach(getRecipes($recipes) as $recipe) : ?>
            <article>
                <h3><?php echo $recipe['title']; ?></h3>
                <div><?php echo $recipe['recipe']; ?></div>
                <i><?php echo displayAuthor($recipe['author'], $users); ?></i>
            </article>
        <?php endforeach ?>
        
        <?php endif ?>

        <!--Connection form-->
        <?php 
            if ($isConnected == false) {
                include_once('login.php');
            }
        ?>

    </div>

    <!-- inclusion du bas de page du site -->
    <?php include_once('footer.php'); ?>
</body>
</html>
