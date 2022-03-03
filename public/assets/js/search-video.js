$(document).ready(function () {
    var validate = $("#VideoSearchForm").validate({
        rules : {
            searchString : {
                required : true
            },
            channelName : {
                required : true,
            }
        },
        errorPlacement : function (error, element) {
            error.insertAfter(element);
        }
    });
});

function searchVideos() {
    if (!$("#VideoSearchForm").valid()) {
        return;
    }

    var formData = new FormData($('#VideoSearchForm')[0]);

    $.ajax({
        type : "POST",      
        url : "video-search",
        data : formData,
        async : true,
        cache : false,
        contentType : false,
        enctype : 'multipart/form-data',
        processData : false,
        error: function (errorData) {
            try {
                var jsonErrorData = errorData.responseJSON;
                var errorMsg = '';
                bootbox.alert("<h4>Error</h4><hr>" + jsonErrorData.message + "<br><br>" + errorMsg);
            } catch(e) {
                bootbox.alert("<h4>Error</h4><hr> Unexpected error. Try again.");
            }
        },
        success : function (response) {
            $('#content').html(response);
        }
    });
}