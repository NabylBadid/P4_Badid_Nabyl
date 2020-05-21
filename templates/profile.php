<?php $this->title = 'Mon profil'; ?>
<h1>Profil</h1>
<?= $this->session->show('update_password'); ?>
<div class="container profile">
    <h2>Bienvenue <?= $this->session->get('pseudo'); ?></h2><br />
    <h3>Les commentaires que vous avez posté :</h3><br />
    
    <?php
    // var_dump($comments);
    foreach ($comments as $comment)
    {
        ?>
        <div class="comments">
            <!-- <hr class="com"> -->
            <h4 class="d-flex justify-content-between titleCom"><?= htmlspecialchars($comment->getPseudo());?><span class="dateCom"><?= htmlspecialchars($comment->getCreatedAt());?></span></h4>
            <p><?= $comment->getContent(); ?></p>
            <!-- <hr class="com"> -->
        </div>
        <?php
    }
    ?>
    <a class="btn btn-primary" href="../public/index.php?route=updatePassword">Modifier son mot de passe</a>
    <a class="btn btn-primary" href="../public/index.php?route=deleteAccount">Supprimer mon compte</a>
</div>
<br>
