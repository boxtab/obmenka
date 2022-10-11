;$(function () {
    // jquery.min.js:1531 The specified value "2021-03-26T09:07:56.000000Z" does not conform to the required format.  The format is "yyyy-MM-ddThh:mm" followed by optional ":ss" or ":ss.SSS".

    $('#updated_paste').on('click', function () {
        let updateAtText = $('#label-updated_at').text();
        let updateAtDate = moment( new Date( updateAtText ) ).format('YYYY-MM-DDTHH:mm');
        $('#input-updated_at').val( updateAtDate );
    });

    $('#updated_clear').on('click', function () {
        $('#input-updated_at').val('');
    });
});
