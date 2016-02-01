jQuery(document).ready(function () {
    //Add error color to controls with error
    jQuery('.help-block').parent().addClass("has-error");
    //Activate all tooltips
    jQuery(function () {
        jQuery('[data-toggle="tooltip"]').tooltip()
    });
    //Load chosen
    $(".chosen-select").chosen({allow_single_deselect:true});
    //Activate tinyMCE
    tinymce.init({
        selector: '.visualeditor',
        theme: "advanced",
        height: "500",
        setup : function(ed)
        {
            // set the editor font size
            ed.onInit.add(function(ed)
            {
                ed.getBody().style.fontSize = '14px';
            });
        },
        plugins : "spellchecker,iespell,inlinepopups,contextmenu,paste",
        theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,image,code",
    });
});