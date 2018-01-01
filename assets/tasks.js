STUDIP.TP = {
    periodicalPushData: function () {
        if (jQuery(".tp_discussion").length) {
            return {
                'task_id': jQuery("[name=comment]").data("task_id")
            };
        }
    },
    'update': function (output) {
        if (output.comments) {
            for (var i = 0; i < output.comments.length; i++) {
                if (jQuery("#comment_" + output.comments[i].comment_id).length === 0) {
                    jQuery(".tp_discussion").append(output.comments[i].html).find(":last-child").hide().fadeIn(300);
                }
            }
        }
    },
    'addComment': function () {
        var comment = jQuery("[name=comment]").val();
        var task_id = jQuery("[name=comment]").data("task_id");
        if (comment.length) {
            jQuery.ajax({
                'url': STUDIP.ABSOLUTE_URI_STUDIP + "plugins.php/taskplugin/tasks/comment/" + task_id,
                'type': "post",
                'data': {
                    'comment': comment,
                },
                'dataType': "json",
                'success': function (data) {
                    jQuery(".tp_discussion").append(data.html).find(":last-child").hide().fadeIn(300);
                }
            });
            jQuery("[name=comment]").val('');
        }
        return false;
    }
};
