/* 
 *  Copyright (C) 2018 Sistemas 
 *  Sigledo App - Radproct Ltda
 *
 *  Archivo Creado por Zeraling
 */

$(document).ready(function () {

    $('#btnVolver').click(function () {
        window.location.href = gearsPage.baseUrl('usuarios')
    });

    $('#selectEmpleado').select2({
        placeholder: 'Seleccione un empleado',
        language: "es"
    });
    
    $('#consultarFunciones').click(function () {
        var empleado = $('#selectEmpleado option:selected');
        if (empleado.val() > 0) {
            $('#idEmpleado').val(empleado.val());
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Funcionesempleados'),
                data: 'user=' + empleado.val() + '&accion=listaFuncionesUser',
                success: function (data) {
                    var item = JSON.parse(data);
                    if (item.length > 0) {
                        $.each(item, function (i, arar) {
                            if (arar.estado === 1) {
                                $('#' + arar.id).iCheck('check');
                            } else {
                                $('#' + arar.id).iCheck('uncheck');
                            }
                        });
                        var text = 'Usario cargado correctamente!';
                        var class_name = 'gritter-success';
                    } else {
                        var text = 'El empleado no tiene ningun modulo asigando';
                        var class_name = 'gritter-warning';
                    }
                    $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2500});
                },
                error: function (resp) {
                    alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                }
            });
        }
    });

    $('input[type="checkbox"]').on('ifClicked', function (event) {
        var funcion = $('#' + this.id).attr('data');
        var empleado = $('#idEmpleado').val();
        var estado = event.type;
        if (empleado > 0) {
            if ($('#' + this.id).is(':checked')) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Funcionesempleados'),
                    data: 'funcion=' + funcion + '&empleado=' + empleado + '&accion=quitarPermiso',
                    success: function (resp) {
                        var item = JSON.parse(resp);
                        if (item.respuesta === true) {
                            var text = 'Se retiro el permiso #(' + funcion + ') al usuario (' + empleado + ') correctamente!';
                            var class_name = 'gritter-success';
                        } else {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. El permiso no pudo ser retirado!';
                            var class_name = 'gritter-error';
                        }
                        $.gritter.add({title: 'Actualizacion!', text: text, class_name: class_name, sticky: false, time: 2500});
                    }
                });
            } else {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Funcionesempleados'),
                    data: 'funcion=' + funcion + '&empleado=' + empleado + '&accion=asignarPermiso',
                    success: function (resp) {
                        var item = JSON.parse(resp);
                        if (item.respuesta === true) {
                            var text = 'La asigno las funcion #(' + funcion + ') al usuario (' + empleado + ') correctamente.';
                            var class_name = 'gritter-success';
                        } else {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. El permisio no pudo ser asignado!';
                            var class_name = 'gritter-error';
                        }
                        $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2500});
                    }
                });
            }

        } else {
            var text = 'No se han establedo condiciones para la asignacion de funciones del sistema';
            var class_name = 'gritter-warning';
            $.gritter.add({title: 'Actualizacion!', text: text, class_name: class_name, sticky: false, time: 2500});
        }


    }).iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

});