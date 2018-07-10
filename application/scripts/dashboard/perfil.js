/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */
$(document).ready(function(){

      $('#actualizaClave').validate({
        submitHandler: function () {
            var str = $('#actualizaClave').serialize();
            $.ajax({
                cache: false,type: "POST",
                url: gearsPage.urlServer('Empleados'),
                data: str + "&cedula=" + gearsPage.siCode() + "&accion=cambiarClave",
                beforeSend: function () {
                    $('#AccionLoad').show();
                },success: function (datos) {
                    var item=JSON.parse(datos);
                    if (item.respuesta === false) {
                        $('#mensaje').html("<div class='alert alert-danger'>\n\
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>\n\
                            Error al Actualizar la Clave</div>");
                    } else {
                        $('#updateAcces').hide();
                        $('#clave').val('');
                        $('#reclave').val('');

                        $('#mensaje').html("<div class='alert alert-success'>\n\
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>\n\
                            Se Actualizo la Clave Correctamente</div>");
                    }
                }, complete: function () {
                     $('#AccionLoad').hide();
                }, error: function () {
                    alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                }
            });
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.prev("span").append());
        }});
    
    $('#CambiaAcceso').click( function(){ 
        $('#updateAcces').show();
    });
    
});
