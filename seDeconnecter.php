<?php

session_start();

if (isset($_SESSION['loggedUser'])) {

    if (session_destroy()) {

        echo '<p>Vous avez bien été déconnecté.</p>';
        echo 'Aurevoir ' .$_SESSION['loggedUser']['full_name'];

    } else {

        echo 'Vous n\'avez pas été déconnecté !';

    }
}

echo '<a href=\'index.php\'>Home</a>';

?>
