<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name=viewport content="width=device-width, initial-scale=1">
        <meta property="og:title" content="Blog Jean Forteroche" />
        <meta property="og:description" content="Blog de jean Forteroche, Découvrez-y tous mes romans !" />
        <meta property="og:url" content="http://www.jeanforteroche.webagencyp.com" />
        <meta property="og:image" content="../public/img/favicon.ico" />
        <link rel="shortcut icon" type="image/ico" href="../public/img/favicon.ico"/>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>      
        <link rel="stylesheet" href="../public/css/style.css">
        <script src="../public/js/buttonAnimation.js"></script>
        <script src="https://kit.fontawesome.com/a40557f943.js" crossorigin="anonymous"></script>
        <?= $script ?>
    </head>
    <body>
        <?php include("header.php"); ?>
        <?php include("showSession.php"); ?>
        <div id="content">
            <?= $content ?>
        </div>
        <?php include("footer.php"); ?>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
