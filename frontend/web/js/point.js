$('.pbq-check').on('click', function() {
  var show = $(this).data('state');
  if (show) {
    $(this).parent().parent().addClass('show');
  } else {
    $(this).parent().parent().removeClass('show');
    $(this).parent().parent().addClass('hidden');
  }
  $('.pbq-check').removeClass('active');
  $(this).addClass('active');
});
