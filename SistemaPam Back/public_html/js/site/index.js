var Index = {};

$(document).ready(function () {
    Index.bindFunctions();
    $(window).resize(function () {
        Index.resize();
    });
    Tools.delay(100,Index.resize);
    Tools.delay(500,Index.resize);
});


Index.bindFunctions = function () {
    $('#participate').on({
        'click':function(){
            $('#menu').animate({'opacity':0},750);
            $('#logoContainer').animate({'opacity':0},750);
            $('#dateContainer').animate({'opacity':0},750);
            $('#participate').animate({'opacity':0},750);
            $('#cupon').animate({'opacity':0},750);
            $('#mainText').animate({'opacity':0},750);
            $('#footerLegal').animate({'opacity':0},750);
            $('#auxTimer').animate({'opacity':0},1000,function(){Tools.redirect('/site/register');});
        }
    });
    $('#menu').animate({'opacity':0},750,
        function(){
            $('#menu').animate({'opacity':1},750);
            $('#logoContainer').animate({'opacity':1},750);
            $('#dateContainer').animate({'opacity':1},750);
            $('#participate').animate({'opacity':1},750);
            $('#cupon').animate({'opacity':1},750);
            $('#mainText').animate({'opacity':1},750);
            $('#footerLegal').animate({'opacity':1},750);
        }
    );
};

Index.resize = function () {
};