<?php $this->title = 'Accueil'; ?>
<div class="img">
    <img src="../public/img/acceuil23.jpg" alt="Image d'acceuil" class="img-fluid img-thumbnail"><br />
</div>

<div class="test">
    <?php
echo $this->session->show('register');
echo $this->session->show('login');
echo $this->session->show('logout');
echo $this->session->show('error_404');
echo $this->session->show('error_500');
    ?>
</div>

<div class="container books">
<?php
foreach ($articles as $article) {
        ?>
            <div class="row">
                <div class="col-md-3 imgBook">
                    <img src="../public/img/<?= htmlspecialchars($article->getImgName()); ?>" class="img-thumbnail">
                </div>
                <div class="col-md-9">
                    <div class="title">
                        <h2 class="linkHome"><a href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId()); ?>"><?= htmlspecialchars($article->getTitle()); ?></a></h2>
                    </div>
                    <hr>
                    <div class="info">
                        <p><span class="italic">écrit par </span> : <?= htmlspecialchars($article->getPseudo()); ?> | <span class="italic">posté le</span> : <i class="far fa-clock"></i> <?= htmlspecialchars($article->getCreatedAt()); ?></p>
                    </div>   
                    <div class="content">
                        <p><?= substr($article->getContent(), 0, 300); ?></p>
                    </div>
                <br>
                </div>
            </div>
            <hr>
            <?php
    }
?>

</div>

