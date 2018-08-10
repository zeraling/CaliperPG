/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */


$(document).ready(function () {
// Validar Formulario

    $('#btnVolver').click(function () {
        location.href = gearsPage.baseUrl('parametros');
    });

    $('#parametros').select2({language: 'es', placeholder: 'Seleccione parametros'});

    $('#regParametros').validate({

        submitHandler: function () {
            var str = $('#regParametros').serialize();
            var cod = $("input[name=Codigo]:hidden").val();
            if (cod > 0) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Tiposeequipos'),
                    data: str + "&accion=Actualizar",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === false) {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro..!';
                            var class_name = 'gritter-error';
                        } else {
                            var text = 'Se actualizo la informacion del tipo de equipo correctamente!';
                            var class_name = 'gritter-success';
                        }
                        $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2500});
                    },complete: function () {
                         $('#AccionLoad').hide();
                    },
                    error: function () {
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });
            } else {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Tiposeequipos'),
                    data: str + "&accion=Guardar",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === true) {
                            var text = 'Se registro el tipo de equipo correctamente!';
                            var class_name = 'gritter-success';
                            $("input[name=Codigo]:hidden").val(item.code);
                        } else if (item.respuesta === false && item.code === 'creado') {
                            var text = 'No Se Completo ta Tarea. La este tipo ya se encuentra creado..!';
                            var class_name = 'gritter-warning';
                        } else {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro..!';
                            var class_name = 'gritter-error';
                        }
                        $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2500});
                       
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
        }
    });
});


