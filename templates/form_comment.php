<?php
$route = isset($_GET['commentId']) ? 'editComment&commentId=' . htmlspecialchars($comment->getId()) : 'addComment';
$submit = $route === 'addComment' ? 'Ajouter' : 'Mettre à jour';
$title = $route === 'addComment' ? '<h3> Ajouter un commentaire </h3>' : '<h1> Mettre à jour le commentaire </h1>';
$pseudo = $this->session->get('pseudo');
$this->script =
    '<script src="../public/js/tinymce/tinymce.min.js"></script>
    <script src="../public/js/tinymce/optionsTinymce.js"></script>';
?>


<div class="form-group">
    <?= $title; ?>
    <form method="post" action="../public/index.php?route=<?= $route; ?>&articleId=<?= htmlspecialchars($article->getId()); ?>">
        <input type="hidden" class="form-control" id="pseudo" name="pseudo" value="<?= $pseudo; ?>"><br>
        <label for="content">Message</label><br>
        <textarea id="content" class="form-control" name="content"><?= isset($post) ? htmlspecialchars($post->get('content')): ''; ?></textarea><br>
        <?= isset($errors['content']) ? '<div class="alert alert-danger" role="alert">' . $errors['content'] . '</div>': ''; ?>  
        <input type="submit" class="btn btn-secondary" value="<?= $submit; ?>" id="submit" name="submit">
    </form>
</div>

