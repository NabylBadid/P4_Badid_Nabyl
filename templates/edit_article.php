<?php $this->title = "Modifier l'article"; ?>
<?php $this->script = 
    '<script src="../public/js/tinymce/tinymce.min.js"></script>
    <script src="../public/js/tinymce/optionsTinymce.js"></script>';
    var_dump($this->session);
?>

<div class="container article">
    <?php include('form_article.php');?>
    <a class="link" href="../public/index.php?route=administration"><< Retour à l'espace d'administration</a>
</div>