/* 
 * Copyright (C) 2018 Sistemas Radproct
 *
 * Each line should be prefixed with  * 
 */
      
$(document).ready(function () {

    $('#Login').validate({
        submitHandler: function () {
            var str = $('#Login').serialize();
            var code = $('#codeUser').val();
            if (code > 0) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Empleados'),
                    data: str + "&accion=inicioSesion",
                    beforeSend: function () {
                        $('#loader').show();
                    }, success: function (datos) {
                        var info = JSON.parse(datos)
                        if (info.respuesta === true) {
                            location.href=gearsPage.baseUrl();
                        } else if (info.respuesta === false && info.code === 'Error') {
                            $("#datos").html('<div class="alert alert-warning alert-dismissable">' +
                                '<i class="fa fa-warning"></i>' +
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                'El Usuario o la Contraseña no Coinciden</div>');
                        } else if (info.respuesta === false && info.code === 'Registro') {
                            $("#datos").html('<div class="alert alert-danger">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                'El Usuario no se Encuentra Registrado</div>');
                        }
                    }, complete: function () {
                        $('#loader').hide();
                    }, error: function (resp) {
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });
            } else {
                $("#datos").html('<div class="alert alert-danger">'+
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    'El Codigo del usuario no es valido</div>');
            }
        }
    });

});
