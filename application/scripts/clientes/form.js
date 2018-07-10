/* 
 * Copyright (C) 2017 Sistemas CR EQUIPOS
 *
 * Each line should be prefixed with  * 
 */


function limpiar() {
    $("#datos").html('');
    limpiarformulario("#crearcliente");
    $("input[name=Nit]").removeAttr("readonly");
}

$(document).ready(function () {
    
    $('#btnVolver').click(function () {
        location.href=gearsPage.baseUrl('clientes')
    });
    
    $('#ciudad').select2({placeholder: 'Seleccione una ciudad', language: "es"});

    $('#departamento').select2({
        placeholder: 'Seleccione departamento',
        language: "es"
    }).on('change', function (event, ciudad) {
        var departamento = this.value;
        if (departamento > 0) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Ciudades'),
                data: 'departamento=' + departamento + '&accion=cargarciudad',
                beforeSend: function () {
                    $('#departamento').select2("enable", false);
                }, success: function (resp) {
                    var item = JSON.parse(resp);
                    $("#ciudad").select2("destroy");
                    if (item.length > 0) {
                        $("#ciudad").html("<option><option>");
                        for (let i = 0; i < item.length; i++) {
                            let select = ciudad > 0 && ciudad === item[i].id ? 'selected="selected"' : '';
                            $('#ciudad').append('<option value="' + item[i].id + '" ' + select + '>' + item[i].nombre + '</option');
                        }
                    } else {
                        $("#ciudad").html("<option value=''>Seleccione Una</option>");
                    }
                    $('#ciudad').select2({placeholder: 'Seleccione una Ciudad', language: "es"});
                }, complete: function () {
                    $('#departamento').select2("enable");
                }
            });
        }
    });

    $('#crearcliente').validate({
        submitHandler: function () {
            var str = $('#crearcliente').serialize();
            var cod = $("input[name=Codigo]:hidden").val();
            if (cod !== '') {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Clientes'),
                    data: str + "&accion=Actualiza",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === false) {
                            $("#datos").html("<div class='alert alert-danger alert-dismissable'>\n\
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>\n\
                                Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.\n\
                            </div>");
                        } else {
                            $("#datos").html("<div class='alert alert-success alert-dismissable'>\n\
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>\n\
                                    Se Actualizo la Informacion del Equipo con El NIT: " + item.code + " Correctamente \n\
                                </div>");
                        }
                        $('#AccionLoad').hide();
                    },
                    error: function () {
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });

            } else {

                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Clientes'),
                    data: str + "&accion=Guardar",
                    beforeSend: function () {
                        $('#AccionLoad').hide();
                    }, success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === true) {
                            $("input[name=Codigo]:hidden").val(item.code);
                            $("#datos").html("<div class='alert alert-success alert-dismissable'>\n\
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>\n\
                                    Se Registro El Cliente con el NIT: " + item.code + " Correctamente \n\
                                </div>");
                            $("input[name=Nit]").attr("readonly", "true");
                            $("input[name=dv]").attr("readonly", "true");
                        } else if (item.respuesta === false && item.code === 'noNit') {
                            $("#datos").html("<div class='alert alert-danger alert-dismissable'>\n\
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>\n\
                                No Se Completo ta Tarea. Esta cliente ya esta registrado.\n\
                            </div>");
                        } else {
                            $("#datos").html("<div class='alert alert-danger alert-dismissable'>\n\
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>\n\
                                No Se Completo ta Tarea. Orrurio un problema interno!.\n\
                            </div>");
                        }
                        $('#AccionLoad').hide();
                    },
                    error: function () {
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });
            }
        }, errorPlacement: function (error, element) {
            error.appendTo(element.prev("span").append());
        }});
});