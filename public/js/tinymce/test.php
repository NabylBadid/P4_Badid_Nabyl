<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="tinymce.min.js"></script>
    <script type="text/javascript">
    tinyMCE.init({
      mode : "textareas",
      theme : "simple"   //(n.b. no trailing comma, this will be critical as you experiment later)
    });
    </script>
    <title>Document</title>
</head>

<body>
  <form>  
    <textarea name="content" cols="50" rows="15" >
      This is some content that will be editable with TinyMCE.
    </textarea>
  </form>
</body>

</html>

<!-- <head>
  <script type="text/javascript" src="insertYourPath/tinymce/jscripts/tiny_mce/tiny_mce.js"></script >
  <script type="text/javascript">
    tinyMCE.init({
      mode : "textareas",
      theme : "simple"   //(n.b. no trailing comma, this will be critical as you experiment later)
    });
  </script >
</head>

<body>
  <form>  
    <textarea name="content" cols="50" rows="15" >
      This is some content that will be editable with TinyMCE.
    </textarea>
  </form>
</body> -->