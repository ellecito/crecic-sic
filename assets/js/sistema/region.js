$(function(){
    $("html").on("change", "#region", function(){
        $("#comuna").html("<option>Buscando...</option>");
        $("#comuna").trigger("chosen:updated");
        if($("#codigo").val()){
            var url = window.location.pathname.replace("editar/" + $("#codigo").val(), "comunas");
        }else{
            var url = window.location.pathname.replace("agregar", "comunas");
        }

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: "region=" + $("#region").val(),
            success: function(json){
                if(json.result){
                    $("#comuna").html(json.html);
                    $('#comuna').selectpicker('refresh');
                    $('#comuna').trigger('change');
                }
            }
        });
    });
});