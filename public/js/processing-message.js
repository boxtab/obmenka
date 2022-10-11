;$(function () {

    window.getTextAjaxError = (jqXHR, exception) => {
        let message = '';

        if ( jqXHR.status === 0 ) {
            message = 'Not connect. Verify Network.';
        } else if ( jqXHR.status === 404 ) {
            message = 'Requested page not found. [404]';
        } else if ( jqXHR.status === 406 ) {
            message = jqXHR.responseText;
        } else if ( jqXHR.status === 500 ) {
            message = 'Internal Server Error [500]. ' + jqXHR.responseText;
        } else if ( exception === 'parsererror' ) {
            message = 'Requested JSON parse failed. ';
        } else if ( exception === 'timeout' ) {
            message = 'Time out error.';
        } else if ( exception === 'abort' ) {
            message = 'Ajax request aborted.';
        } else if ( jqXHR.status === 422 ) {
            for (const [key, value] of Object.entries( jqXHR.responseJSON.errors )) {
                message = String( value[0] );
            }
        } else {
            message = 'Uncaught Error. ' + jqXHR.responseText;
        }

        return message;
    };

});
