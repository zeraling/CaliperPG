/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

$(document).ready(function () {

    $('#btnVolver').click(function () {
        window.location.href = gearsPage.baseUrl('informes');
    });

    $('#IdCliente').select2({
        placeholder: 'Seleccione un cliente',
        language: "es"
    }).on('change', function (e) {
        var cliente = this.value;
        if (cliente > 0) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Clientes'),
                data: 'codCliente=' + cliente + '&accion=dataCliente',
                success: function (resp) {
                    var item = JSON.parse(resp);
                    if (item) {
                        $("#detalCliente").html(item.nombre + '<br>' +item.nit + '<br>' +item.direccion + '<br>' +item.telefono + '<br>' +item.ciudad);
                    } else {
                        $("#detalCliente").html('Informacion del Cliente')
                    }
                }
            });
        }
    });

    $('#IdTipoEquipo').select2({
        placeholder: 'Seleccione un tipo', language: "es"
    }).on('change', function (e) {
        var tipo = this.value;
        if (tipo > 0) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Tiposeequipos'),
                data: 'tipo=' + tipo + '&accion=cargarProductosTipo',
                beforeSend: function () {
                    $('#IdTipoEquipo').select2("enable", false);
                    $("#CodEquipo").select2("destroy");
                }, success: function (resp) {
                    var item = JSON.parse(resp);
                    console.log(item);
                    var datosSelect = '<option><option>';
                    if (item.length > 0) {
                        item.forEach(function (value) {
                            datosSelect += '<option value="' + value.codigo + '">' + value.descripcion + ' ' + value.serie + '</option>';
                        })
                    }
                    $("#CodEquipo").html(datosSelect);
                    $('#CodEquipo').select2({placeholder: 'Seleccione un equipo', language: "es"});
                }, complete: function () {
                    $('#IdTipoEquipo').select2("enable");
                }
            });
        }
    });

    $('#CodEquipo').select2({placeholder: 'Seleccione una equipo', language: "es"});


    //Verificar No
    $('#verificarNo').click(function () {
        var no = parseInt($('#numero').val());
        var empresa = parseInt($('#IdEmpresa').val());
        if (no > 0 && empresa > 0) {
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Informes'),
                data: 'informe=' + no + '&empresa=' + empresa + '&accion=verificarNo',
                success: function (resp) {
                    var item = JSON.parse(resp);
                    if (item.respuesta) {
                        $("#datosInfo").html('');
                        $('#numero').attr("readonly", "true");
                        $("#opNumero").hide();
                    } else {
                        $("#datosInfo").html('<div class="alert alert-danger alert-dismissable">\n\
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n\
                                El Certificado Con el Numero ' + no + ' ya se Encuentra Creado.\n\
                          </div>');
                    }
                }
            });
        } else {
            $("#datosInfo").html('<div class="alert alert-warning alert-dismissable">\n\
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n\
                Digite el No de Certificado a Generar.</div>');
        }
    });


    $('#registrarInforme').validate({
        submitHandler: function () {
            var str = $('#registrarInforme').serialize();
            $.ajax({
                cache: false, type: "POST",
                url: gearsPage.urlServer('Informes'),
                data: str + "&accion=guardarInforme&siCode=" + gearsPage.siCode(),
                beforeSend: function () {
                    $('#AccionLoad').removeClass('hide');
                    $('#btnGuardar').addClass('hide');
                }, success: function (datos) {
                    var accion = JSON.parse(datos);
                    if (accion.respuesta === true) {
                        location.replace(gearsPage.baseUrl('informes/detalles/' + accion.informe));
                    } else if (accion.respuesta === false && accion.codigo === 'noDisponible') {
                        var text = 'No Se Completo ta Tarea. El informe no se encuentra disponible.';
                        var class_name = 'gritter-warning';
                        $.gritter.add({title: 'Registro!', text: text, class_name: class_name, sticky: false, time: 2500});
                    } else {
                        var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.';
                        var class_name = 'gritter-error';
                        $.gritter.add({title: 'Registro!', text: text, class_name: class_name, sticky: false, time: 2500});
                    }
                }, complete: function () {
                    $('#AccionLoad').addClass('hide');
                }, error: function (err) {
                    console.log(err);
                    alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                }
            });
        }
    });
});