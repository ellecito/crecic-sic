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

    $("html").on("click", ".eliminar", function(){
        var total = parseInt($("#total_c").html());
        var parcial = $(this).attr('rel');
        $(this).parent(".col-lg-1").parent(".row").remove();
        $("#total_c").html(total - parcial);
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
});