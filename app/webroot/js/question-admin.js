jQuery(document).ready(function () {
    //Add error color to controls with error
    jQuery('.help-block').parent().addClass("has-error");
    //Activate all tooltips
    jQuery(function () {
        jQuery('[data-toggle="tooltip"]').tooltip()
    });
    //Load chosen
    jQuery(".chosen-select").chosen({allow_single_deselect: true, disable_search_threshold: 5});
});