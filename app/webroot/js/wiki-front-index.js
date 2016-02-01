function ajaxGetMoreTopViewPages() {
    jQuery.ajax({
        url: ajaxMoreTopURL,
        type: 'POST',
        data: {requestOffset: topViewedCount},
        beforeSend: function () {
            jQuery('#loadMoreTopViewPagesBtn').hide()
            jQuery('#loadMoreTopViewPagesIndicator').show();
        },
        success: function(data) {
            //Prepend received new pages
            $(data).insertBefore("#wiki-index-top-viewed-more-anchor");
            //Reset load more button and indicator
            jQuery('#loadMoreTopViewPagesBtn').show()
            jQuery('#loadMoreTopViewPagesIndicator').hide();
            //Recount number of pages
            countTopViewPages();
        },
        error: function () {
            alert("Error loading more article. Press OK to refresh page. ");
            location.reload();
        }
    });
    return false;
}
function countTopViewPages() {
    var currentCount = topViewedCount;
    topViewedCount = jQuery('.topViewBox').length;
    if (topViewedCount < currentCount + 4) noMoreLoad();
}
function noMoreLoad() {
    jQuery('#loadMoreTopViewPagesBtn').hide();
    jQuery('#noMorePageIndicator').show();
}
