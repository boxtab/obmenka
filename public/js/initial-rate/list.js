;$(function () {

    $('.currency-balance, .currency-rate').inputFilter(function(value) {
        return /^[0-9,.-]*$/.test(value);
    });

    $('#table-initial-rate').on('input keypress', '.currency-balance, .currency-rate', function (event) {

        if ( Number( event.keyCode ) === 13 ) {

            let token = $('meta[name="csrf-token"]').attr('content');
            let url = '/initial-rate/update';
            let id = Number( $(this).data('id') );
            let inputClass = $(this).attr('class');
            let inputValue = Number( $(this).val() );
            let tr = $(this).parent().parent();

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token:         token,
                    id:             id,
                    input_class:    inputClass,
                    input_value:    inputValue,
                },
                dataType: 'json',
                success: function( response ) {
                    if ( response.message === 'success' ) {
                        tr.find( 'td:eq(4)' ).text( response.balance_rub );
                        tr.next().find('.' + inputClass).select();
                    } else {
                        window.parent.showError( response.message );
                    }
                }, // end: success: function
                error: function( jqXHR, exception ) {
                    window.parent.showError( window.parent.getTextAjaxError( jqXHR, exception ) );
                } // end: error: function
            }); // end: $.ajax

        }

    });

});
