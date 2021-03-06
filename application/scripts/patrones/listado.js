/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */
var oTable;
$(document).ready(function () {

    oTable = $('#listaEquipos').dataTable({
        "oLanguage": gearsPage.idiomaTablas()
    });

    gearsPage.seleccionTablas('listaEquipos', oTable);

    $('#Nuevo').click(function () {
        window.location.href = gearsPage.baseUrl('equipos/form')
    });

    $('#Editar').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                window.location.href = gearsPage.baseUrl('equipos/form/' + val);
            }
        }
    });
    
    $('#opCalibracion').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                window.location.href = gearsPage.baseUrl('patrones/calibracion/' + val);
            }
        }
    });
    
    $('#opParams').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                window.location.href = gearsPage.baseUrl('patrones/params/' + val);
            }
        }
    });

    $('#verInfo').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                $.ajax({
                    caceh: false, type: "POST",
                    url: gearsPage.urlServer('Calibracionespatrones'),
                    data: 'codePatron=' + val + '&accion=info',
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (resp) {
                        $('#infoModal1').html(resp);
                        $("#infoModal1").dialog({
                            resizable: false, //permite cambiar el tamaño
                            title: 'Detalles Equipo', //permite cambiar el tamaño
                            width: 400,
                            modal: true, //capa principal, fondo opaco
                            buttons: {
                                Cerrar: function () {
                                    $(this).dialog("close");
                                }
                            }
                        });
                    }, complete: function () {
                        $('#AccionLoad').hide();
                    }
                });
            }
        }
    });
    
    $('#verParam').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                $.ajax({
                    caceh: false, type: "POST",
                    url: gearsPage.urlServer('Parametrospatrones'),
                    data: 'codPatron=' + val + '&accion=parametrosEquipo',
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (resp) {
                        $('#infoModal1').html(resp);
                        $("#infoModal1").dialog({
                            resizable: false, //permite cambiar el tamaño
                            title: 'Detalles Equipo', //permite cambiar el tamaño
                            width: 500,
                            modal: true, //capa principal, fondo opaco
                            buttons: {
                                Cerrar: function () {
                                    $(this).dialog("close");
                                }
                            }
                        });
                    }, complete: function () {
                        $('#AccionLoad').hide();
                    }
                });
            }
        }
    });
    
});