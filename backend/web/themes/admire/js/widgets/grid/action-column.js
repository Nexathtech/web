$('[data-role="alert"]').on('click', function(e) {
  e.preventDefault();
  var mode = $(this).data('alert-mode') || null;
  var type = $(this).data('alert-type') || 'warning';
  var title = $(this).data('alert-title') || 'Are you sure?';
  var text = $(this).data('alert-text') || 'This action is permanent and cannot be undone.';
  var confirmText = $(this).data('alert-confirm') || 'Yes, I\'m sure!';
  var url = $(this).data('alert-url') || $(this).attr('href') || '';
  var close = $(this).data('alert-close') || false;
  var reloadPage = $(this).data('alert-reload') || false;
  var data = $(this).attr('data-alert');
  if (typeof data !== 'object') { data = {data: data}; }

  if (mode === 'silent') {
    // Means no need to show alert
    sendRequest();

  } else {
    swal({
      type: type,
      html: true,
      title: title,
      text: text,
      allowOutsideClick: true,
      showCancelButton: true,
      showConfirmButton: true,
      confirmButtonColor: '#ed5565',
      confirmButtonText: confirmText,
      closeOnConfirm: close,
      showLoaderOnConfirm: true
    }, function () {
      sendRequest();
    });
  }

  /**
   * Sends Ajax request to specified url
   */
  function sendRequest() {
    $.ajax({
      type: 'POST',
      url: url,
      data: data,
      success: function (data) {
        if (reloadPage) {
          window.location.reload();
        }
        console.log(data);
      }
    });
  }
});