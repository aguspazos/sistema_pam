var Info = {};

$(document).ready(function () {
    Info.bindFunctions();
});


Info.bindFunctions = function () {
    $('#menu').animate({'opacity':0},750,
        function(){
            $('#menu').animate({'opacity':1},750);
            $('#logoContainer').animate({'opacity':1},750);
            $('#faq').animate({'opacity':1},750);
            $('#footerImage').animate({'opacity':1},750);
        }
    );
};