$(function() {
    let table = $('#myTable').DataTable({
        order: [
            [3, 'asc']
        ],
        columnDefs: [{
            targets: 2,
            orderable: false
        }],
        buttons: [{
                extend: 'create',
                editor: myEditor
            },
            {
                extend: 'edit',
                editor: myEditor
            },
            {
                extend: 'remove',
                editor: myEditor
            }
        ]
    });
    $('#top10_table').DataTable({
        order: [
            [2, 'desc']
        ],
        dom: 'Bftr'
    });
    $('#typ').on('click', function() {
        let currentOrder = table.order()[0];
        let sortOrder = currentOrder[0] === 2 && currentOrder[1] === 'asc' ? 'desc' : 'asc';
        table.order([2, sortOrder], [3, 'asc']).draw();
    });
});