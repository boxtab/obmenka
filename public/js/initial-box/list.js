;$(function () {

    $('#table-initial-box').on('input keypress', '.balance', function (event) {

        if ( Number( event.keyCode ) === 13 ) {

            let token = $('meta[name="csrf-token"]').attr('content');
            let url = '/initial-box/update';
            let id = Number( $(this).data('id') );
            let balance = Number( $(this).val() );
            let tr = $(this).parent().parent();

            // console.log(id);
            // console.log(balance);

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token:     token,
                    id:         id,
                    balance:    balance,
                },
                dataType: 'json',
                success: function( response ) {
                    if ( response.message === 'success' ) {
                        // console.log(response.balance);
                        // tr.find( 'td:eq(3)' ).text( response.balance );
                        tr.next().find('.balance').select();
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
