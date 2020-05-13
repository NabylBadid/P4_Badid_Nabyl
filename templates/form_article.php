<?php
$route = isset($post) && $post->get('id') ? 'editArticle&articleId='.$post->get('id') : 'addArticle';
$submit = $route === 'addArticle' ? 'Envoyer' : 'Mettre à jour';
$title = $route === 'addArticle' ? 'Ajouter un article' : 'Mettre à jour l\'article';
?>
<div class="form-group">
    <h1 class="text-center"><u><?= $title ?></u></h1>

    <form method="post" action="../public/index.php?route=<?= $route; ?>">
        <label for="title">Titre</label><br>
        <input type="text" class="form-control" id="title" name="title" value="<?= isset($post) ? htmlspecialchars($post->get('title')): ''; ?>"><br>
        <?= isset($errors['title']) ? $errors['title'] : ''; ?>
        <label for="content">Contenu</label><br>
        <textarea id="content" class="form-control" name="content"><?= isset($post) ? $post->get('content'): ''; ?></textarea><br> 
        <?= isset($errors['content']) ? $errors['content'] : ''; ?>
        <label for="title">Nom de l'image</label><br>
        <input type="text"  class="form-control" id="imgName" name="imgName" value="<?= isset($post) ? htmlspecialchars($post->get('imgName')): ''; ?>"><br>
        <?= isset($errors['imgName']) ? $errors['imgName'] : ''; ?>
        <input type="submit" class="btn btn-secondary" value="<?= $submit; ?>" id="submit" name="submit">
    </form>
</div>
