$(document).ready(function(){
    $('#desde').pickatime({
        format: 'H:i',
        clear: '',
        min: [8,0],
        max: [23, 0]
    });
    $('#desde2').pickatime({
        format: 'H:i',
        clear: '',
        min: [8,0],
        max: [23, 0]
    });
    $('#hasta').pickatime({
        format: 'H:i',
        clear: '',
        min: [8,30],
        max: [23, 30]
    });
    $('#hasta2').pickatime({
        format: 'H:i',
        clear: '',
        min: [8,30],
        max: [23, 30]
    });
    $('#hora_coctel').pickatime({
        format: 'H:i',
        clear: '',
        min: [8,0],
        max: [23, 0]
    });
});