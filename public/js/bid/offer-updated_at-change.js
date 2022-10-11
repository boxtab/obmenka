;$(function () {
    $('.offer-updated_at-change').on('click', function () {
        console.log('Yes click!');
        let test = $(this).attr("data-id");
        console.log(test);
    });
});

