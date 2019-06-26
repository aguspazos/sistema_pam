var Thanks = {};

$(document).ready(function () {
    Thanks.bindFunctions();
});

Thanks.bindFunctions = function () {
    $('#register').on({
        'click':function(){
            Thanks.sendForm();
        }
    });
    $('#auxTimer').animate({'opacity':0},750,
        function(){
            $('#menu').animate({'opacity':1},750);
            $('#successfulText').animate({'opacity':1},750);
            $('#doubleChancesText').animate({'opacity':1},750);
            $('#enterCodeText').animate({'opacity':1},750);
            $('#code').animate({'opacity':1},750);
            $('#register').animate({'opacity':1},750);
        }
    );
};

Thanks.sendForm = function () {
    var code = $.trim($("#code").val());
    
    if (code.length>3) {
                var loadingCode = Tools.showLoading();
                $.ajax({
                    url: '/Users/addAnotherCode',
                    type: 'POST',
                    data: {code:(code)},
                    success: function (response) {
                        Tools.removeLoading(code);
                        response = $.parseJSON(response);
                        if (response.status == "ok") {
                            Thanks.formCompleted();
                        } else {
                            if (response.status == "error" && response.error == "noUser"){
                                Tools.redirect('/site/register');
                            }
                            else{
                                Tools.alert(response.errorMessage);
                            }
                        }
                    },
                    error: function () {
                        Tools.removeLoading(loadingCode);
                        Tools.alert("Lo sentimos, ocurrió un error inesperado.");
                    }
                });
    }
    else{
        Tools.alert("Ingrese un código válido");
    }
  
};

Thanks.formCompleted = function(){
    $('#doubleChancesText').remove();
    $('#enterCodeText').remove();
    $('#code').remove();
    $('#register').attr('src','/files/site/chancesx2.png');
    $('#register').off();
};