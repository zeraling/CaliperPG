/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

$(document).ready(function () {

    $('#fechaActual').datepicker({language: 'es', daysOfWeekHighlighted: "0,6", todayHighlight: true, autoclose: true, format: "dd/mm/yyyy"});
    $('#fechaProxima').datepicker({language: 'es', daysOfWeekHighlighted: "0,6", todayHighlight: true, autoclose: true, format: "dd/mm/yyyy"});
 
    $('#btnVolver').click(function () {
        window.location.href = gearsPage.baseUrl('patrones');
    });

    $('#cargaEspecial').click(function () {
        $("#infoModal1").dialog({
            title: 'Fecha Nulla',
            resizable: false, //permite cambiar el tamaño
            width: 350,
            modal: true, //capa principal, fondo opaco
            buttons: {
                Continuar: function () {
                    $('#aplica').val(0);
                    var str = $('#cargarFecha').serialize();
                    $.ajax({
                        cache: false, type: "POST",
                        url: gearsPage.urlServer('Calibracionespatrones'),
                        data: str + "&accion=GuardarFechaNula",
                        beforeSend: function () {
                            $('#AccionLoad').show();
                        }, success: function (datos) {
                            var item = JSON.parse(datos);
                            if (item.respuesta === true) {
                                var text = 'Se Registro la fecha del patron Correctamente.';
                                var class_name = 'gritter-success';

                                $('#fechaActual').val('');
                                $('#fechaProxima').val('');

                            } else if (item.respuesta === false && item.codigo === 'creado') {
                                var text = 'No Se Completo ta Tarea. Este equipo ya se encuentra registrado.';
                                var class_name = 'gritter-warning';
                            } else {
                                var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.';
                                var class_name = 'gritter-error';
                            }
                            $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2800});
                        }, complete: function () {
                            $('#AccionLoad').hide();
                            $("#infoModal1").dialog("destroy");
                        },
                        error: function () {
                            alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                        }
                    });
        
                },
                Cerrar: function () {
                    $(this).dialog("destroy");
                }
            }
        });
    })


    $('#cargarFecha').validate({
        submitHandler: function () {
            var str = $('#cargarFecha').serialize();
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Calibracionespatrones'),
                data: str + "&accion=GuardarFecha",
                beforeSend: function () {
                    $('#AccionLoad').show();
                }, success: function (datos) {
                    var item = JSON.parse(datos);
                    if (item.respuesta === true) {
                        var text = 'Se Registro la fecha del patron Correctamente.';
                        var class_name = 'gritter-success';
                        
                        $('#fechaActual').val('');
                        $('#fechaProxima').val('');

                    } else if (item.respuesta === false && item.codigo === 'creado') {
                        var text = 'No Se Completo ta Tarea. Este equipo ya se encuentra registrado.';
                        var class_name = 'gritter-warning';
                    } else {
                        var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.';
                        var class_name = 'gritter-error';
                    }
                    $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2800});
                }, complete: function () {
                    $('#AccionLoad').hide();
                },
                error: function () {
                    alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                }
            });
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.prev("span").append());
        }});


})
