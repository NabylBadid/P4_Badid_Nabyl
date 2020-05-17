<?php $this->title = 'Article'; ?>
<div class="container single">
    <img src="../public/img/<?= htmlspecialchars($article->getImgName());?>" class="img-thumbnail rounded mx-auto d-block"><br />
    <h2 class="text-center"><em><?= htmlspecialchars($article->getTitle());?></em></h2><br />
    <p class="info"> <i class="far fa-clock"></i> <?= htmlspecialchars($article->getCreatedAt());?></p>
    <p><?= ($article->getContent());?></p>
    <br>
    <?php 
    include('form_comment.php');
    include('showSession.php');
    ?>
    <br /> <h3>Commentaires</h3><br />

    <?php
    foreach ($comments as $comment)
    {
        ?>
        <hr class="com">
        <h4 class="d-flex justify-content-between"><?= htmlspecialchars($comment->getPseudo());?><span class="dateCom"><?= htmlspecialchars($comment->getCreatedAt());?></span></h4>
        <p><?= $comment->getContent(); ?></p>
        <?php
        $sessionPseudo = $this->session->get('pseudo');
        if (isset($sessionPseudo))
        {
            ?>
            <div class="d-flex justify-content-start">
            <?php
                if ($comment->isFlag()) {
                    ?>
                    <span class="alert alert-primary">Ce commentaire a déjà été signalé</span>
                    <?php
                } else {
                    ?>
                    <p><a class="btn btn-primary btn-sm" href="../public/index.php?route=flagComment&commentId=<?= $comment->getId(); ?>">Signaler le commentaire</a></p>
                    <?php
                }
            if ($comment->getPseudo() === $sessionPseudo) {
                ?>
                    <p class="buttonCom"><a class="btn btn-primary btn-sm" href="../public/index.php?route=editComment&commentId=<?= $comment->getId(); ?>&articleId=<?= $article->getId(); ?>">Modifier le commentaire</a></p>
                    <p class="buttonCom"><a class="btn btn-primary btn-sm" href="../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>&articleId=<?=  $article->getId(); ?>">Supprimer le commentaire</a></p>
                    <?php
            } ?>
            </div>
        <hr class="com">
        <?php
        }
    }
    ?>
</div>
