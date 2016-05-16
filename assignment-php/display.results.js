

/* Using jQuery */
$(document).ready(function () {

    $('tr', 'table.table').dblclick(function (e) {
        $('tr', 'table.table').not(this).removeClass('text-bold');        
        $(this).toggleClass('text-bold');
    });

});
