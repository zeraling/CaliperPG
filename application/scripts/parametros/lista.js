/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

var oTable;
$(document).ready(function () {

    oTable = $('#listaTipos').dataTable({
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "oLanguage": gearsPage.idiomaTablas()
    });
    
    gearsPage.seleccionTablas('listaTipos',oTable);

    $('#Parametros').click(function () {
       location.href=gearsPage.baseUrl('parametros/admin');
    });

    $('#Agregar').click(function () {
       location.href=gearsPage.baseUrl('parametros/equipos');
    });
    
    
    
    $('#Actualizar').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                window.location.href = gearsPage.baseUrl('parametros/equipos/' + val);
            }
        }
    });

    $('#Info').click( function(){
            
        var anSelected = gearsPage.fnGetSelected( oTable );
        var val=$(anSelected).attr('data');
        if(val>0&& val!==undefined){
        $.ajax({
            cache:false,type: "POST",
            url: UrlServer()+'MagnitudesEquipos.php',
            data:'idParametro='+val+'&accion=parametrosTipo',
            beforeSend: function () {
               $('#ActionLoad').show();                     
            },success: function(resp){
                $('#infoModal1').html(resp);
                $("#infoModal1" ).dialog({
                   title: 'Parametros Equipo',
                   resizable: false, //permite cambiar el tamaño
                   height:375, // altura
                   width :500,
                   modal: true, //capa principal, fondo opaco
                   buttons: {
                     Cerrar: function() {
                       $( this ).dialog( "destroy" );
                     }
                   }
                 });
           },complete: function () {
               $('#ActionLoad').hide();                       
            }
        });
      }
     });
    
    
});