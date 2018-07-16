/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */
var oTable;

function cargarParametrosEquipo() {
    var patron = parseInt($('#codPatron').val());
    oTable.fnClearTable(0);
    oTable.fnDraw();
    if (patron > 0) {
        $.ajax({
            cache: false, type: "POST", dataType: "json",
            url: gearsPage.urlServer('Parametrospatrones'),
            data: 'codPatron=' + patron + '&accion=cargarParametroPatron',
            success: function (resp) {
                if (resp.length > 0) {
                    resp.forEach(function (item) {
                        oTable.fnAddData([
                            item.parametro,
                            item.unidad,
                            item.res,
                            item.up,
                            item.tolera,
                            item.opcion
                        ]);
                    })
                    oTable.fnAdjustColumnSizing();
                } else {
                    var text = 'No Hay Parametros asigandos a este equipo.';
                    var class_name = 'gritter-error';
                    $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2800});
                }
            }
        });
    }

}

$(document).ready(function () {

    $('#btnVolver').click(function () {
        window.location.href = gearsPage.baseUrl('patrones');
    });

    $('#IdUnidad').select2({placeholder: 'Seleccione unidad', language: "es"});
    $('#IdParametro').select2({placeholder: 'Seleccione un parametro', language: "es"});

    $('#Up').numeric(".");
    $('#Resolucion').numeric(".");
    $('#Tolerancia').numeric(".");

    oTable = $('#listaParametros').dataTable({
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "oLanguage": gearsPage.idiomaTablas()
    });

    gearsPage.seleccionTablas('listaParametros', oTable);

    $('#asignarParametro').validate({
        submitHandler: function () {
            var str = $('#asignarParametro').serialize();
            $.ajax({
                cache: false, type: 'POST',
                url: gearsPage.urlServer('Parametrospatrones'),
                data: str + '&accion=asignarParametro',
                beforeSend: function () {
                    $('#AccionLoad').show();
                }, success: function (datos) {
                    var item = JSON.parse(datos);
                    if (item.respuesta === true) {
                        cargarParametrosEquipo();

                        $("#IdParametro").select2('val', 'All');
                        $("#IdUnidad").select2('val', 'All');

                        $('#Up').val('');
                        $('#Resolucion').val('');
                        $('#Tolerancia').val('');

                        var text = 'Se asigno el parametro al equipo patron correctamente.';
                        var class_name = 'gritter-success';
                    } else {
                        var text = 'Ocurrio algo, no se pudo asignar el parametro al equipo patron.';
                        var class_name = 'gritter-error';
                    }
                    $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2800});

                }, complete: function () {
                    $('#AccionLoad').hide();
                }, error: function () {
                    alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                }
            });
        }, errorPlacement: function (error, element) {
            error.appendTo(element.prev("span").append());
        }
    });

    //Detalles
    $(document).on('click', '.btnDeleteParam', function () {
        var val = parseInt($(this).attr('data'));
        if (val > 0) {
            $("#modalDetele").dialog({
                title: 'Desvincular Parametro',
                resizable: false, //permite cambiar el tamaño
                width: 340,
                closeOnEscape: false,
                modal: true,
                buttons: {
                    Aceptar: function () {
                        $.ajax({
                            cache: false, type: "POST",
                            url: gearsPage.urlServer('Parametrospatrones'),
                            data: 'code=' + val + '&accion=eliminarParam',
                            success: function (datos) {
                                var item = JSON.parse(datos);
                                if (item.respuesta === true) {
                                    cargarParametrosEquipo();

                                    $("#IdParametro").select2('val', 'All');
                                    $("#IdUnidad").select2('val', 'All');

                                    $('#Up').val('');
                                    $('#Resolucion').val('');
                                    $('#Tolerancia').val('');

                                    var text = 'Se retiro el parametro del equipo patron correctamente.';
                                    var class_name = 'gritter-success';
                                } else {
                                    var text = 'Ocurrio algo, no se pudo eliminar el parametro al equipo patron.';
                                    var class_name = 'gritter-error';
                                }
                                $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2800});
                            },complete: function () {
                                $("#modalDetele").dialog("close");
                            }, error: function () {
                                alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                            }
                        });
                    }, Cerrar: function () {
                        $(this).dialog("close");
                    }
                }
            });
        }
    });

});