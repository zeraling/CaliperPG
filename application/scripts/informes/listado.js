/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

var oTable;

$(document).ready(function () {

    $('#IdTipoEquipo').select2({placeholder: 'Seleccione unidad', language: "es"});
    $('#IdCliente').select2({placeholder: 'Seleccione un parametro', language: "es"});

    /* Initialise the DataTable */
    oTable = $('#listaCertificados').dataTable({
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "oLanguage": gearsPage.idiomaTablas()
    });

    gearsPage.seleccionTablas('listaCertificados', oTable);

    $('#Nuevo').click(function () {
        window.location.href = gearsPage.baseUrl('informes/form')
    });

    $('#Editar').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val !== '' && val !== undefined) {
                window.location.href = gearsPage.baseUrl('informes/detalles/' + val);
            }
        }
    });

    $('#Borrar').click(function () {

        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val !== '' && val !== undefined) {

                $("#modalDelete").dialog({
                    title: 'Eliminar Informe',
                    resizable: false, //permite cambiar el tamaño
                    width: 340,
                    closeOnEscape: false,
                    modal: true,
                    buttons: {
                        Aceptar: function () {
                            $.ajax({
                                cache: false, type: "POST",
                                url: gearsPage.urlServer('Informes'),
                                data: 'idInfo=' + val + '&accion=eliminaInforme',
                                success: function (resp) {
                                    let accion = JSON.parse(resp)
                                    if (accion.respuesta === true) {
                                        var text = 'Se elimino el informe del sistema correctamete.';
                                        var class_name = 'gritter-success';
                                        oTable.fnClearTable(0);
                                        oTable.fnDraw();
                                    } else {
                                        var text = 'Ocurrio alo y el informe no puede ser eliminado.';
                                        var class_name = 'gritter-error';
                                    }
                                    $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2800});
                                },complete: function () {
                                     $("#modalDelete").dialog("close");
                                }
                            });
                        },
                        cerrar: function () {
                            $(this).dialog("close");
                        }
                    }
                });
            }
        }
    });

    $('#adminPruebas').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val !== '' && val !== undefined) {
                window.location.href = gearsPage.baseUrl('informes/pruebas/' + val);
            }
        }
    });

    $('#Consulta').click(function () {

        oTable.fnClearTable(0);
        oTable.fnDraw();

        var data = {
            cliente: $('#IdCliente').val(),
            equipo: parseInt($('#IdTipoEquipo').val()),
            empresa: parseInt($('#IdEmpresa').val()),
            codigo: parseInt($('#Codigo').val()),
            usuario: gearsPage.siCode()
        };

        if (data.empresa > 0 && (data.codigo > 0 || data.equipo > 0 || data.cliente > 0)) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Informes'),
                data: 'data=' + JSON.stringify(data) + '&accion=consultarInformes',
                beforeSend: function () {
                    $('#AccionLoad').show();
                }, success: function (datos) {
                    var accion = JSON.parse(datos);

                    accion.forEach(function (value) {
                        oTable.fnAddData([
                            value.codigo,
                            value.equipo,
                            value.empresa,
                            value.cliente,
                            value.fecha
                        ]);
                    });
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

    $('#Info').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var informe = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//informe
            if (informe !== '' && informe !== undefined) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Informes'),
                    data: 'idInfo=' + informe + '&accion=infoInforme',
                    success: function (resp) {
                        $('#infoModal').html(resp);
                        $("#infoModal").dialog({
                            title: 'Info Informe:',
                            resizable: false, //permite cambiar el tamaño
                            height: 475, // altura
                            width: 490,
                            closeOnEscape: false,
                            modal: true,
                            buttons: {
                                Informe: function () {
                                    window.open(gearsPage.baseUrl() + 'reports/pdf/informe.php?info=' + informe);
                                }, Certificado: function () {
                                    window.open(gearsPage.baseUrl() + 'reports/pdf/certificado.php?info=' + informe);
                                }, Cerrar: function () {
                                    $(this).dialog("destroy");
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

    $('#InformesPeriodo').click(function () {
        $.ajax({
            cache: false, type: "POST",
            url: UrlServer() + 'Informes.php',
            data: 'accion=PeriodosInformes',
            beforeSend: function () {
                $('#ActionLoad').show();
            }, success: function (resp) {
                $('#infoModal').html(resp);
                $("#infoModal").dialog({
                    title: 'Informes Registrados',
                    resizable: false, //permite cambiar el tamaño
                    height: 280, // altura
                    width: 325,
                    modal: true, //capa principal, fondo opaco
                    buttons: {
                        Generar: function () {
                            var anio = $('#AnioInforme').val();
                            if (anio > 0) {
                                window.open('../reports/xlsInformesCR.php?yy=' + anio);
                            }
                        }, Cerrar: function () {
                            $(this).dialog("destroy");
                        }
                    }
                });
            }, complete: function () {
                $('#ActionLoad').hide();
            },
            error: function (res) {
                console.log(res);
                alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
            }
        });
    });

});
