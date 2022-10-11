$(function () {

    $('#button-build').on('click', function () {

        let token = $('meta[name="csrf-token"]').attr('content');
        let url = '/average-rate/build';
        let testValueFront = 10;
        let progressValue = 0;

        $('#block-progress-done').hide();
        $('#block-progress-run').show();

        let timerId = setInterval(() => {
            progressValue = ( progressValue < 100 ) ? progressValue + 10 : 0;
            $('.progress-bar').css('width', progressValue+'%').html(progressValue+'%');
            $('#button-build').prop('disabled', true);
            },
            1000
        );

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: token,
                test_value_front: testValueFront,
            },
            dataType: 'json',
            success: function( response ) {
                if ( response.message === 'success' ) {

                    clearTimeout( timerId );
                    $('#block-progress-done').show();
                    $('#block-progress-run').hide();
                    $('#button-build').prop('disabled', false);
                    location.reload();

                } else {
                    window.parent.showError( response.message );
                }
            }, // end: success: function
            error: function( jqXHR, exception ) {
                window.parent.showError( window.parent.getTextAjaxError( jqXHR, exception ) );
            } // end: error: function
        }); // end: $.ajax

    });

    $('#buildModal').on('hidden.bs.modal', function (e) {
        // do something...
        console.log( 'Modal window on close' );
    })

});
