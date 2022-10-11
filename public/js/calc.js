;$(function () {

    /* CALC START */
    let elMin = $('#calc_min');
    let elMax = $('#calc_max');
    let elAvg = $('#calc_avg');
    let elSum = $('#calc_sum');

    const cValsDefault = {
        'min': 0,
        'max': 0,
        'avg': 0,
        'sum': 0,
    };

    let cVals = {
        'min': cValsDefault['min'],
        'max': cValsDefault['max'],
        'avg': cValsDefault['avg'],
        'sum': cValsDefault['sum'],
    };

    $("body")
        .on("click", "td.calc", function (e) {
            if (!e.ctrlKey) { // Если нажали на 1, то выбирается, если на другой, то первый обнуляется
                resetCalc();
                return false;
            }

            $('.fixed_footer_calc').show();
            cVals['min'] = cValsDefault['min'];
            cVals['max'] = cValsDefault['max'];
            cVals['sum'] = cValsDefault['sum'];

            let _t = $(this);

            _t.toggleClass('selected');

            let tdSelected = $('td.calc.selected');
            let allSelected = tdSelected.length;
            if (!allSelected) {
                resetCalc();
                return false;
            }

            tdSelected.each(function (i, el) {
                let number = Number($(el).text());

                if (cVals['min'] === 0)
                    cVals['min'] = number;

                if (cVals['min'] > number)
                    cVals['min'] = number;

                if (cVals['max'] === 0)
                    cVals['max'] = number;

                if (cVals['max'] < number)
                    cVals['max'] = number;

                cVals['sum'] += number;
            });

            elMin.text(cVals['min']);
            elMax.text(cVals['max']);
            elAvg.text((allSelected ? cVals['sum'] / allSelected : 0));
            elSum.text(cVals['sum']);
        })
        .on("click", function (e) {
            if (!$(e.target).closest("td.calc, .fixed_footer_calc").length) {
                resetCalc();
            }
        });

    function resetCalc() {
        $('.fixed_footer_calc').hide();
        $('td.calc.selected').toggleClass('selected');
        cVals = $.extend({}, cValsDefault);

        elMin.text(cVals['min']);
        elMax.text(cVals['max']);
        elAvg.text(cVals['avg']);
        elSum.text(cVals['sum']);
    }

    /* CALC START */

});
