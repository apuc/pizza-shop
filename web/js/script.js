$(document).ready(function(){

    $('.js_add_product').click(function () {
        let product_id = $(this).data('id');
        let quantity_input = $(this).parent().children('input');
        let quantity = quantity_input.val();
        $.ajax({
            type: 'POST',
            url: '/cart/add-product',
            data: {'id': product_id, 'quantity': quantity},
            success: function () {
                quantity_input.val(null);
                $(this).prop('disabled', true);
                updateHeaderInfo();
            }
        });
    });

    $('.jsIncrement').click(function () {
        let product_id = $(this).parent().data('id');
        let btn = $(this);
        $.ajax({
            type: 'POST',
            url: '/cart/increment-product',
            dataType: 'json',
            data: {'id': product_id},
            success: function (result) {
                let span = btn.prev();
                span.text(result.quantity);
                btn.parent().next().find('.jsProductTotal').text(result.total_price);
                updateHeaderInfo();
            }
        });
    });

    $('.jsDecrement').click(function () {
        let product_id = $(this).parent().data('id');
        let btn = $(this);
        $.ajax({
            type: 'POST',
            url: '/cart/decrement-product',
            dataType: 'json',
            data: {'id': product_id},
            success: function (result) {
                let span = btn.next();
                span.text(result.quantity);
                btn.parent().next().find('.jsProductTotal').text(result.total_price);
                updateHeaderInfo();
            }
        });
    });

    $('.trash').click(function () {
        let btn = $(this);
        let product_id = $(this).parent().data('id');
        $.ajax({
            type: 'POST',
            url: '/cart/delete-product',
            dataType: 'json',
            data: {'id': product_id},
            success: function (result) {
                btn.parent().parent().parent().remove();
                updateHeaderInfo();
            }
        });
    });

    $('#currency_dropdown').change(function () {
        let currency_id = parseInt($(this).val());
        $.ajax({
            type: 'POST',
            url: '/site/change-currency',
            dataType: 'json',
            data: {'id': currency_id},
            success: function (result) {
                location.reload();
            }
        });
    });

    function updateHeaderInfo() {
        $.ajax({
            type: 'POST',
            url: '/cart/get-header-info',
            dataType: 'json',
            success: function (result) {
                $('#totalQuantity').text(result.total_quantity);
                $('#totalPrice').text(result.total_price);
            }
        });
    }

});