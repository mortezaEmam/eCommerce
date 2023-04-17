$('.variation-select').on('change', function () {
    let variation = JSON.parse(this.value);
    let variationPriceDiv = $('.variation-price');
    variationPriceDiv.empty();
    if (variation.is_sale) {
        let spanSale = $('<span />', {
            class: 'new',
            text: toPersianNum(number_format(variation.sale_price)) + ' تومان'
        });
        let spanPrice = $('<span />', {
            class: 'old',
            text: toPersianNum(number_format(variation.price)) + ' تومان'
        });

        variationPriceDiv.append(spanSale);
        variationPriceDiv.append(spanPrice);
    } else {
        let spanPrice = $('<span />', {
            class: 'new',
            text: toPersianNum(number_format(variation.price)) + ' تومان'
        });
        variationPriceDiv.append(spanPrice);
    }
    $('.quantity-input').attr('data-max', variation.quantity);
    $('.quantity-input').val(1);
})
