$(document).ready(function(){
    $("#generar_cronograma").click(function(e){
        e.preventDefault();
        if($("#codigo").val()){
            var url = window.location.pathname.replace("editar/" + $("#codigo").val(), "cronograma");
        }else{
            var url = window.location.pathname.replace("agregar", "");
            var url = url + "cronograma";
        }
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: $("#form-agregar").serialize(),
            success: function(json){
                if(json.result){
                    noty({
                        text: "Generando cronograma...",
                        layout: 'topCenter',
                        type: 'alert',
                        timeout: 5000,
                        killer: true
                    });
                    $("#cronograma_generado").html(json.html);
                    $("#cronograma_generado").trigger("chosen:updated");
                    $('.time').pickatime({
                        format: 'H:i',
                        clear: ''
                    });
                    noty({
                        text: "Cronograma generado",
                        layout: 'topCenter',
                        type: 'success',
                        timeout: 5000,
                        killer: true
                    });
                }else{
                    noty({
                        text: json.msg,
                        layout: 'topCenter',
                        type: 'error',
                        timeout: 3000,
                        killer: true
                    });
                }
            }
        });
        
    });

    /* Eliminar dia */
    $("html").on("click", ".eliminar", function(){
        var total = parseInt($("#total_c").html());
        var parcial = $(this).attr('rel');
        $(this).parent(".col-lg-1").parent(".row").remove();
        $("#total_c").html(total - parcial);
        if((total - parcial) != $("#horas").val()){
            $("#total_c").css("color", "red");
        }else{
            $("#total_c").css("color", "green");
        }
    });

    $("html").on("click", "#agregar_c", function(e){
        e.preventDefault();
        var total_horas = parseInt($("#total_c").html());
        $(this).parent(".col-lg-1").parent(".row").remove();
        if($("#codigo").val()){
            var url = window.location.pathname.replace("editar/" + $("#codigo").val(), "agregar-hora");
        }else{
            var url = window.location.pathname.replace("agregar", "");
            var url = url + "agregar-hora";
        }
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: $("#form-agregar").serialize() + "&total_horas=" + total_horas,
            success: function(json){
                if(json.result){
                    $("#cronograma_generado").append(json.html);
                    $("#cronograma_generado").trigger("chosen:updated");
                    $('.time').pickatime({
                        format: 'H:i',
                        clear: ''
                    });
                }
            }
        });
    });

    $("html").on("change", ".hora_c", function(e){
        "use strict";
        var desde_c = $(this).parent(".col-lg-1").siblings(".col-lg-1").children("input[name='desde_c[]']").val();
        var hasta_c = $(this).parent(".col-lg-1").siblings(".col-lg-1").children("input[name='hasta_c[]']").val();
        var desde2_c = $(this).parent(".col-lg-1").siblings(".col-lg-1").children("input[name='desde2_c[]']").val();
        var hasta2_c = $(this).parent(".col-lg-1").siblings(".col-lg-1").children("input[name='hasta2_c[]']").val();
        
        /* Parche para error del valor actual */
        if(desde_c === undefined) desde_c = $(this).val();
        if(hasta_c === undefined) hasta_c = $(this).val();
        if(desde2_c === undefined) desde2_c = $(this).val();
        if(hasta2_c === undefined) hasta2_c = $(this).val();

        desde_c = desde_c.split(":");
        hasta_c = hasta_c.split(":");
        desde2_c = desde2_c.split(":");
        hasta2_c = hasta2_c.split(":");

        /* Validaciones */
        if(desde_c[0] > hasta_c[0]){
            //
        }

        var total = (hasta_c[0] - desde_c[0]);
        total+= ((hasta_c[1]/60) - (desde_c[1])/60);
        if(hasta2_c[0] && desde2_c[0]){
            total+= (hasta2_c[0] - desde2_c[0]);
            total+= ((hasta2_c[1]/60) - (desde2_c[1])/60);
        }
        
        $(this).parent(".col-lg-1").siblings(".total_c").html(total);
        var totales = 0;
        $.each($(".total_c"), function(key, total_c){
            totales+= parseFloat($(total_c).html());
        });
        $("#total_c").html(totales);
        if(totales != $("#horas").val()){
            $("#total_c").css("color", "red");
        }else{
            $("#total_c").css("color", "green");
        }
    });
});