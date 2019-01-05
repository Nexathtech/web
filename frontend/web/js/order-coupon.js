/* Declarations */
/* global Stripe, stripe_key */
var $colorPicker = $('.order-color-choose > div');
var $btnSubmit = $('.o-submit-form button[type="submit"]');
var $stripeElements = $('#stripe-elements');

/* Color of the coupon card pick */
$colorPicker.on('click', function() {
  $colorPicker.removeClass('active');
  $(this).addClass('active');
  var imageSrc = $(this).data('image');
  $('img.oc-img').attr('src', imageSrc);

  var color = $(this).data('color');
  $('input[name="color"]').val(color);

});

/* Quantity selection handle */
$(document).on('click', '.oc-q-item', function() {
  $('.oc-q-item').removeClass('active');
  $(this).addClass('active');
  var quantity = parseInt($(this).text());
  $('input[name="quantity"]').val(quantity);
  updatePrice();
});

/* Sticker checkboxes handle */
$('input#sticker, input#sticker-geo').on('click', function() {
  updatePrice();
});

$('.oc-sticker-info').on('click', function() {
  $('.point-geo-info').show();
});
$('.pgi-close').on('click', function() {
  $(this).parent().hide();
});

/* Payment type checkboxes */
$('.o-payment-check input[type="checkbox"]').on('click', function() {
  $('.o-payment-check input[type="checkbox"]').prop('checked', false);
  $(this).prop('checked', true);
  $btnSubmit.removeClass('disabled');

  if ($('input#payment-card').is(':checked')) {
    $stripeElements.show();
  } else {
    $stripeElements.hide();
  }

});

function updatePrice() {
  var price = 0;
  var quantity = $('input[name="quantity"]').val();
  if (quantity < 500) {
    price = 50;
  } else if (quantity >= 500 && quantity < 1000) {
    price = 80;
  } else {
    price = 100;
  }

  if ($('input#sticker').is(':checked')) {
    price += 0;
  }
  if ($('input#sticker-geo').is(':checked')) {
    price += 50;
  }

  $('#oc-price').text(price.toFixed(2));
}


/**
 * Initiates Stripe related stuff
 * @param apiKey
 */
function stripeInit(apiKey) {
  var stripe = Stripe(apiKey);
  var elements = stripe.elements();
  var style = {
    base: {
      fontSize: '16px',
      color: "#32325d"
    }
  };
  var card = elements.create('card', {style: style});
  var $form = $('#payment-form');
  var $errorEl = $('#card-errors');

  // Create an instance of the card Element and add it to the according element
  card.mount('#card-element');
  card.addEventListener('change', function(event) {
    if (event.error) {
      $errorEl.text(event.error.message);
    } else {
      $errorEl.text('');
    }
  });

  // Create a token or display an error when the form is submitted.
  $form.on('submit', function(event) {
    if ($('input#payment-card').is(':checked')) {
      event.preventDefault();
      stripe.createToken(card).then(function (result) {
        if (result.error) {
          $errorEl.text(result.error.message);
        } else {
          $(this).find('button[type="submit"]').addClass('disabled');
          // Send the token to our server.
          stripeTokenHandle(result.token);
        }
      });
    }
  });
}

function stripeTokenHandle(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripe_token');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
