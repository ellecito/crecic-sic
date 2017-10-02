$(document).ready(function () {

    $(".estado").click(function (e) {
        e.preventDefault();
        var codigo = $(this).attr('rel');

        noty({
            layout: 'topCenter',
            fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>',
            text: '¿Está seguro que desea enviar este estudio de factibilidad a revisión?',
            buttons: [{
                addClass: 'btn btn-primary', text: 'Aceptar', onClick: function ($noty) {
                    $noty.close();
                    $(window).unbind('beforeunload');
                    noty({
                        text: 'El estudio de factibilidad se esta enviando. Por favor, espere un momento.',
                        layout: 'topCenter',
                        type: 'alert',
                        killer: true,
                        closeWith: [],
                        template: '<div class="noty_message"><img src="/crecic/sic/assets/img/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
                        fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
                    });
                    $.ajax({
                        type: "POST",
                        data: "codigo=" + codigo,
                        dataType: "json",
                        url: window.location.pathname + "/estados/",
                        success: function (json) {
                            if (json.result) {
                                noty({
                                    text: "Estudio de factibilidad enviado con éxito. Por favor, espere revisión.",
                                    layout: 'topCenter',
                                    type: 'success',
                                    killer: true
                                });
                                setTimeout(function () {
                                    window.location.href = window.location.pathname;
                                }, 1000);
                            } else {
                                var error = noty({
                                    text: json.msg,
                                    layout: 'topCenter',
                                    type: 'error',
                                    timeout: 2000
                                });
                            }
                        }
                    });
                }
            },
            {
                addClass: 'btn btn-danger', text: 'Cancelar', onClick: function ($noty) {
                    $noty.close();
                }
            }]
        });
    });

    $(".eliminar").click(function (e) {
        e.preventDefault();
        var codigo = $(this).attr('rel');

        noty({
            layout: 'topCenter',
            fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>',
            text: '¿Está seguro que desea eliminar este estudio de factibilidad?',
            buttons: [{
                addClass: 'btn btn-primary', text: 'Aceptar', onClick: function ($noty) {
                    $noty.close();
                    $(window).unbind('beforeunload');
                    noty({
                        text: 'El estudio de factibilidad se esta eliminando. Por favor, espere un momento.',
                        layout: 'topCenter',
                        type: 'alert',
                        killer: true,
                        closeWith: [],
                        template: '<div class="noty_message"><img src="/crecic/sic/assets/img/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
                        fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
                    });
                    $.ajax({
                        type: "POST",
                        data: "codigo=" + codigo,
                        dataType: "json",
                        url: window.location.pathname + "/eliminar/",
                        success: function (json) {
                            if (json.result) {
                                noty({
                                    text: "Estudio de factibilidad eliminado con éxito.",
                                    layout: 'topCenter',
                                    type: 'success',
                                    killer: true
                                });
                                setTimeout(function () {
                                    window.location.href = window.location.pathname;
                                }, 1000);
                            } else {
                                var error = noty({
                                    text: json.msg,
                                    layout: 'topCenter',
                                    type: 'error',
                                    timeout: 2000
                                });
                            }
                        }
                    });
                }
            },
            {
                addClass: 'btn btn-danger', text: 'Cancelar', onClick: function ($noty) {
                    $noty.close();
                }
            }]
        });
    });

    $(".visar").click(function (e) {
        e.preventDefault();
        var codigo = $(this).attr('rel');

        noty({
            layout: 'topCenter',
            fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>',
            text: '¿Está seguro que desea visar este estudio de factibilidad?',
            buttons: [{
                addClass: 'btn btn-primary', text: 'Aceptar', onClick: function ($noty) {
                    $noty.close();
                    $(window).unbind('beforeunload');
                    noty({
                        text: 'El estudio de factibilidad se esta visando. Por favor, espere un momento.',
                        layout: 'topCenter',
                        type: 'alert',
                        killer: true,
                        closeWith: [],
                        template: '<div class="noty_message"><img src="/crecic/sic/assets/img/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
                        fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
                    });
                    $.ajax({
                        type: "POST",
                        data: "codigo=" + codigo,
                        dataType: "json",
                        url: window.location.pathname + "/visar/",
                        success: function (json) {
                            if (json.result) {
                                noty({
                                    text: "Estudio de factibilidad visado con éxito.",
                                    layout: 'topCenter',
                                    type: 'success',
                                    killer: true
                                });
                                setTimeout(function () {
                                    window.location.href = window.location.pathname;
                                }, 1000);
                            } else {
                                var error = noty({
                                    text: json.msg,
                                    layout: 'topCenter',
                                    type: 'error',
                                    timeout: 2000
                                });
                            }
                        }
                    });
                }
            },
            {
                addClass: 'btn btn-danger', text: 'Cancelar', onClick: function ($noty) {
                    $noty.close();
                }
            }]
        });
    });
});  