var Main = {};

$(document).ready(
        function () {
            $(window).resize(function () {
                Main.resize();
            });
            Main.resize();
        }
);

Main.resize = function () {
    var windowWidth = parseFloat($(window).width());
    if(windowWidth<600){
        $('#itsUpToYou').html("IT'S<br/>UP TO<br/>YOU");
    }
    else{
        $('#itsUpToYou').html("IT'S UP TO YOU");
    }
};