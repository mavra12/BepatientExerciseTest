$(document).ready(function () {
    var validate = $("#EnergyBillsForm").validate({
        rules : {
            EnergyUnits : {
                required : true,
            }
        },
        errorPlacement : function (error, element) {
            error.insertAfter(element);
        }
    });
});

function CalculateEnergyCost() {
    if (!$("#EnergyBillsForm").valid()) {
        return;
    }

    var formData = new FormData($('#EnergyBillsForm')[0]);

    $.ajax({
        type : "POST",      
        url : "calculate-bill",
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