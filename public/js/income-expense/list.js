;$(function () {
    let token = $('meta[name="csrf-token"]').attr('content');

    $('.data-income-expense-list').DataTable({
        // stateSave: false,
        // order: [[ 1, "desc" ], [ 2, "desc" ], [ 3, "desc" ]],
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
            url: '/income-expense/list',
            headers: {
                'X-CSRF-TOKEN': token
            },
            type: 'POST',
            // data: function (d) {
            //     d.startDate = $('input[name=start_date]').val();
            //     d.stopDate = $('input[name=stop_date]').val();
            //     d.incomeExpense = $('select[name=income-expense]').val();
            //     d.ddsId = $('select[name=dds_id]').val();
            //     d.boxId = $('select[name=box_id]').val();
            // },
        },
        columns: [
            { data: 'open', name: 'Открыть' },
            { data: 'id', name: 'ID' },
            { data: 'income_expense', name: 'ПриходРасход' },
            { data: 'income_expense_type_descr', name: 'Вид операции' },
            { data: 'dds_descr', name: 'Код ДДС' },
            { data: 'box_descr', name: 'Бокс' },
            { data: 'amount', name: 'Сумма' },
            { data: 'rate', name: 'Курс к рублю' },
            { data: 'amount_rub', name: 'Сумма в рублях' },
            { data: 'updated_at', name: 'Дата изменения' },
            { data: 'updated_full_name', name: 'Кто изменил' },
            { data: 'delete', name: 'Удалить' },
        ],
    });

    // table.state.clear();
    // window.location.reload();

    // $('#filter_list').on('click', function () {
    //     let listIncomeExpense = $('.data-income-expense-list').DataTable();
    //     listIncomeExpense.ajax.reload();
    // });
    //
    // $('#clear_filter_list').on('click', function () {
    //     $('input[name=start_date]').val('');
    //     $('input[name=stop_date]').val('');
    //
    //     document.getElementById('select-income-expense').selectedIndex = 0;
    //     document.getElementById('select-dds_id').selectedIndex = 0;
    //     document.getElementById('select-box_id').selectedIndex = 0;
    // });
});
