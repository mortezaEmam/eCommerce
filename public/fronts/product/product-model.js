/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************************!*\
  !*** ./resources/js/home/fronts/product-model.js ***!
  \***************************************************/
$('.variation-select').on('change', function () {
  var variation = JSON.parse(this.value);
  var variationPriceDiv = $('.variation-price');
  variationPriceDiv.empty();
  if (variation.is_sale) {
    var spanSale = $('<span />', {
      "class": 'new',
      text: toPersianNum(number_format(variation.sale_price)) + ' تومان'
    });
    var spanPrice = $('<span />', {
      "class": 'old',
      text: toPersianNum(number_format(variation.price)) + ' تومان'
    });
    variationPriceDiv.append(spanSale);
    variationPriceDiv.append(spanPrice);
  } else {
    var _spanPrice = $('<span />', {
      "class": 'new',
      text: toPersianNum(number_format(variation.price)) + ' تومان'
    });
    variationPriceDiv.append(_spanPrice);
  }
  $('.quantity-input').attr('data-max', variation.quantity);
  $('.quantity-input').val(1);
});
/******/ })()
;