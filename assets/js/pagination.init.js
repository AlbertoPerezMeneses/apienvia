(function() {
    $(document).ready(function() {
     $('#pagination').dataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "scrollY": 600,
        "scrollX": true
        });       
        

 

 new WOW().init();
$('[data-toggle="tooltip"]').tooltip();
    });
})();
