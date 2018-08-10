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
        "pagingType": "numbers",
        "oLanguage": gearsPage.idiomaTablas()
    });
    
    gearsPage.seleccionTablas('listaTipos',oTable);


    $('#Agregar').click(function () {
       location.href=gearsPage.baseUrl('parametros/admin-tipos');
    });
    
    $('#Actualizar').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                window.location.href = gearsPage.baseUrl('parametros/admin-tipos/' + val);
            }
        }
    });

    $('#Info').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Parametrosequipos'),
                    data: 'codEquipo=' + val + '&accion=parametrosEquipo',
                    success: function (resp) {
                        $('#infoModal1').html(resp);
                        $("#infoModal1").dialog({
                            title: 'Parametros Equipo',
                            resizable: false, //permite cambiar el tamaño
                            height: 375, // altura
                            width: 500,
                            modal: true, //capa principal, fondo opaco
                            buttons: {
                                Cerrar: function () {
                                    $(this).dialog("destroy");
                                }
                            }
                        });
                    }
                });
            }
        }
    });
    
    $('#Parametros').click(function () {
       location.href=gearsPage.baseUrl('parametros/admin-param');
    });

    $('#Unidades').click(function () {
       location.href=gearsPage.baseUrl('parametros/unidades');
    });
    
});