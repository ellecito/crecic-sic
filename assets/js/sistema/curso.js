$(document).ready(function(){
    $("#curso").change(function(){
        if($("#codigo").val()){
            var url = window.location.pathname.replace("editar/" + $("#codigo").val(), "curso");
        }else{
            var url = window.location.pathname.replace("agregar", "");
            var url = url + "curso";
        }
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: "curso=" + $("#curso").val(),
            success: function(json){
                if(json.result){
                    $("#horas").val(json.curso.horas);
                    $("#horas").trigger("chosen:updated");
                    $("#alumnos").val(json.curso.alumnos);
                    $("#alumnos").trigger("chosen:updated");
                }
            }
        });
    });
});