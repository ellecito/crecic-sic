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

        var total_ingreso = parseInt($("#total_ingreso").val());
        if (isNaN(total_ingreso)) total_ingreso = 0;
        $(this).parent(".col-lg-2").siblings(".col-lg-1").children("input[name='porcentaje[]']").val((unitario + adicional) / total_ingreso);
        total_unitario();
        total_porcentaje();
        subtotal();
    });

    /*VH Relator*/
    $("html").on("change", "input[name='unitario[]']:first", function () {
        var unitario = parseInt($(this).val());
        if (isNaN(unitario)) {
            unitario = 0;
            $(this).val(0);
        }
        $("#valor_hh_r").val(unitario);
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

        var total_ingreso = parseInt($("#total_ingreso").val());
        if (isNaN(total_ingreso)) total_ingreso = 0;
        $(this).parent(".col-lg-2").siblings(".col-lg-1").children("input[name='porcentaje[]']").val((unitario + adicional) / total_ingreso);
        subtotal();
        total_porcentaje();
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

    function total_porcentaje() {
        "use strict";
        var total = 0;
        $.each($("input[name='porcentaje[]"), function (key, subtotal) {
            if (!isNaN(parseInt($(subtotal).val()))) {
                total += parseInt($(subtotal).val());
            }
        });
        $("#total_p").val(total);
    }

    function subtotal() {
        "use strict";
        var total = 0;
        $.each($("input[name='subtotal[]"), function (key, subtotal) {
            if (!isNaN(parseInt($(subtotal).val()))) {
                total += parseInt($(subtotal).val());
            }
        });

        var costos_fijos = parseInt($("#costos_fijos").val());
        var ingreso_ventas = parseInt($("#ingreso_ventas").val());
        var gasto_total = parseInt($("#gasto_total").val());
        var porcentaje_ca = parseInt($("#porcentaje_ca").val());
        var utilidad_bruta = parseInt($("#utilidad_bruta").val());
        var total_ingreso = parseInt($("#total_ingreso").val());
        var costos_directos = parseInt($("#costos_directos").val());
        var comision_asesor = parseInt($("#comision_asesor").val());

        if (isNaN(costos_fijos)) costos_fijos = 0;
        if (isNaN(ingreso_ventas)) ingreso_ventas = 0;
        if (isNaN(gasto_total)) gasto_total = 0;
        if (isNaN(porcentaje_ca)) porcentaje_ca = 0;
        if (isNaN(utilidad_bruta)) utilidad_bruta = 0;
        if (isNaN(total_ingreso)) total_ingreso = 0;
        if (isNaN(costos_directos)) costos_directos = 0;
        if (isNaN(comision_asesor)) costos_directos = 0;

        $("#total").val(total);
        $("#costos_directos").val(total);
        $("#gasto_total").val(parseInt(costos_fijos) + total);
        $("#utilidad_bruta").val(ingreso_ventas - parseInt($("#gasto_total").val()));
        $("#comision_asesor").val((porcentaje_ca / 100) * parseInt($("#utilidad_bruta").val()));
        $("#beneficio_neto").val(total_ingreso - parseInt($("#costos_directos").val()) - costos_fijos - comision_asesor);
        $("#utilidad_bruta_p").val((100 / total_ingreso) * (parseInt($("#beneficio_neto").val())));
    }

    $("#porcentaje_cf").change(function () {
        "use strict";

        var ingreso_ventas = parseInt($("#ingreso_ventas").val());
        var porcentaje_cf = parseInt($("#porcentaje_cf").val());
        var porcentaje_ca = parseInt($("#porcentaje_ca").val());
        var total = parseInt($("#total").val());
        var gasto_total = parseInt($("#gasto_total").val());
        var utilidad_bruta = parseInt($("#utilidad_bruta").val());

        if (isNaN(ingreso_ventas)) ingreso_ventas = 0;
        if (isNaN(porcentaje_cf)) porcentaje_cf = 0;
        if (isNaN(porcentaje_ca)) porcentaje_ca = 0;
        if (isNaN(total)) total = 0;
        if (isNaN(gasto_total)) gasto_total = 0;
        if (isNaN(utilidad_bruta)) utilidad_bruta = 0;

        $("#costos_fijos").val(ingreso_ventas * (porcentaje_cf / 100));
        $("#gasto_total").val((ingreso_ventas * (porcentaje_cf / 100)) + total);
        $("#utilidad_bruta").val(ingreso_ventas - parseInt($("#gasto_total").val()));
        $("#comision_asesor").val((porcentaje_ca / 100) * parseInt($("#utilidad_bruta").val()));
    });

    $("#porcentaje_ca").change(function () {
        "use strict";

        var porcentaje_ca = parseInt($(this).val());
        var utilidad_bruta = parseInt($("#utilidad_bruta").val());

        if (isNaN(porcentaje_ca)) porcentaje_ca = 0;
        if (isNaN(utilidad_bruta)) utilidad_bruta = 0;

        $("#comision_asesor").val((porcentaje_ca / 100) * utilidad_bruta);
    });
});