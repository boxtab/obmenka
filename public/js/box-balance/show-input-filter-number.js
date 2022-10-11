;$(function () {

    $('#input-balance_amount').inputFilter(function(value) {
        return /^[0-9,.-]*$/.test(value);
    });

});
