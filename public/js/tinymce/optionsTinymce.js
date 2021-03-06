// tinymce.init({
//     selector: 'textarea',
//     language : 'fr_FR',
//     plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
//     toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
//     toolbar_mode: 'floating',
//     tinycomments_mode: 'embedded',
//     tinycomments_author: 'Author name'
//   });

  // tinymce.init({
  //   selector: 'textarea',
//     language : 'fr_FR',
  //   // Barre d'outils
  //   // toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
  //   // toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
  //   toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | outdent indent',

  //   menu: {
  //     happy: {title: 'Contenu', items: 'code'}
  //   },
  //   plugins: 'code',  // required by the code menu item
  //   menubar: 'Contenu',  // adds happy to the menu bar
  //  });
  
  tinymce.init({
    selector: 'textarea',
    language : 'fr_FR',
    toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | outdent indent',
    menubar: false
  });  