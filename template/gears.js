/* 
 * Copyright (C) 2018 Sistemas Radproct
 *
 * Each line should be prefixed with  * 
 */

gearsPage = {
    siCode() {
        return $('#dtaEmpleado').attr('code')
    },
    baseUrl(accion='') {
        let getUrl = $('#baseRoot').attr('root');
        return getUrl+accion;
    },
    urlServer(file='') {
        let getUrl = $('#baseRoot').attr('root');
        let url = getUrl+'application/server/'+file+'.php';
        return url;
    },
    fnGetSelected(oTableLocal) {
        return oTableLocal.$('tr.selected');
    },
    idiomaTablas() {
        var idioma = {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningun dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Ultimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        };
        return idioma;
    },
    seleccionTablas(tableName,oTable) {
        $('#'+tableName+' tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                oTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
    },
    soloLetras(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = [8];
        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    },
    textoEspecial(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " abcdefghijklmnñopqrstuvwxyz-0123456789";
        especiales = [8];
        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    },
    numerosEspecial(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " -0123456789";
        especiales = [8];
        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    },
    SoloNumeros(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    },
    removeItem(arrar, a) {
        for (i = 0; i < arrar.length; i++) {
            if (arrar[i] == a) {
                for (i2 = i; i2 < arrar.length - 1; i2++) {
                    arrar[i2] = arrar[i2 + 1];
                }
                arrar.length = arrar.length - 1
                return;
            }
        }
    },
    // funcion que busca dentro de la lista de grupos y verifica que no se repitan grupos
    buscar(arrar, item) {
        for (var i = 0; i < arrar.length; i++) {
            if (arrar[i] == item) {
                return true;
            }
        }
        return false;
    }

}