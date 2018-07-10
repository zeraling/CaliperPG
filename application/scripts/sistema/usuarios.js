/* 
 *  Copyright (C) 2018 Sistemas 
 *  Sigledo App - Radproct Ltda
 *
 *  Archivo Creado por Zeraling
 */

var oTable;

$(document).ready(function () {

    

    oTable = $('#listausuarios').dataTable({
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "oLanguage": gearsPage.idiomaTablas()
    });
    gearsPage.seleccionTablas('listausuarios',oTable);

    $('#Nuevo').click(function () {
        window.location.href = gearsPage.baseUrl('usuarios/form');
    });

    $('#Actualizar').click(function () {

        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = parseInt($(anSelected)[0].cells[0].childNodes[0].attributes[0].value); //codigo
            if (val > 0) {
                window.location.href = gearsPage.baseUrl('usuarios/form/'+val);
            }
        }
    });

    $('#Consulta').click(function () {

        oTable.fnClearTable(0);
        oTable.fnDraw();

        var data = {
            estado: parseInt($('#CodEstadoEmpleado').val()),
            cargo: parseInt($('#IdCargo').val()),
            codigo: parseInt($('#Cedula').val()),
            usuario: gearsPage.siCode()
        };

        if (data.cargo > 0 || data.codigo > 0 || data.estado > 0) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Estadosempleados'),
                data: 'data=' + JSON.stringify(data) + '&accion=Consultar',
                beforeSend: function () {
                    $('#AccionLoad').show();
                }, success: function (datos) {
                    var accion = JSON.parse(datos);
                    if (accion.length) {
                        for (var i = 0; i < accion.length; i++) {
                            oTable.fnAddData([
                                accion[i].opciones,
                                accion[i].nombre,
                                accion[i].apellido,
                                accion[i].estado
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

    $('#Ver').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = parseInt($(anSelected)[0].cells[0].childNodes[0].attributes[0].value ); //codigo
            if (val > 0) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Empleados'),
                    data: 'id=' + val + '&accion=info',
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (resp) {
                        $('#datos').html(resp);
                        $("#datos").dialog({
                            title: 'Info Usuario',
                            resizable: false, //permite cambiar el tamaño
                            height: 320, // altura
                            width: 400,
                            modal: true
                        });
                    }, complete: function () {
                        $('#AccionLoad').hide();
                    }
                });
            }
        }
    });
    $('#Restablecer').click(function () {
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = parseInt($(anSelected)[0].cells[0].childNodes[0].attributes[0].value); //codigo
            if (val > 0) {
                $("#dialog-confirm").dialog({
                    resizable: false,
                    height: 180,
                    modal: true,
                    buttons: {
                        Confirmar: function () {
                            $.ajax({
                                type: "POST", cache: false,
                                url: gearsPage.urlServer('Estadosempleados'),
                                data: 'cedulaRed=' + val + '&accion=restablecer',
                                success: function (resp) {
                                    var item = JSON.parse(resp);
                                    if (item.respuesta === true) {
                                        $('#datosInfo').html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button>Se Restablecio la Clave Correctamente.<strong></strong></div>");
                                    } else {
                                        $('#datosInfo').html("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button>No se Pudo Restablecer la Clave.<strong></strong></div>");
                                    }
                                    $("#dialog-confirm").dialog("close");
                                }
                            });
                        },Cancel: function () {
                            $(this).dialog("close");
                        }
                    }
                });
            }
        }

    });
    $('#Estado').click(function () {
        $("#datosInfo").html();
        var anSelected = gearsPage.fnGetSelected(oTable);
        if (anSelected.length > 0) {
            var val = parseInt($(anSelected)[0].cells[0].childNodes[0].attributes[0].value); //codigo
            var estado = parseInt($(anSelected)[0].cells[0].childNodes[0].attributes[1].value); //estado
            var cambio = false;
            if (val > 0) {
                if (estado === 1) {
                    cambio = 2;
                    $("#dialogoEstado").html('<div class="form-group">¿Está seguro que desea inactivar este usuario?</div>');
                } else {
                    cambio = 1;
                    $("#dialogoEstado").html('<div class="form-group">¿Está seguro que desea activar este usuario?</div>');
                }
                $("#dialogoEstado").dialog({
                    resizable: false, //permite cambiar el tamaño
                    width: 250,
                    modal: true, //capa principal, fondo opaco
                    buttons: {
                        Cambiar: function () {
                            $.ajax({
                                cache: false, type: "POST",
                                url: gearsPage.urlServer('Estadosempleados'),
                                data: 'id=' + val + '&estado=' + cambio + '&accion=cambiarestado',
                                success: function (resp) {
                                    var item = JSON.parse(resp);
                                    if (item.respuesta === true) {
                                        $("#dialogoEstado").dialog("close");
                                        $("#datosInfo").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Estado Actualizado</div>');
                                    } else {
                                        $("#dialogoEstado").dialog("close");
                                        $("#datosInfo").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Estado Estado no Actualizado</div>');
                                    }
                                    oTable.fnClearTable(0);
                                    oTable.fnDraw();
                                }
                            });
                        }, Cerrar: function () {
                            $(this).dialog("close");
                        }
                    }
                });
            }
        }
    });
    $('#Permisos').click(function () {
        window.location.href = gearsPage.baseUrl('usuarios/permisos');
    });

});