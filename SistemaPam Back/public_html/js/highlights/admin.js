
var MMAdminHighlights = {};
MMAdminHighlights.editMode = false;
MMAdminHighlights.highlight = {};

MMAdminHighlights.highlight.highlightFileManager = {};
    
$(document).ready(
    function(){
        MMAdminHighlights.editMode = $('#selectedHighlightId').length>0;
        if($('#savePositions').length>0){
            $('#adminPositions').sortable();

            $('#savePositions').on({
                'click':function(){
                    MMAdminHighlights.savePositions();
                }
            });
        }
        else{
            if($('#addHighlight').length>0){
                $('#addHighlight').on({
                    'click':function(){
                        if(MMAdminHighlights.editMode)
                            MMAdminHighlights.save();
                        else
                            MMAdminHighlights.add();
                    }
                });
            }

            if(MMAdminHighlights.editMode){
                $('#deleteHighlight, #deleteHighlightTrash').on({
                    'click':function(){
                        var id = parseInt($('#selectedHighlightId').val());
                        if(id!==0)
                            if(confirm($('#confirmationText').val()))
                                MMAdminHighlights.remove(id);
                    }
                });
                MMAdminHighlights.searchThroughTableBinds();
                MMAdminHighlights.checkSelectedHighlight();
            }
            else{
                if($('#active').length>0)
                    $('#active').attr('class','adminCheckboxChecked');
            }    

            
        MMAdminHighlights.highlightFileManager = FileManager.newInstance('highlightFile','highlightFile',false,new Array());
        MMAdminHighlights.highlightFileManager.start();
        }
});

MMAdminHighlights.add = function(){
    MMAdminHighlights.updateHighlightData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Highlights/add',
        data:{'highlight':(MMAdminHighlights.highlight)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Highlights/viewEdit/'+response.id);});
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
                Tools.removeLoading(loadCode);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
                Tools.removeLoading(loadCode);
            }
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};
    
MMAdminHighlights.save = function(){
    MMAdminHighlights.updateHighlightData();
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Highlights/save',
        data:{'highlight':(MMAdminHighlights.highlight)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Highlights/viewEdit/'+MMAdminHighlights.highlight.id);});
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
                Tools.removeLoading(loadCode);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
                Tools.removeLoading(loadCode);
            }
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};

MMAdminHighlights.savePositions = function(){
    var highlightIds = new Array();
    $('.adminPosition').each(function() {
        highlightIds[highlightIds.length] = $(this).attr('id');
    });
    
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/Highlights/savePositions',
        data:{'highlightIds':(highlightIds)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.alert(response.message);
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
            Tools.removeLoading(loadCode);
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};



    
MMAdminHighlights.remove = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Highlights/delete',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                Tools.removeLoading(loadCode);
                Tools.alert(response.message,1,function(){Tools.redirect('/Highlights/viewEdit');});
            }
            else if(response.status==='error'){
                Tools.alert(response.errorMessage);
                Tools.removeLoading(loadCode);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
                Tools.removeLoading(loadCode);
            }
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};
    
MMAdminHighlights.updateHighlightData = function(){
    var selectedHighlightId = parseInt($('#selectedHighlightId').val());
    if(!isNaN(selectedHighlightId) && selectedHighlightId!==0)
        MMAdminHighlights.highlight.id = selectedHighlightId
    else if($('#highlightId').length>0)
        MMAdminHighlights.highlight.id = $('#highlightId').val();
    else
        MMAdminHighlights.highlight.id = 0;
    MMAdminHighlights.highlight.name = $('#name').val();
    MMAdminHighlights.highlight.title = $('#title').val();
    MMAdminHighlights.highlight.font_size = $('#font_size').val();
    MMAdminHighlights.highlight.letter_spacing = $('#letter_spacing').val();
    MMAdminHighlights.highlight.link = $('#link').val();
    MMAdminHighlights.highlight.mobile = Tools.getValueFromCheckbox($('#mobile'));
    MMAdminHighlights.highlight.highlight_file_id = MMAdminHighlights.getHighlightFile();
};
    
MMAdminHighlights.checkSelectedHighlight = function(){
    var id = parseInt($('#highlightId').val());
    if(!isNaN(id) && id!==0){
        $('#selectedHighlightId').val(id);
        MMAdminHighlights.loadHighlight(id);
    }
};
    
MMAdminHighlights.loadHighlight = function(id){
    var loadCode = Tools.showLoading();
    $.ajax({
        type: 'POST',
        url: '/index.php/Highlights/getArray',
        data:{'id':(id)},
        success: function(response){
            response = $.parseJSON(response);
            if(response.status==='ok'){
                MMAdminHighlights.setHighlight(response.highlight);
            }
            else{
                Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            }
            Tools.removeLoading(loadCode);
        },
        error: function(){
            Tools.alert('Error obteniendo datos del sitio, verifique su conexión a internet.');
            Tools.removeLoading(loadCode);
        }
    });
};
    
MMAdminHighlights.setHighlight = function(highlight){
    MMAdminHighlights.highlight = highlight;
    $('#id').val(highlight.id);
    $('#name').val(highlight.name);
    $('#title').val(highlight.title);
    $('#font_size').val(highlight.font_size);
    $('#letter_spacing').val(highlight.letter_spacing);
    $('#link').val(highlight.link);
    if(parseInt(highlight.mobile)===1)
        $('#mobile').attr('class','adminCheckboxChecked');
    else
        $('#mobile').attr('class','adminCheckbox');
    
    MMAdminHighlights.addHighlightFile();
};
        

        

            
//------------------------------------------------------------------------------
//--------------------------------HighlightFileId--------------------------------
//------------------------------------------------------------------------------
MMAdminHighlights.getHighlightFile = function(){
    var file = MMAdminHighlights.highlightFileManager.getFiles();
    if(file!==false)
        return file.id;
    else
        return '';
};

MMAdminHighlights.addHighlightFile = function(){
    if(MMAdminHighlights.highlight.highlightFile.length!==0)
        MMAdminHighlights.highlightFileManager.updateFiles([MMAdminHighlights.highlight.highlightFile]);
    else
        MMAdminHighlights.highlightFileManager.updateFiles([]);
};


            
//------------------------------------------------------------------------------
//---------------------------SearchThroughTables--------------------------------
//------------------------------------------------------------------------------



MMAdminHighlights.searchThroughTableBinds = function(){

   $('#selectedHighlightId').on({
       'change':function(){
            var id = $(this).val();
            if(!isNaN(id) && id!==0)
                MMAdminHighlights.loadHighlight(id);
        }
   });
};