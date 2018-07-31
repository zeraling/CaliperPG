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
    
    gearsPage.seleccionTablas('listaCertificados',oTable);

    $('#Nuevo').click(function () {
        window.location.href = gearsPage.baseUrl('informes/form')
    });

    $('#Editar').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
                window.location.href = gearsPage.baseUrl('informes/form/' + val);
            }
        }
    });
    
    $('#Pruebas').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = $(anSelected)[0].cells[0].childNodes[0].attributes[0].value;//codigo
            if (val > 0) {
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
        
        if ( data.codigo > 0 || data.equipo > 0||(data.empresa >0 && data.cliente >0)) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Informes'),
                data: 'data=' + JSON.stringify(data) + '&accion=Consultar',
                beforeSend: function () {
                    $('#AccionLoad').show();
                }, success: function (datos) {
                    var accion = JSON.parse(datos);
                    if (accion.length) {
                        for (var i = 0; i < accion.length; i++) {
                            oTable.fnAddData([
                                accion[i].codigo,
                                accion[i].equipo,
                                accion[i].fecha,
                                accion[i].cliente
                            ]);
                        }
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
    
    $('#Info').click(function () {

        var anSelected = gearsPage.fnGetSelected(oTable);

        if (anSelected.length > 0) {
            var val = parseInt($(anSelected)[0].cells[0].children[0].id); //codigo
            if (val > 0) {

                $.ajax({
                    cache: false, type: "POST",
                    url: UrlServer() + 'Informes.php',
                    data: 'idInfo=' + val + '&accion=info',
                    success: function (resp) {
                        $('#infoModal').html(resp);
                        $("#infoModal").dialog({
                            title: 'Info Informe: ' + val,
                            resizable: false, //permite cambiar el tamaño
                            height: 475, // altura
                            width: 490,
                            closeOnEscape: false,
                            modal: true,
                            buttons: {
                                Certificado: function () {
                                    window.open('../reports/calibracionCR.php?id=' + val);
                                }, Cumplimiento: function () {
                                    window.open('../reports/cumplimientoCR.php?id=' + val);
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
    

    $('#Borrar').click(function () {

        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = parseInt($(anSelected)[0].cells[0].children[0].id); //codigo

            if (val > 0) {

                $("#detele1").dialog({
                    title: 'Eliminar Certificado',
                    resizable: false, //permite cambiar el tamaño
                    width: 340,
                    closeOnEscape: false,
                    modal: true,
                    buttons: {
                        aceptar: function () {
                            $.ajax({
                                cache: false, type: "POST",
                                url: UrlServer() + 'Informes.php',
                                data: 'idDel=' + val + '&accion=Delete',
                                success: function (resp) {
                                    oTable.fnClearTable(0);
                                    oTable.fnDraw();
                                    $("#detele1").dialog("close");
                                }
                            });
                        },
                        cerrar: function () {
                            $(this).dialog("close");
                            // Remove the left over element (the original div element)
                        }
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
                            if (anio>0) {
                                window.open('../reports/xlsInformesCR.php?yy='+anio);
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
