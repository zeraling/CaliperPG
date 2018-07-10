/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

var oTable;
$(document).ready(function () {

    oTable = $('#listaClientes').DataTable({
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "oLanguage": gearsPage.idiomaTablas()
    });

    gearsPage.seleccionTablas('listaClientes', oTable);

    $('#Ver').click(function () {

        var anSelected = gearsPage.fnGetSelected(oTable);
        var val = $(anSelected).attr('data');
        if (val !== '' && val !== undefined) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Clientes'),
                data: 'nit=' + val + '&accion=info',
                beforeSend: function () {
                    $('#ActionLoad').show();
                }, success: function (resp) {
                    $('#infoModal1').html(resp);
                    $("#infoModal1").dialog({
                        resizable: false, //permite cambiar el tamaño
                        height: 300, // altura
                        width: 450,
                        modal: true, //capa principal, fondo opaco
                        buttons: {
                            Cerrar: function () {
                                $(this).dialog("destroy");
                            }
                        }
                    });
                }, complete: function () {
                    $('#ActionLoad').hide();
                }
            });
        }
    });
    
    $('#Nuevo').click(function () {
        window.location.href = gearsPage.baseUrl('clientes/form');
    });
    
    $('#Editar').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                window.location.href = gearsPage.baseUrl('clientes/form/' + val);
            }
        }
    });

});