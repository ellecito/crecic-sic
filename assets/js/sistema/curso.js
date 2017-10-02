$(document).ready(function () {
    $("#curso").change(function () {
        if ($("#codigo").val()) {
            var url = window.location.pathname.replace("editar/" + $("#codigo").val(), "curso");
        } else {
            var url = window.location.pathname.replace("agregar", "");
            var url = url + "curso";
        }
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: "curso=" + $("#curso").val(),
            success: function (json) {
                if (json.result) {
                    $("#horas").val(json.curso.horas);
                    $("#alumnos").val(json.curso.alumnos);
                    $("#valor_alumno").val(json.curso.valor_alumno);
                    $("#valor_hh_a").val(json.curso.valor_alumno / json.curso.horas);
                    $("#ingreso_ventas").val(json.curso.valor_alumno * json.curso.alumnos);
                    $("#total_ingreso").val(json.curso.valor_alumno * json.curso.alumnos);
                }
            }
        });
        $("a[href='#presupuesto']").css("display", "block");
    });
});