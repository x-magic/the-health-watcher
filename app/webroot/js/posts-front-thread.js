function ajaxGetMorePosts() {
    jQuery.ajax({
        url: ajaxMorePostURL,
        type: 'POST',
        data: {requestOffset: postCount, requestParent: postParent},
        beforeSend: function () {
            jQuery('#loadMorePostBtn').hide();
            jQuery('#loadMorePostIndicator').show();
        },
        success: function(data) {
            //Append received new posts
            $('.children').append(data);
            //Reset load more button and indicator
            jQuery('#loadMorePostBtn').show();
            jQuery('#loadMorePostIndicator').hide();
            //Recount number of posts
            countChildThreads();
        },
        error: function () {
            alert("Error loading more post. Press OK to refresh page. ");
            location.reload();
        }
    });
    return false;
}

function countChildThreads() {
    var currentCount = postCount;
    postCount = jQuery('.childThread').length;
    if (postCount < currentCount + 5) noMoreLoad();
}

function noMoreLoad() {
    jQuery('#loadMorePostBtn').hide();
    jQuery('#noMorePostIndicator').show();
}

function checkReplyContent() {
    var isInputEmpty = jQuery('.forum-reply').val() == "";
    jQuery('#ka-comment-form-submit').prop('disabled', isInputEmpty);
}