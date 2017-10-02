$(document).ready(function () {
    /* Subtotal */
    $("html").on("change", "input[name='unitario[]']", function () {
        "use strict";
        var unitario = parseInt($(this).val());
        var adicional = parseInt($(this).parent(".col-lg-2").siblings(".col-lg-2").children("input[name='adicional[]']").val());
        if (isNaN(unitario)) {
            unitario = 0;
            $(this).val(0);
        }
        if (isNaN(adicional)) {
            adicional = 0;
            $(this).parent(".col-lg-2").siblings(".col-lg-2").children("input[name='adicional[]']").val(0);
        }
        $(this).parent(".col-lg-2").siblings(".col-lg-2").children("input[name='subtotal[]']").val((unitario + adicional));
        total_unitario();
        subtotal();
    });
    /* Adicional */
    $("html").on("change", "input[name='adicional[]']", function () {
        "use strict";
        var adicional = parseInt($(this).val());
        var unitario = parseInt($(this).parent(".col-lg-2").siblings(".col-lg-2").children("input[name='unitario[]']").val());
        if (isNaN(unitario)) {
            unitario = 0;
            $(this).parent(".col-lg-2").siblings(".col-lg-2").children("input[name='unitario[]']").val(0);
        }
        if (isNaN(adicional)) {
            adicional = 0;
            $(this).val(0);
        }
        $(this).parent(".col-lg-2").siblings(".col-lg-2").children("input[name='subtotal[]']").val((unitario + adicional));
        subtotal();
    });

    function total_unitario() {
        "use strict";
        var total = 0;
        $.each($("input[name='unitario[]"), function (key, subtotal) {
            if (!isNaN(parseInt($(subtotal).val()))) {
                total += parseInt($(subtotal).val());
            }
        });
        $("#total_u").val(total);
    }

    function subtotal() {
        "use strict";
        var total = 0;
        $.each($("input[name='subtotal[]"), function (key, subtotal) {
            if (!isNaN(parseInt($(subtotal).val()))) {
                total += parseInt($(subtotal).val());
            }
        });
        $("#total").val(total);
        $("#costos_directos").val(total);
        $("#gasto_total").val(parseInt($("#costos_fijos").val()) + total);
    }

    $("#porcentaje_cf").change(function () {
        "use strict";
        var ingreso_ventas = $("#ingreso_ventas").val();
        $("#costos_fijos").val(ingreso_ventas * ($("#porcentaje_cf").val() / 100));
        $("#gasto_total").val((ingreso_ventas * ($("#porcentaje_cf").val() / 100)) + $("#total").val());
        $("#utilidad_bruta").val(ingreso_ventas - parseInt($("#gasto_total").val()));
    });

    /*$("#porcentaje_ca").change(function () {
        "use strict";
        var ingreso_ventas = $("#ingreso_ventas").val();
        $("#costos_fijos").val(ingreso_ventas * ($("#porcentaje_cf").val() / 100));
        $("#gasto_total").val((ingreso_ventas * ($("#porcentaje_cf").val() / 100)) + $("#total").val());
    });*/
});