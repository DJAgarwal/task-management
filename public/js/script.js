$(document).ready(function () {
    $("#task-table tbody").sortable({
        handle: ".drag-handle",  
        cursor: "move",         
        axis: "y",           
    }).disableSelection();
});