$(document).ready(function () {
    var reorderUrl = $('#task-table').data('reorder-url');
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $("#task-table tbody").sortable({
        handle: ".drag-handle",
        cursor: "move",
        axis: "y",
        stop: function (event, ui) { // Use stop event
            var taskOrder = [];
            $("#task-table tbody tr").each(function () {
                taskOrder.push($(this).data('task-id'));
            });

            $.ajax({
                type: 'POST',
                url: reorderUrl,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    '_token': csrfToken,
                    'taskOrder': taskOrder
                },
                success: function (response) {
                        window.location.reload();
                },
                error: function () {
                    console.log('Error occurred while reordering tasks.');
                }
            });
        },
    }).disableSelection();
});