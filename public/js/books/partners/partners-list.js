;$(function () {

    $('.data-table').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        pageLength: 20,
        searching: false,
        bLengthChange: false,
        language: {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Russian.json"
        },
        ajax: '/partners',
        columns: [
            { data: 'open', name: 'Открыть' },
            { data: 'id', name: 'ID' },
            { data: 'descr', name: 'Название' },
            { data: 'created_at', name: 'Дата создания' },
            { data: 'updated_at', name: 'Дата изменения' },
            { data: 'created_full_name', name: 'Кто добавил' },
            { data: 'updated_full_name', name: 'Кто изменил' },
            { data: 'delete', name: 'Удалить' },
        ]
    });

});
