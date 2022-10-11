;$(function () {

    let token = $('meta[name="csrf-token"]').attr('content');

    $('#box-balance-table').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        pageLength: 20,
        searching: false,
        bLengthChange: false,
        ordering: false,
        type: 'POST',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Russian.json',
        },
        ajax: {
            url: '/box-balance/list',
            headers: {
                'X-CSRF-TOKEN': token
            },
            type: 'POST',
        },
        columns: [
            { data: 'open', name: 'open' },
            { data: 'id', name: 'id' },
            { data: 'balance_date', name: 'balance_date' },
            { data: 'unique_name', name: 'box.unique_name' },
            { data: 'balance_amount', name: 'balance_amount' },
            { data: 'calculated_balance', name: 'calculated_balance' },
            { data: 'difference', name: 'difference' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'created_full_name', name: 'created_full_name' },
            { data: 'updated_full_name', name: 'updated_full_name' },
            { data: 'delete', name: 'delete' },
        ],
    });

});
