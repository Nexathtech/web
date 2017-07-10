$(document).ready(function () {

  $('a.grid-view-confirm').on('click', function (event) {

    event.preventDefault();
    var $this = $(this);

    swal({
      type: 'warning',
      title: 'Are you sure?',
      text: 'This action is permanent and cannot be undone.',
      allowOutsideClick: true,
      showCancelButton: true,
      showConfirmButton: true,
      confirmButtonColor: '#ed5565',
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: false,
      showLoaderOnConfirm: true
    }, function () {
      $.post($this.attr('href'), function (data, status) {
        console.log(status);
        if (status === 'success') {
          location.reload();
        }
      });
    });
  })
});