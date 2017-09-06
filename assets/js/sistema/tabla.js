$(document).ready(function() {
    $('#dataTables').DataTable({
        responsive: true,
        "language": {
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "search": "Buscar:",
            "infoEmpty": "Sin resultados para mostrar",
            "infoFiltered": "(filtrando desde _MAX_ entradas)",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "zeroRecords": "No resultados para mostrar",
            "paginate": {
                "next": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });
});