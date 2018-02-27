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

  mywindow.print();
  //mywindow.close();

});

var img = $('img.p-img-original');
if (img.width() > img.height()) {
  img.addClass('rotate');
  img.width(img.parent().height());
}