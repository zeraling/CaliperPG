/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */
$(document).ready(function () {


    $('#btnVolver').click(function () {
        window.location.href = gearsPage.baseUrl('equipos');
    });

    $('#IdTipoEquipo').select2({placeholder: 'Seleccione un tipo', language: "es"});
    $('#CodMarca').select2({placeholder: 'Seleccione una marca', language: "es"});

    $('#registrarEquipo').validate({
        submitHandler: function () {
            var str = $('#registrarEquipo').serialize();
            var cod = parseInt($("input[name=Codigo]:hidden").val());
            if (cod>0) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Equipos'),
                    data: str + "&accion=Actualizar",
                    beforeSend: function () {
                        $('#AccionLoad').removeClass('hide');
                        $('#btnGuardar').attr('disabled', true);
                    }, success: function (datos) {
                        var accion = JSON.parse(datos);
                        if (accion.respuesta === true) {
                            var text = 'Se Actualizo la Informacion del equipo Correctamente';
                            var class_name = 'gritter-success';
                        } else {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.';
                            var class_name = 'gritter-error';
                        }
                        $.gritter.add({title: 'Actualizacion!', text: text, class_name: class_name, sticky: false, time: 2500});
                    }, complete: function () {
                        $('#AccionLoad').addClass('hide');
                        $('#btnGuardar').removeAttr('disabled');
                    }, error: function (err) {
                        console.log(err);
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });

            } else {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Equipos'),
                    data: str +"&accion=Guardar",
                    beforeSend: function () {
                        $('#AccionLoad').removeClass('hide');
                        $('#btnGuardar').attr('disabled', true);
                    }, success: function (datos) {
                        var accion = JSON.parse(datos);
                        if (accion.respuesta === true) {
                            var text = 'Se Registro el equipo Correctamente.';
                            var class_name = 'gritter-success';

                            $("input[name=Codigo]:hidden").val(accion.codigo);
                            $('#Modelo').attr("readonly", true);

                        } else if (accion.respuesta === false && accion.codigo === 'creado') {
                            var text = 'No Se Completo ta Tarea. Este equipo ya se encuentra registrado.';
                            var class_name = 'gritter-warning';
                        } else {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.';
                            var class_name = 'gritter-error';
                        }
                        $.gritter.add({title: 'Registro!', text: text, class_name: class_name, sticky: false, time: 2500});
                    }, complete: function () {
                        $('#AccionLoad').addClass('hide');
                        $('#btnGuardar').removeAttr('disabled');
                    }, error: function (err) {
                        console.log(err);
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });
            }
        }
    });
});