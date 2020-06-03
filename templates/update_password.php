<?php $this->title = 'Modifier mot mot de passe'; ?>

<div class="container">
    <h1 class="text-center">Modifier votre mot de passe</h1>

    <p>Le mot de passe de <span class="badge badge-pill"><?= $this->session->get('pseudo'); ?></span> sera modifié.</p>
    <form class="form-group" method="post" action="../public/index.php?route=updatePassword">
        <label for="password">Nouveau mot de passe</label><br>
        <input class="form-control" type="password" id="password" name="password"><br>
        <input class="btn btn-secondary" type="submit" value="Mettre à jour" id="submit" name="submit">
    </form>
    <a class="link" href="../public/index.php?route=profile"><< Retour à votre profil</a>
</div>
<br>
