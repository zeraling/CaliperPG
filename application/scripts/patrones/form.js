/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */
$(document).ready(function () {


    $('#btnVolver').click(function () {
        window.location.href = gearsPage.baseUrl('patrones');
    });

    $('#CodMarca').select2({placeholder: 'Seleccione una marca', language: "es"});

    $('#crearequipo').validate({
        submitHandler: function () {
            var str = $('#crearequipo').serialize();
            var cod = parseInt($("#Codigo").val());
            if (cod>0) {
                $.ajax({
                    cache: false,type: "POST",
                    url: gearsPage.urlServer('Equipospatrones'),
                    data: str + "&accion=Actualizar",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    },success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === true) {
                            var text = 'Se Actualizo la Informacion del Equipo patron correctamente.';
                            var class_name = 'gritter-success';
                        } else {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.';
                            var class_name = 'gritter-error';
                        }
                        $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2800});   
                    },complete: function (jqXHR, textStatus) {
                        $('#AccionLoad').hide();
                    },
                    error: function () {
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });
            } else {
                $.ajax({
                    cache: false,type: "POST",
                    url: gearsPage.urlServer('Equipospatrones'),
                    data: str + "&accion=Guardar",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    },success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === true) {
                            var text = 'Se Registro el equipo Correctamente.';
                            var class_name = 'gritter-success';

                            $("#Codigo").val(item.code);
                            $('#Modelo').attr("readonly", true);
                            $('#noSerie').attr("readonly", true);

                        } else if (item.respuesta === false && item.codigo === 'creado') {
                            var text = 'No Se Completo ta Tarea. Este equipo ya se encuentra registrado.';
                            var class_name = 'gritter-warning';
                        } else {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.';
                            var class_name = 'gritter-error';
                        }
                        $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2800});
                    },complete: function () {
                        $('#AccionLoad').hide();
                    },
                    error: function () {
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });
            }
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.prev("span").append());
        }});
});