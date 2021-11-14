$(document).ready(function () {
    var validate = $("#FileLoad").validate({
        rules : {
            FileToLoad : {
                required : true,
                minlength : 1,
                maxlength : 255
            }
        },
        errorPlacement : function (error, element) {
            error.insertAfter(element);
        }
    });
});

function loadFile() {
    if (!$("#FileLoad").valid()) {
        return;
    }

    var formData = new FormData($('#FileLoad')[0]);

    $.ajax({
        type : "POST",      
        url : "file-load",
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