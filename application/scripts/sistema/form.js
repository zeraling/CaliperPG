/* 
 *  Copyright (C) 2018 Sistemas 
 *  Sigledo App - Radproct Ltda
 *
 *  Archivo Creado por Zeraling
 */


function limpiar() {
    limpiarformulario("#registrarusuarios");
    $("input[name=Cedula]").removeAttr("readonly");
}


$(document).ready(function(){
// Validar Formulario

    $('#btnVolver').click(function () {
        location.href=gearsPage.baseUrl('usuarios');
    });
    
    $('#empresas').select2({language: 'es',placeholder:'Seleccione empresa'});

    $('#registrarusuarios').validate({

        submitHandler: function () {
            var str = $('#registrarusuarios').serialize();
            var cod = $("input[name=Codigo]:hidden").val();
            if (cod > 0) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Empleados'),
                    data: str + "&accion=Actualizar",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === false) {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro..!';
                            var class_name = 'gritter-error';
                        } else {
                            var text = 'e Actualizo la Informacion del Usuario con la Cedula: ' + item.code + ' Correctamente!';
                            var class_name = 'gritter-success';
                        }
                        $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2500});
                        $('#AccionLoad').hide();
                    },
                    error: function () {
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });
            } else {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Empleados'),
                    data: str + "&accion=Guardar",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === true) {

                            var text = 'Se Registro El Usuario con la Cedula ' + item.code + ' Correctamente..!';
                            var class_name = 'gritter-success';

                            $("input[name=Codigo]:hidden").val(item.code);
                            $("input[name=Cedula]").attr("readonly", "true");

                        } else if (item.respuesta === false && item.code === 'noDisponible') {
                            var text = 'No Se Completo ta Tarea. La Indentificacion No esta disponible..!';
                            var class_name = 'gritter-warning';
                        } else {

                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro..!';
                            var class_name = 'gritter-error';

                        }
                        $.gritter.add({title: 'Confirmacion!', text: text, class_name: class_name, sticky: false, time: 2500});
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

