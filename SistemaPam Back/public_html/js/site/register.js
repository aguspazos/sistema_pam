var Register = {};

Register.acceptedTerms = false;

$(document).ready(function () {
    Register.bindFunctions();
    Register.resize();
});


Register.bindFunctions = function () {
    $(window).resize(function () {
        Register.resize();
    });
    
    $('#registrate').on({
        'click':function(){
            Register.sendForm();
        }
    });
    $('#auxTimer').animate({'opacity':0},750,
        function(){
            $('#menu').animate({'opacity':1},750);
            $('#mainLogo').hide();
            $('#registrate').animate({'opacity':1},750);
            $('#acceptTermsRow').animate({'opacity':1},750);
            $('#mainText').animate({'opacity':1},750);
            $('#mainTextUnderline').animate({'opacity':1},750);
            $('#registerForm').animate({'opacity':1},750);
            $('#footerLegal').animate({'opacity':1},750);
            $('#footerLogos').animate({'opacity':1},750);
        }
    );
    
    $('#acceptTermsClick').on({
        'click':function(){
            if(Register.acceptedTerms){
                Register.acceptedTerms = false;
                $('#acceptTermsTick').hide();
            }
            else{
                Register.acceptedTerms = true;
                $('#acceptTermsTick').show();
            }
        }
    });
};

Register.resize = function () {
};

Register.sendForm = function () {
    var first_name = $.trim($("#first_name").val());
    var last_name = $.trim($("#last_name").val());
    var phone = $.trim($("#phone").val());
    var email = $.trim($("#email").val());
    var gender = $.trim($('input[name=gender]:checked').val());
    var address = $.trim($("#address").val());
    var code = $.trim($("#code").val());
    var ci = $.trim($("#ci").val());
    
    if (first_name.length > 2) {
        if (last_name.length > 0) {
            if (phone.length > 0) {
                if (Tools.validateEmail(email)) {
                    if (code.length>0) {
                        if (ci.length>3) {
                            if(Register.acceptedTerms){
                                var loadingCode = Tools.showLoading();
                                $.ajax({
                                    url: '/Users/add',
                                    type: 'POST',
                                    data: {first_name:(first_name),last_name:(last_name),phone:(phone),email:(email),
                                        gender:(gender),address:(address),code:(code),ci:(ci)},
                                    success: function (response) {
                                        Tools.removeLoading(code);
                                        response = $.parseJSON(response);
                                        if (response.status == "ok") {
                                            Register.formCompleted();
                                        } else {
                                            Tools.alert(response.errorMessage);
                                        }
                                    },
                                    error: function () {
                                        Tools.removeLoading(loadingCode);
                                        Tools.alert("Lo sentimos, ocurrió un error inesperado.");
                                    }
                                });
                            }
                            else{
                                Tools.alert("Debe aceptar las bases y condiciones.");
                            }
                        }
                        else{
                            Tools.alert("Ingrese una CI válida.");
                        }
                    }
                    else{
                        Tools.alert("Ingrese un código válido");
                    }
                }
                else{
                    Tools.alert("Ingrese un email válido");
                }
            }
            else{
                Tools.alert("Ingrese un teléfono válido");
            }
        }
        else{
            Tools.alert("Ingrese un apellido válido");
        }
    }
    else{
          Tools.alert("Ingrese un nombre válido");
    }
  
};

Register.formCompleted = function(){
    $('#menu').animate({'opacity':0},750);
    $('#mainLogo').animate({'opacity':0},750);
    $('#registrate').animate({'opacity':0},750);
    $('#acceptTermsRow').animate({'opacity':0},750);
    $('#mainText').animate({'opacity':0},750);
    $('#mainTextUnderline').animate({'opacity':0},750);
    $('#registerForm').animate({'opacity':0},750);
    $('#footerLogos').animate({'opacity':0},750);
    $('#auxTimer').animate({'opacity':0},1000,function(){Tools.redirect('/site/thanks');});
};