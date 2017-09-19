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
                    $("input[name='desde_c[]']").pickatime({
                        format: 'H:i',
                        clear: '',
                        min: [8,0],
                        max: [23, 0]
                    });
                    $("input[name='desde2_c[]']").pickatime({
                        format: 'H:i',
                        clear: '',
                        min: [8,0],
                        max: [23, 0]
                    });
                    $("input[name='hasta_c[]']").pickatime({
                        format: 'H:i',
                        clear: '',
                        min: [8,30],
                        max: [23, 30]
                    });
                    $("input[name='hasta2_c[]']").pickatime({
                        format: 'H:i',
                        clear: '',
                        min: [8,30],
                        max: [23, 30]
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
                    $("input[name='desde_c[]']").pickatime({
                        format: 'H:i',
                        clear: '',
                        min: [8,0],
                        max: [23, 0]
                    });
                    $("input[name='desde2_c[]']").pickatime({
                        format: 'H:i',
                        clear: '',
                        min: [8,0],
                        max: [23, 0]
                    });
                }
            }
        });
    });

    $("html").on("change", ".hora_c", function(e){
        "use strict";
        /* Captura de datos */
        var row = $(this).parent(".col-lg-1").parent(".row");
        var desde_c = $(row).children(".col-lg-1").children("input[name='desde_c[]']").val();
        var hasta_c = $(row).children(".col-lg-1").children("input[name='hasta_c[]']").val();
        var desde2_c = $(row).children(".col-lg-1").children("input[name='desde2_c[]']").val();
        var hasta2_c = $(row).children(".col-lg-1").children("input[name='hasta2_c[]']").val();

        /* Separar hora de minuto */
        desde_c = desde_c.split(":");
        hasta_c = hasta_c.split(":");
        desde2_c = desde2_c.split(":");
        hasta2_c = hasta2_c.split(":");

        /*Horas en valores enteros*/
        var hora_inicial = parseInt(desde_c[0]) + (parseInt(desde_c[1])/60);
        var hora_termino = parseInt(hasta_c[0]) + (parseInt(hasta_c[1])/60);
        console.log("Hora Inicial: " + hora_inicial);
        console.log("Hora Termino: " + hora_termino);
        if(desde2_c[0] && hasta2_c[0]){
            var hora_inicial2 = parseInt(desde2_c[0]) + (parseInt(desde2_c[1])/60);
            var hora_termino2 = parseInt(hasta2_c[0]) + (parseInt(hasta2_c[1])/60);
            console.log("Hora Inicial 2: " + hora_inicial2);
            console.log("Hora Termino 2: " + hora_termino2);
        }

        /* Validaciones */
        if(hora_inicial >= hora_termino){
            if(hora_inicial == hora_termino){
                hora_inicial = hora_inicial - 0.5;
            }else{
                hora_inicial = hora_termino - 0.5;
            }
            desde_c[0] = Math.floor(hora_inicial);
            desde_c[1] = (hora_inicial % 1)*60;
            if(desde_c[1] == 0) desde_c[1] = "00";
            $(row).children(".col-lg-1").children("input[name='desde_c[]']").val(desde_c[0] + ":" + desde_c[1]);
        }

        if(hora_inicial2 && hora_termino2){
            if(hora_inicial2 <= hora_termino){
                hora_inicial2 = hora_termino + 0.5;
                desde2_c[0] = Math.floor(hora_inicial2);
                desde2_c[1] = (hora_inicial2 % 1)*60;
                if(desde2_c[1] == 0) desde2_c[1] = "00";
                $(row).children(".col-lg-1").children("input[name='desde2_c[]']").val(desde2_c[0] + ":" + desde2_c[1]);
            }
            if(hora_inicial2 >= hora_termino2){
                if(hora_inicial2 == hora_termino2){
                    hora_inicial2 = hora_inicial2 - 0.5;
                }else{
                    hora_inicial2 = hora_termino2 - 0.5;
                }
                desde2_c[0] = Math.floor(hora_inicial2);
                desde2_c[1] = (hora_inicial2 % 1)*60;
                if(desde2_c[1] == 0) desde2_c[1] = "00";
                $(row).children(".col-lg-1").children("input[name='desde2_c[]']").val(desde2_c[0] + ":" + desde2_c[1]);
            }
        }

        var total = (hora_termino - hora_inicial);
        if(desde2_c[0] && hasta2_c[0]){
            total+= (hora_termino2 - hora_inicial2);
        }
        
        /* Total Parcial y Total Total */
        $(this).parent(".col-lg-1").siblings(".total_c").html(total);
        var totales = 0;
        $.each($(".total_c"), function(key, total_c){
            totales+= parseFloat($(total_c).html());
        });
        $("#total_c").html(totales);

        /* Cambio de color */
        if(totales != $("#horas").val()){
            $("#total_c").css("color", "red");
        }else{
            $("#total_c").css("color", "green");
        }
    });
});