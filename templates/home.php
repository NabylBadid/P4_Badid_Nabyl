<?php $this->title = 'Accueil'; ?>

<img src="../public/img/acceuil23.jpg" alt="Image d'acceuil" class="img-fluid img-thumbnail"><br />
<div class="container books">
<?php include("showSession.php"); ?>
<?php
foreach ($articles as $article)
        {
            ?>
            <div class="row">
                <div class="col-md-3 imgBook">
                    <img src="../public/img/<?= htmlspecialchars($article->getImgName());?>" class="img-thumbnail">
                </div>
                <div class="col-md-9">
                    <div class="title">
                        <h2><a href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId());?>"><?= htmlspecialchars($article->getTitle());?></a></h2>
                    </div>
                    <hr>
                    <div class="info">
                        <p>écrit par : <?= htmlspecialchars($article->getAuthor());?> | <i class="far fa-clock"></i> <?= htmlspecialchars($article->getCreatedAt());?></p>
                    </div>   
                    <div class="content">
                        <p><?= substr($article->getContent(), 0, 300);?></p>
                    </div>
                <br>
                </div>
            </div>
            <hr>
            <?php
        }
?>

</div>

