$('.btn-post').on('click', function(event) {
  event.preventDefault();
  var $this = $(this);

  $this.addClass('disabled');
  $this.find('i').attr('class', 'fa fa-circle-o-notch fa-spin');

  $.ajax({
    type: 'POST',
    url: $this.attr('href'),
    data: $this.data('data') || null,
    complete: function () {
      location.reload();
    }
  });

  return false;

});