<?php
if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || 
    !isset($_POST['message']) || empty($_POST['message'])) {
    echo 'Un des parametres ou les deux sont manquants ou incorrectes, retournez au formulaire pour recommencer.';

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
