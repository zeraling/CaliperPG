/* 
 *  Copyright (C) 2018 Sistemas 
 *  CaliperPG App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */


$(function () {

    $('#btnVolver').click(function () {
        window.location.href = gearsPage.baseUrl('informes');
    });
    
    $('#btnPruebas').click(function () {
        let cod = $("#idInforme").val();
        window.location.href = gearsPage.baseUrl('informes/pruebas/'+cod);
    });

    $('#FechaCalibracion').datepicker({language: 'es', daysOfWeekHighlighted: "0,6", todayHighlight: true, autoclose: true, format: "dd/mm/yyyy"});
    $('#FechaRecepcion').datepicker({language: 'es', daysOfWeekHighlighted: "0,6", todayHighlight: true, autoclose: true, format: "dd/mm/yyyy"});

    $('#formInforme').validate({
        submitHandler: function () {
            var str = $('#formInforme').serialize();
            var cod = $("#idInforme").val();
            if (cod !== '') {
                $.ajax({
                    cache: false, type: "POST",
                    url: gearsPage.urlServer('Informes'),
                    data: str + "&accion=actualizarInforme&siCode=" + gearsPage.siCode(),
                    beforeSend: function () {
                        $('#AccionLoad').removeClass('hide');
                        //$('#btnGuardar').addClass('hide');
                    }, success: function (datos) {
                        var accion = JSON.parse(datos);
                        if (accion.respuesta === true) {
                            var text = 'Se actualizaron los datos del informe correctamente.';
                            var class_name = 'gritter-success';
                        } else if (accion.respuesta === false && accion.codigo === 'noDisponible') {
                            var text = 'No Se Completo ta Tarea. El informe no se encuentra disponible.';
                            var class_name = 'gritter-warning';
                        } else {
                            var text = 'Ocurrio un Error, No Se Completo ta Tarea. No se Altero Ningun Registro.';
                            var class_name = 'gritter-error';
                        }
                        $.gritter.add({title: 'Registro!', text: text, class_name: class_name, sticky: false, time: 2500});
                    }, complete: function () {
                        $('#AccionLoad').addClass('hide');
                    }, error: function (err) {
                        console.log(err);
                        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
                    }
                });
            }
        }
    });

});