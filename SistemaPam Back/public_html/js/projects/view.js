var View = {};
View.files;
View.gallery;

$(document).ready(function(){
    View.getFiles();
    View.gallery = MMGallery.newGallery("projectCol1", View.files, 50);
    View.gallery.start();
    $("#headerColor").css("opacity","1");
});

View.getFiles = function(){
    View.files = $.parseJSON($("#filesForJS").html());
};