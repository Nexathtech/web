$('.print-btn').on('click', function(e) {
  e.preventDefault();

  var printContents = $('.print-block').html();

  var mywindow = window.open('', 'PRINT', 'height=600,width=900');

  mywindow.document.write('<html><head><title>' + document.title  + '</title>');
  mywindow.document.write('<link rel="stylesheet" href="/css/print-photos.css" type="text/css">');
  mywindow.document.write('</head><body >');
  mywindow.document.write(printContents);
  mywindow.document.write('</body></html>');

  mywindow.document.close(); // necessary for IE >= 10
  mywindow.focus(); // necessary for IE >= 10*/

  mywindow.onload = function() {
    mywindow.print();
    mywindow.close();
  }

});

$('.i-filter > span').on('click', function () {
  $('.i-filter > span').removeClass('active');
  $(this).addClass('active');
  var type = $(this).text();
  $('.more-photos img').hide();
  $('.more-photos img.' + type).show();
});

$('.more-photos-btn').on('click', function (e) {
  e.preventDefault();
  $('.more-photos').slideToggle('show');
});

$('.more-photos img').on('click', function (e) {
  e.preventDefault();

  if ($(this).hasClass('active')) {
    $('.ad-image[src="'+ $(this).attr('src') +'"]').parent().remove();
    $(this).removeClass('active');
  } else {
    $('.print-block').append('<div class="p-item"><img class="p-img ad-image" src="'+ $(this).attr('src') +'"></div>');
    $(this).addClass('active');
  }

});

var img = $('img.p-img-original');
if (img.width() > img.height() + 10) {
  img.addClass('rotate');
  img.width(img.parent().height());
}