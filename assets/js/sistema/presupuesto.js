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
    });

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
    });
});