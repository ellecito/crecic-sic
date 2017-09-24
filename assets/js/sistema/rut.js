$(document).ready(function() {
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