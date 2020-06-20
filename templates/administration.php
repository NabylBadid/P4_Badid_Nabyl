<?php
$this->title = 'Administration';
$confirmed = $this->session->get('accesAdmin');
$title = !empty($confirmed) ? 'Administration' : 'Accès à l\'espace d\'administration';

if ($confirmed !== null) {
    ?>
    <h1 class="text-center"><?= $title ?></h1>
    <div class="container">
        <?php
        // include('showSession.php');
        
        // $arraySession = array(
        //     $this->session->show('add_article'),
        //     $this->session->show('edit_article'),
        //     $this->session->show('delete_article'),
        //     $this->session->show('delete_comment')
        // );
        
        // echo showSession($arraySession);
        ?>
        <h2>Articles</h2>
        <table class="table table-hover table-bordered table-dark table-responsive">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Contenu</th>
                    <th scope="col">Auteur</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <?php
            foreach ($articles as $article) {
                ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($article->getId()); ?></th>
                        <td><a href="../public/index.php?route=article&articleId=<?= htmlspecialchars($article->getId()); ?>"><?= htmlspecialchars($article->getTitle()); ?></a></td>
                        <td><?= substr(($article->getContent()), 0, 150); ?></td>  <!-- substr() permet de limiter le nombre de caractères (1er paramètre : le contenu, 2ème paramètre : le premier caractère, 3ème paramètre : le dernier caractère) -->
                        <td><?= htmlspecialchars($article->getPseudo()); ?></td>
                        <td><span class="italic"> posté le</span> : <?= htmlspecialchars($article->getCreatedAt()); ?></td>
                        <td>
                            <a href="../public/index.php?route=editArticle&articleId=<?= $article->getId(); ?>">Modifier</a>
                            <a href="../public/index.php?route=deleteArticle&articleId=<?= $article->getId(); ?>">Supprimer</a>
                        </td>
                    </tr>
                </tbody>
                <?php
            } ?>
        </table>
        <a class="btn btn-primary newArticle" href="../public/index.php?route=addArticle">Nouvel article</a>
        
        <h2>Commentaires signalés</h2>
        <table class="table table-hover table-bordered table-dark table-responsive-md">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Message</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <?php
            foreach ($comments as $comment) {
                ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($comment->getId()); ?></th>
                        <td><?= htmlspecialchars($comment->getPseudo()); ?></td>
                        <td><?= substr($comment->getContent(), 0, 150); ?></td>
                        <td><span class="italic">posté le</span> : <?= htmlspecialchars($comment->getCreatedAt()); ?></td>
                        <td>
                            <a href="../public/index.php?route=unflagComment&commentId=<?= $comment->getId(); ?>">Désignaler le commentaire</a><br />
                            <a href="../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>">Supprimer le commentaire</a>
                        </td>
                    </tr>
                </tbody>
                <?php
            } ?>
        </table>
        
        <h2>Utilisateurs</h2>
        <table class="table table-hover table-bordered table-dark table-responsive-md">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Date</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <?php
            foreach ($users as $user) {
                ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($user->getId()); ?></th>
                        <td><?= htmlspecialchars($user->getPseudo()); ?></td>
                        <td><span class="italic">créé le</span> : <?= htmlspecialchars($user->getCreatedAt()); ?></td>
                        <td><?= htmlspecialchars($user->getRole()); ?></td>
                        <td>
                            <?php
                            if ($user->getRole() != 'administrateur') {
                                ?>
                            <a href="../public/index.php?route=deleteUser&userId=<?= $user->getId(); ?>">Supprimer</a>
                            <?php
                            } else {
                                ?>
                            Suppression impossible
                            <?php
                            } ?>
                        </td>
                    </tr>    
                </tbody>
                <?php
            } ?>
        </table>
    </div>
    <?php
} else {
    ?>
    <h1 class="text-center"><?= $title ?></h1>
    <div class="container form-group">
        <p>Entrez identifiant et mot de passe</p>
        <form method="post" action="../public/index.php?route=administration">
            <label for="pseudo">Pseudo</label><br>
            <input class="form-control" type="text" id="pseudo" name="pseudo"><br>
            <label for="password">Mot de passe</label><br>
            <input class="form-control" type="password" id="password" name="password"><br>
            <?php $error_login = $this->session->get('error_login'); ?>
            <?= $show_error = !empty($error_login) ? '<div class="alert alert-danger" role="alert">' . $error_login . '</div>': ''; ?>
            <input class="btn btn-secondary" type="submit" value="Valider" id="submit" name="submit">
        </form>
    </div>
    <?php
}
?>


