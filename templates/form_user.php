<?php
$route = $this->title === 'Connexion' ? 'login' : 'register';
$submit = $route === 'login' ? 'Connexion' : 'Inscription';
$title = $route === 'login' ? 'Connectez-vous' : 'Inscription';
$error_login = $this->session->get('error_login');
$show_error = $this->title === 'Connexion' && !empty($error_login) ? '<div class="alert alert-danger" role="alert">' . $error_login . '</div>': ''; 
?>

<h1 class="text-center"><?= $title ?></h1>
<div class="container form-group">
    <form method="post" action="../public/index.php?route=<?= $route; ?>">
        <label for="pseudo">Pseudo</label><br>
        <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= isset($post) ? htmlspecialchars($post->get('pseudo')): ''; ?>"><br />
        <?= isset($errors['pseudo']) ? '<div class="alert alert-danger" role="alert">' . $errors['pseudo'] . '</div>': ''; ?>  
        <label for="password">Mot de passe</label><br>
        <input type="password" class="form-control" id="password" name="password"><br />
        <?= isset($errors['password']) ? '<div class="alert alert-danger" role="alert">' . $errors['password'] . '</div>': ''; ?>  
        <input class="btn btn-secondary" type="submit" value="<?= $submit; ?>" id="submit" name="submit"><br>
        <?= $show_error ?>
    </form>
</div>








