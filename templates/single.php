<?php $this->title = 'Article'; ?>
<div class="container single">
    <img src="../public/img/<?= htmlspecialchars($article->getImgName());?>" class="img-thumbnail rounded mx-auto d-block"><br />
    <a class="link" href="../public/index.php"><< Retour à l'accueil</a>
    <h2 class="text-center"><em><u><?= htmlspecialchars($article->getTitle());?></u></em></h2>
    <p class="info"> <i class="far fa-clock"></i> <?= htmlspecialchars($article->getCreatedAt());?></p>
    <p><?= ($article->getContent());?></p>
    <p><?= ($article->getContent());?></p>
    <br>
    <h3>Ajouter un commentaire</h3>
    <?php include('form_comment.php'); ?>
    <h3>Commentaires</h3>
    <?php
    foreach ($comments as $comment)
    {
        ?>
        <h4><?= htmlspecialchars($comment->getPseudo());?></h4>
        <p><?= htmlspecialchars($comment->getContent());?></p>
        <p>Posté le <?= htmlspecialchars($comment->getCreatedAt());?></p>
        <?php
        if($comment->isFlag()) {
            ?>
            <p>Ce commentaire a déjà été signalé</p>
            <?php
        } else {
            ?>
            <p><a href="../public/index.php?route=flagComment&commentId=<?= $comment->getId(); ?>">Signaler le commentaire</a></p>
            <?php
        }
        ?>
        <p><a href="../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>">Supprimer le commentaire</a></p>
        <br>
        <?php
    }
    ?>
</div>
