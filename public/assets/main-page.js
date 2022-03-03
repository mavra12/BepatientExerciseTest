
function wordCounter() {
    if (!$("#MainForm").valid()) {
        return;
    }

    var formData = new FormData($('#WordCounterForm')[0]);

    $.ajax({
        type : "POST",      
        url : "word-count",
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