/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */
var oTable;
$(document).ready(function () {

    $("#IdTipoEquipo").select2({language: 'es', placeholder: 'Selecione un equipo'});
    $("#CodMarca").select2({language: 'es', placeholder: 'Selecione una marca'});

    oTable = $('#listaEquipos').dataTable({
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "oLanguage": gearsPage.idiomaTablas()
    });

    gearsPage.seleccionTablas('listaEquipos', oTable);

    $('#Consulta').click(function () {

        oTable.fnClearTable(0);
        oTable.fnDraw();

        var data = {
            tipo: parseInt($('#IdTipoEquipo').val()),
            marca: parseInt($('#CodMarca').val()),
            modelo: $('#Modelo').val()
        };

        if (data.tipo > 0 && (data.marca > 0 || data.modelo !== '')) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Equipos'),
                data: 'data=' + JSON.stringify(data) + '&accion=Consultar',
                beforeSend: function () {
                    $('#AccionLoad').show();
                }, success: function (datos) {
                    var accion = JSON.parse(datos);
                    if (accion.length) {
                        accion.forEach(function (item) {
                            oTable.fnAddData([item.detalle, item.marca, item.modelo]);
                        })
                    }
                    oTable.fnAdjustColumnSizing();
                }, complete: function () {
                    $('#AccionLoad').hide();
                }, error: function (err) {
                    console.log(err);
                    alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                }
            });
        }
    });



    $('#Nuevo').click(function () {
        window.location.href = gearsPage.baseUrl('equipos/form')
    });

    $('#Editar').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].id;
            if (val !== '' && val !== undefined) {
                window.location.href = gearsPage.baseUrl('equipos/form/' + val);
            }
        }
    });

    $('#Ver').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].id;
            if (val !== '' && val !== undefined) {
                $.ajax({
                    caceh: false, type: "POST",
                    url: gearsPage.urlServer('Equipos'),
                    data: 'serie=' + val + '&accion=info',
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

    $('#opMarcas').click(function () {
        window.location.href = gearsPage.baseUrl('equipos/marcas')
    });
});