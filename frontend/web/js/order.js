/* Color of station pick */
$colorPicker = $('.order-color-choose > div');
$colorPicker.on('click', function() {
  $colorPicker.removeClass('active');
  $(this).addClass('active');
  var imageSrc = $(this).data('image');
  $('img.o-c-img').attr('src', imageSrc);

  var color = $(this).data('color');
  $('input[name="color"]').val(color);

});

/* Quantity selection handle */
$quantityEl = $('.order-quantity .o-q');
$sumEl = $('.o-due-sum');
$quantityMinus = $('.order-quantity .o-q-minus');
$quantityPlus = $('.order-quantity .o-q-plus');
$btnSubmit = $('.o-submit-form button[type="submit"]');
var price = parseFloat($('.order-price').text().replace('$', '').replace('.', ''));
var quantity = parseInt($quantityEl.text());

$quantityMinus.on('click', function() {
  if (quantity <= 1) {
    return false;
  } else {
    quantity = quantity - 1;
    setQuantityPrice(quantity);
  }
});
$quantityPlus.on('click', function() {
  if (quantity >= 5) {
    return false;
  } else {
    quantity = quantity + 1;
    setQuantityPrice(quantity);
  }
});

function setQuantityPrice(quantity) {
  $quantityEl.text(quantity);
  var sum = price * quantity;
  $sumEl.text(sum);
  $('input[name="quantity"]').val(quantity);
}

/* Agreement checkboxes handle */
$('.o-agreement input[type="checkbox"]').on('click', function() {
  if ($('#tac-agreement').is(':checked') && $('#p-agreement').is(':checked')) {
    $btnSubmit.removeClass('disabled');
  } else {
    $btnSubmit.addClass('disabled');
  }
});

/* Payment type checkboxes */
$('.o-payment-check input[type="checkbox"]').on('click', function() {
  $('.o-payment-check input[type="checkbox"]').prop('checked', false);
  $(this).prop('checked', true);
  $btnSubmit.removeClass('disabled');
});