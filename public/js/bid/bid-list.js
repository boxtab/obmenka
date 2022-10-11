;$(function () {
    let token = $('meta[name="csrf-token"]').attr('content');

    $('.data-bid-list').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        pageLength: 20,
        searching: false,
        bLengthChange: false,
        ordering: false,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Russian.json',
        },
        ajax: {
            url: '/bid/list',
            headers: {
                'X-CSRF-TOKEN': token
            },
            type: 'POST',
            // data: function (d) {
            //     d.startDate = $('input[name=start_date]').val();
            //     d.stopDate = $('input[name=stop_date]').val();
            //     d.directionGetId = $('select[name=direction_get_id]').val();
            //     d.directionGiveId = $('select[name=direction_give_id]').val();
            // },
        },
        columns: [
            { data: 'open', name: 'Открыть' },
            { data: 'id', name: 'ID' },
            { data: 'bid_number', name: '# Заявки' },
            { data: 'top_destinations_descr', name: 'Источник доходов' },
            { data: 'direction_get_descr', name: 'Получаем' },
            { data: 'total_amount_get', name: 'Сумма' },
            { data: 'direction_give_descr', name: 'Отдаем' },
            { data: 'total_amount_give', name: 'Сумма' },
            { data: 'note', name: 'Комментарий' },
            { data: 'updated_at', name: 'Дата редактирования' },
            { data: 'created_full_name', name: 'Кто добавил' },
            { data: 'manager_full_name', name: 'Менеджер' },
            { data: 'delete', name: 'Удалить' },
        ],
        columnDefs: [
            { className: 'calc', targets: [ 5, 7 ] }
        ]
    });

});
