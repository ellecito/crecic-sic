$(document).ready(function() {
    
        $("#form-login").validationEngine('attach', {
            promptPosition:'topLeft',
            validationEventTrigger:false,
            scroll: false,
            showOneMessage:true,
            onValidationComplete: function(form, status){
            if(status) {
                noty({
                    text: 'Verificando datos. Por favor, espere un momento.',
                    layout: 'topCenter',
                    closeWith: [],
                    type: 'alert',
                    killer:true,
                    template: '<div class="noty_message"><img src="assets/img/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
                    fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
                });
    
                $.ajax({
                    url: 'login/',
                    type: 'post',
                    dataType: 'json',
                    data: $("#form-login").serialize(),
                    success: function(json){
                        if(json.result){
                            noty({
                                text: "Bienvenido.",
                                layout: 'topCenter',
                                type: 'success',
                                killer: true
                            });
                            setTimeout(function() {
                                window.location.href = json.url;
                            }, 1000);
                        }
                        else
                        {
                            noty({
                                text: json.msg,
                                layout: 'topCenter',
                                type: 'error',
                                killer: true
                            });
                        }
                    }
                });
            }
          }
        });
    
        $('#rut').Rut({
            on_success:function(){
                $('#rut').removeClass("validate[required,custom[rut]]"); 
                $('#rut').addClass("validate[required]");
            },
            on_error: function(){
                $('#rut').removeClass("validate[required,custom[rut]]"); 
                $('#rut').removeClass("validate[required]"); 
                $('#rut').addClass("validate[required,custom[rut]]");
            },
            format_on: 'keyup'
        });
    
    });
    