function cmsCommentMessage(message, type) {
    $("#commentstatus").replaceWith("<label id=\"commentstatus\" class=\"has-"+type+"\"><div class=\"editable-error-block help-block\" style=\"display: block;\">"+message+"</div></label>");
}

function cmsCommentCreate(bindval, body) {
    bindval = bindval || "#commentform";
    body = body || "textarea#body";
    $(bindval).submit(function() {
        cmsCommentMessage("Waiting for lock to clear...", "info");
        var that = this;
        var cmsCommentCreateCheck = setInterval(function() {
            if (cmsCommentLock == false) {
                cmsCommentLock = true;
                clearInterval(cmsCommentCreateCheck);
                cmsCommentCreateSubmit(that);
            }
        }, 10);
        return false;
    });
    $(body).keydown(function (e) {
        if (e.ctrlKey && e.keyCode === 13) {
            $(bindval).trigger("submit");
        }
    });
}
