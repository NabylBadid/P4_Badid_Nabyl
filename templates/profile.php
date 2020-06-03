<?php $this->title = 'Mon profil'; ?>
<h1>Profil</h1>
<div class="container profile">
    <?= $this->session->show('update_password'); ?>
    <h2>Bienvenue <?= $this->session->get('pseudo'); ?></h2><br />
    <h3>Les commentaires que vous avez posté :</h3><br />
    
<?php
    foreach ($comments as $comment) {
        ?>
        <div class="list-group">
            <div class="list-group-item list-group-item-secondary">
                <div class="d-flex w-100 justify-content-between">
                    <h4 class="d-flex justify-content-between titleCom"><?= htmlspecialchars($comment->getPseudo()); ?><span class="dateCom"></h4>
                    <small><span class="italic">posté le</span> : <?= htmlspecialchars($comment->getCreatedAt()); ?></span></small>
                </div>
            </div>
            <div class="list-group-item">
                <p><?= $comment->getContent(); ?></p>
            </div>
            <div class="list-group-item">
                <p><a href="../public/index.php?route=article&articleId=<?= $comment->getArticleId(); ?>"><< Lien vers l'article</a></p>
            </div>
        </div>
        <?php
    }
    ?>
    <a class="btn btn-primary" href="../public/index.php?route=updatePassword">Modifier mon mot de passe</a>
    <a class="btn btn-primary" href="../public/index.php?route=deleteAccount">Supprimer mon compte</a>
</div>
<br>