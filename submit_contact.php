<?php
if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || 
    !isset($_POST['message']) || empty($_POST['message'])) {
    echo 'Un des parametres ou les deux sont manquants ou incorrectes, retournez au formulaire pour recommencer.';

    return;
}
//verification fichier
if ($_FILES['screenshot']['error'] != 4 && $_FILES['screenshot']['error'] == 0) {

    if ($_FILES['screenshot']['size'] <= 1000000) {

        $fileInfo = pathinfo($_FILES['screenshot']['name']);
        $extension = $fileInfo['extension'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($extension, $allowedExtensions)) {
            
            move_uploaded_file($_FILES['screenshot']['tmp_name'], 'uploads/' .$_FILES['screenshot']['name']);
            echo 'Le fichier a bien été envoyé !';

        } else {
            echo 'Le fichier n\'est pas dans une bonne extension (jpg, jpeg, png, gif).';
            return;
        }

    } else {
        echo 'Votre fichier est trop volumineux. Il ne doit pas être supérieur à 1 Mo.';
        return;
    }

} else {
    echo 'Une erreur s\'est produite avec votre fichier (' .$_FILES['screenshot']['error']. ').';
    return;
}
?>

<h1>Message bien reçu !</h1>
        
<div class="card">
    
    <div class="card-body">
        <h5 class="card-title">Rappel de vos informations</h5>
        <p class="card-text"><b>Email</b> : <?php echo htmlspecialchars($_POST['email']); ?></p>
        <p class="card-text"><b>Message</b> : <?php echo htmlspecialchars($_POST['message']); ?></p>
    </div>
</div>
