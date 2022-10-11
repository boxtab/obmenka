;$(function () {

    $('.balance-amount').inputFilter(function(value) {
        return /^[0-9,.-]*$/.test(value);
    });

    $('#box-balance-table').on('input keypress', '.balance-amount', function (event) {

        if ( Number( event.keyCode ) === 13 ) {

            let token = $('meta[name="csrf-token"]').attr('content');
            let url = '/box-balance/update-amount';
            let id = Number( $(this).data('id') );
            let amount = Number( $(this).val() );
            let tr = $(this).parent().parent();

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: token,
                    id:     id,
                    amount: amount,
                },
                dataType: 'json',
                success: function( response ) {
                    if ( response.message === 'success' ) {
                        tr.find( 'td:eq(4)' ).find('input').val( response.balance_amount );

                        tr.find( 'td:eq(5)' ).text( response.calculated_balance );
                        tr.find( 'td:eq(6)' ).text( response.difference );

                        tr.find( 'td:eq(7)' ).text( response.updated_at );
                        tr.find( 'td:eq(9)' ).text( response.updated_full_name );
                        tr.next().find('.balance-amount').select();
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
