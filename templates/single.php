<?php $this->title = 'Article'; ?>

<div class="container single">
    <?php
        if ($article->getImgName() != null) {
            ?>
                <img src="../public/img/<?= htmlspecialchars($article->getImgName());?>" class="img-thumbnail rounded mx-auto d-block"><br />
            <?php
        }
    ?>
    <h2 class="text-center"><em><?= htmlspecialchars($article->getTitle());?></em></h2><br />
    <p class="info"> <i class="far fa-clock"></i> <span class="italic">posté le</span> : <?= htmlspecialchars($article->getCreatedAt());?></p>
    <p><?= $article->getContent();?></p>
    <br>
    <?php
    $sessionPseudo = $this->session->get('pseudo');
    if (isset($sessionPseudo)) {
        include('form_comment.php');
        // $this->session->show('add_comment');
    }
    ?>
    <br /> <h3>Commentaires</h3><br />

    <?php
    $comments = $article->getComments();
    foreach ($comments as $comment) {
        ?>
        <div class="list-group">
            <div class="list-group-item list-group-item-secondary">
                <div class="d-flex w-100 justify-content-between">
                    <h4 class="d-flex justify-content-between"><?= htmlspecialchars($comment->getPseudo()); ?><span class="dateCom"><span class="italic"></h4>
                    <small>posté le</span> : <?= htmlspecialchars($comment->getCreatedAt()); ?></span></small>
                </div>
            </div>
            <div class="list-group-item">
                <p><?= $comment->getContent(); ?></p>
            </div>
            <div class="list-group-item">
                <?php
                if (isset($sessionPseudo)) {
                    ?>
                    <div class="d-flex justify-content-start">
                    <?php
                        if ($comment->getPseudo() !== $sessionPseudo) {
                            if ($comment->isFlag()) {
                                ?>
                                <span class="alert alert-primary flagedCom">Ce commentaire a déjà été signalé</span>
                                <?php
                            } else {
                                ?>
                                    <a href="../public/index.php?route=flagComment&commentId=<?= $comment->getId(); ?>&articleId=<?= $article->getId(); ?>">Signaler le commentaire</a>
                                <?php
                            }
                        } elseif ($comment->isFlag()) {
                            ?>
                                <span class="alert alert-primary flagedCom">Votre commentaire a été signalé</span>
                            <?php
                        } else {
                            ?>
                                <a href="../public/index.php?route=editComment&commentId=<?= $comment->getId(); ?>&articleId=<?= $article->getId(); ?>">Modifier le commentaire</a>
                                <a class="delete" href="../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>&articleId=<?=  $article->getId(); ?>">Supprimer le commentaire</a>
                            <?php
                        } ?>
                    </div>
                <?php
                } ?>
            </div>
        </div>     
    <?php
    } ?>
</div>