;$(function () {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "50",
        "hideDuration": "50",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    const replacerEnRu = {
        "q": "й", "w": "ц", "e": "у", "r": "к", "t": "е", "y": "н",
        "u": "г", "i": "ш", "o": "щ", "p": "з", "[": "х", "]": "ъ",

        "a": "ф", "s": "ы", "d": "в", "f": "а", "g": "п", "h": "р",
        "j": "о", "k": "л", "l": "д", ";": "ж", "'": "э",

        "z": "я", "x": "ч", "c": "с", "v": "м", "b": "и",
        "n": "т", "m": "ь", ",": "б", ".": "ю", "/": "."
    };

    function changeKeyboardLayout(word, lang = 'RU') {
        const replaceArray = replacerEnRu;
        if (lang === 'RU')
            Object.keys(replacerEnRu).forEach(key => replaceArray[replacerEnRu[key]] = key);

        return word.split("").map((letter) => {
            const lowLetter = letter.toLowerCase();
            const en = replaceArray[lowLetter] ?? letter;
            return lowLetter === letter ? en : en.toUpperCase();
        }).join("");
    }

    $.expr[':'].srch = function (elem, i, match, array) {
        let val = $(elem).text();
        let comp1 = val.toUpperCase().indexOf(match[3].toUpperCase()) !== -1;
        let comp2 = changeKeyboardLayout(val, 'RU').toUpperCase().indexOf(match[3].toUpperCase()) !== -1;
        let comp3 = changeKeyboardLayout(val, 'EN').toUpperCase().indexOf(match[3].toUpperCase()) !== -1;
        return comp1 || comp2 || comp3;
    };

    let elSelect = false;

    $('select.selectpicker').on('show.bs.select', function (event, clickedIndex, isSelected, previousValue) {
        $(this).parent().find('.dropdown-menu').hide();
        elSelect = $(this);

        let options = [];
        $(this).find('option').each(function () { // :not([disabled])
            let id = $(this).val();
            let label = $(this).text().trim();
            let isSelected = $(this).attr('selected') === undefined ? 0 : 1;
            let isDisabled = $(this).attr('disabled') === undefined ? 0 : 1;

            options.push({'id': id, 'label': label, 'selected': isSelected, 'disabled': isDisabled,})
        });

        let html = `
        <div id="customSelectMMBlank"></div>
        <div id="customSelectMMContainer">
            <input type="text" class="form-control" placeholder="Поиск..."/>
            <br />
            <div class="customSelectList">`;

        options.forEach(el => {
            let addClass = []
            if (el['selected']) addClass.push('selected');
            if (el['disabled']) addClass.push('disabled');
            html += '<div data-id="' + el['id'] + '" class="' + (addClass.join(' ')) + '">' + el['label'] + '</div>';
        });

        html += `
            </div>
        </div>
        `;
        $('body').append(html);


        // Position & Width popup container
        let popupContainer = $('#customSelectMMContainer');
        let realEl = elSelect.parent();

        let width = realEl.outerWidth();
        //if (width > popupContainer.outerWidth())
        popupContainer.css('width', width);

        let oTop = realEl.offset().top;
        let height = realEl.outerHeight();
        popupContainer.css('top', oTop + height);

        let oLeft = realEl.offset().left;
        popupContainer.css('left', oLeft);


        // Scroll to selected element
        let cSL = $('#customSelectMMContainer .customSelectList');
        let scrollTo = cSL.find('div.selected');
        if (scrollTo.length) {
            let scrollTop = scrollTo.offset().top - cSL.offset().top + cSL.scrollTop();
            if (scrollTop > 1)
                cSL.animate({scrollTop: scrollTop}, "fast");
        }


        // Focus on input
        setTimeout(function () {
            $('#customSelectMMContainer input').focus()
        }, 100);
    });

    $("body")
        .on("click", "#customSelectMMBlank", customSelectRemove)
        .on("click", "#customSelectMMContainer .customSelectList > div:not(.disabled)", function (e) {
            if (e.target !== this) return false;
            if (elSelect === false) return false;

            let id = $(this).data("id");
            if (id === undefined) return false;

            elSelect.find('option').attr('selected', false);
            elSelect.find('option:eq(' + id + ')').attr('selected', 'selected'); // Modifies the DOM
            elSelect.selectpicker('val', id);

            customSelectRemove();
        })
        .on("keyup", "#customSelectMMContainer input", function (e) {
            let opts = "#customSelectMMContainer .customSelectList > div";
            let val = $(this).val();
            if (!val.length) {
                $(opts).show();
                return false;
            }

            $(opts).hide().parent().find(':not(.disabled):srch(' + val + ')').show();
        });

    function customSelectRemove() {
        $("#customSelectMMBlank").remove();
        $("#customSelectMMContainer").remove();
        elSelect = false;
    }
});
