$('.btn-post').on('click', function(event) {
  event.preventDefault();
  var $this = $(this);

  $this.addClass('disabled');
  var prevClassName = $this.find('i').attr('class');
  $this.find('i').attr('class', 'fa fa-circle-o-notch fa-spin');

  $.post($this.attr('href'), function (data) {
    if (data.status === 'success') {
      $this.find('i').attr('class', prevClassName);
      location.reload();
    }
  });
});