<?php
$route = $this->title === 'Connexion' ? 'login' : 'register';
$submit = $route === 'login' ? 'Connexion' : 'Inscription';
$title = $route === 'login' ? 'Connectez-vous' : 'Inscription';
?>



<h1 class="text-center"><u><?= $title ?></u></h1>
<div class="container form-group">
    <form method="post" action="../public/index.php?route=<?= $route; ?>">
        <label for="pseudo">Pseudo</label><br>
        <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= isset($post) ? htmlspecialchars($post->get('pseudo')): ''; ?>"><br>
        <?php
        if(isset($errors['pseudo']))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= isset($errors['pseudo']) ? $errors['pseudo'] : ''; ?>
                </div>  
                <?php
            }
            ?>    
        <label for="password">Mot de passe</label><br>
        <input type="password" class="form-control" id="password" name="password"><br>
        <?php
            if(isset($errors['password']))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= isset($errors['password']) ? $errors['password'] : ''; ?>
                </div>  
                <?php
            }
            ?>    
        <input class="btn btn-secondary" type="submit" value="<?= $submit; ?>" id="submit" name="submit">
        <div class="alert alert-danger" role="alert">
            <?= $this->session->show('error_login'); ?>
        </div>
    </form>
</div>

