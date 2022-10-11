;$(function () {
    function buttonStateAjax(button, state) {
        button.data('enabled', state);
        button.prop('disabled', state ? false : 'disabled');
    }

    $('body')
        .on('click', '.offer-add', function (event) {
            event.preventDefault();

            let thisButton = $(this);
            let bidId = $('#bid-id').text();
            let boxId = false;
            let boxId_val = false;
            let inputAmountId = false;
            let inputAmountId_val = 0;
            let appendTo = false;
            let incExp;
            let offerSum;
            let _token = $('meta[name="csrf-token"]').attr('content');

            let type = thisButton.data('type');
            if ( ! type || ['income', 'expense'].indexOf(type) === -1 ) {
                toastr.error('Тип добавления задан не верно');
                return false;
            }

            boxId = $('#select_box_id_' + type);
            boxId_val = boxId.val();

            inputAmountId = $('#input_amount_' + type);
            inputAmountId_val = inputAmountId.val();

            offerSum = $('#offer_sum_' + type);
            appendTo = $('#tbody_offer_' + type);
            incExp = type.substring(0, 3);

            if ( ! boxId_val || ! inputAmountId_val ) {
                toastr.error('Заполните все поля');
                return false;
            }

            buttonStateAjax(thisButton, false);

            $.ajax({
                url: '/bid/add-offer',
                type: 'POST',
                dataType: 'json',
                data: {
                    bid_id: bidId,
                    box_id: boxId_val,
                    input_amount: inputAmountId_val,
                    inc_exp: incExp,
                    _token: _token
                },
                success: function (response) {
                    if (response.error) {
                        toastr.error( response.error );
                        return false;
                    }

                    if (response.box_options && response.box_val) {
                        boxId.find('option').remove().end().append('<option value="0" disabled>Счет*</option>');
                        $.each(response.box_options, function (index, val) {
                            boxId.append('<option value="' + val[0] + '">' + val[1] + '</option>');
                        });
                        boxId.val(response.box_val);
                    }

                    if (response.redirect_url) {
                        location.href = response.redirect_url;
                        return false;
                    }

                    if (response.last_insert_id && response.box && response.amount) {
                        // console.log(window.location.origin);
                        let updatedAt = moment( new Date( response.updated_at ) ).format('YYYY-MM-DD HH:mm');
                        appendTo.append(`
                        <tr class="new">
                            <td>${response.last_insert_id}</td>
                            <td>${response.box}</td>
                            <td class="calc">${response.amount}</td>

                            <td>
                                <!-- <form action="${window.location.origin}/offer/update" method="POST" id="form-offer-update-${response.last_insert_id}"> -->
                                    <input type="hidden" name="_token" value="${_token}">
                                    <input type="hidden" name="offer_id" value="${response.last_insert_id}">
                                    <input class="form-control" type="text" readonly name="updated_at" value="${updatedAt}">
<!--                                    <input class="form-control" type="datetime-local" name="updated_at" value="${updatedAt}">-->
                                <!-- </form> -->
                            </td>
                            <!-- <td>
                            //     <button type="submit" form="form-offer-update-${response.last_insert_id}" class="btn btn-danger btn-link btn-sm">
                            //         <i class="material-icons">arrow_circle_down</i>
                            //     </button>
                            // </td> -->
                            <td>
                                <button type="button" class="btn btn-danger btn-link btn-sm delete-confirm"
                                    data-id="${response.last_insert_id}" data-toggle="modal" data-target="#deleteModal">
                                    <i class="material-icons">close</i>
                                </button>
                            </td>
                        </tr>
                        `);

                        inputAmountId.val('');
                        offerSum.text(Number(offerSum.text()) + Number(response.amount));
                        toastr.info('Платеж добавлен')
                    }
                },
                complete: function (jqXHR, textStatus) {
                    buttonStateAjax(thisButton, true);
                },
            });
        });
});
