;$(function () {

    window.showError = function ( text ) {
        $('#error-text').html(text);
        $('#error-container').removeAttr('hidden');
    };

    window.showSuccess = function ( text ) {
        $('#success-text').html(text);
        $('#success-container').removeAttr('hidden');
    };

});
