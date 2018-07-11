/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

var oTable;
$(document).ready(function () {

    oTable = $('#listaUnidades').dataTable({
        "pagingType": "numbers",
        "oLanguage": gearsPage.idiomaTablas()
    });

    $('#agregarUnidad').click(function () {
        $('#Codigo').val('');
        $('#Nombre').val('');
        $('#formOpciones').show();
    });

    $('#btnCancel').click(function () {
        $('#Codigo').val('');
        $('#Nombre').val('');
        $('#formOpciones').hide();
    });

    $(document).on('click', '.clsUpda', function () {
        var idData = parseInt($(this).attr('data'));
        if (idData > 0) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Unidades'),
                dataType:'json',
                data: 'id=' + idData + '&accion=dataParam',
                success: function (datos) {
                    console.log(datos);
                    $('#Codigo').val(datos.id);
                    $('#Nombre').val(datos.nombre);
                    $('#formOpciones').show();
                }
            });
        }
    });


    $('#regUnidad').validate({

        submitHandler: function () {
            var str = $('#regUnidad').serialize();
            var cod = $("input[name=Codigo]:hidden").val();
            if (cod > 0) {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Unidades'),
                    data: str + "&accion=Actualizar",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === false) {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro..!';
                            var class_name = 'gritter-error';
                        } else {
                            var text = 'Se actualizo la informacion de la unidad correctamente!';
                            var class_name = 'gritter-success';
                        }
                        $('#Codigo').val('');
                        $('#Nombre').val('');
                        $('#formOpciones').hide();
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
                    url: gearsPage.urlServer('Unidades'),
                    data: str + "&accion=Guardar",
                    beforeSend: function () {
                        $('#AccionLoad').show();
                    }, success: function (datos) {
                        var item = JSON.parse(datos);
                        if (item.respuesta === true) {
                            var text = 'Se Registro la unidad correctamente..!';
                            var class_name = 'gritter-success';
                            $('#Codigo').val('');
                            $('#Nombre').val('');
                            $('#formOpciones').hide();
                        } else if (item.respuesta === false && item.code === 'creada') {
                            var text = 'No Se Completo ta Tarea. Este Nombre ya se encuetra Registrado..!';
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