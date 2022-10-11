$(function () {
    $('body')
        .on('click', '.delete-confirm', function () {
            let idRow = $(this).data('id');
            let formAction = $('#form-delete').data('action');

            $('.id-delete').text(idRow);
            $('#form-delete').attr('action', formAction + '/' + idRow);
        });
});
