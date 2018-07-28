$(document).on('click', '.current-photo-delete', function(e) {
  e.preventDefault();
  $.ajax({
    type: 'post',
    url: '/user/delete-photo?id={$model->id}',
    success: function(data) {
      if (data.status === 'success') {
        $('.current-photo').remove();
      }
    }
  });
});

$(document).on('click', '.btn-add-setting', function(e) {
  e.preventDefault();

  $(this).parent().find('.add-field-container').slideDown(200);
});

$(document).on('click', '.btn-a-f', function(e) {
  e.preventDefault();
  var $this = $(this);
  var $errorSummary = $this.parent().find('.error-summary');

  var data = {
    user_id: $('.add-field-container input[name="user_id"]').val(),
    title: $('.add-field-container input[name="title"]').val(),
    key: $('.add-field-container input[name="key"]').val(),
    value: $('.add-field-container input[name="value"]').val(),
    type: $('.add-field-container select[name="type"]').val(),
    writable: $('.add-field-container input[name="writable"]').val()
  };

  $.ajax({
    type: 'post',
    url: '/user/add-setting-field',
    data: data,
    success: function(result) {
      if (result.status === 'success') {
        $errorSummary.hide();
        $this.parent().parent().slideUp(200);
        var newFieldBlock = '<div class="form-group">' +
          '<label class="control-label" for="settings-'+ data.key +'-value">'+ data.title +'</label>' +
          '<input type="text" id="settings-'+ data.key +'-value" class="form-control" name="Settings['+ data.key +'][value]" value="'+ data.value +'">' +
          '</div>';
        $this.parent().parent().before(newFieldBlock);

      } else {
        var message = result.message || 'An error occurred.';
        if (Array.isArray(message)) {
          message = message.join('<br>');
        }

        $errorSummary.html(message);
        $errorSummary.show();
      }
    }
  });

});


$(document).on('click', '.btn-a-d', function(e) {
  e.preventDefault();

  $(this).parent().find('.error-summary').hide();
  $(this).parent().parent().slideUp(200);
});