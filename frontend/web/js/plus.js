if (!(/Android|iPhone|iPad|iPod|BlackBerry/i).test(navigator.userAgent || navigator.vendor || window.opera) && $(window).width() > 1000) {
  var s = skrollr.init({forceHeight: false});
} else {
  var fluff = 0;
  if ($(window).width() < 600) {
    fluff = 100;
  }

  $(window).scroll(function() {
    var top = $(this).scrollTop();
    var cTop = $('.p-p-m-cont').offset().top - 200;
    var cMiddle = $('.p-p-desc.p-p-d-3').offset().top - 400;
    var cBottom = cMiddle + 800;

    // Handle phone position
    if (top >= cTop && top <= cMiddle + fluff) {
      $('.i-m-major').css({
        position: 'fixed',
        top: '200px'
      });
    } else if (top > cMiddle + fluff && top <= cBottom) {
      var topMinus = 200 - (top - cBottom + 800 - fluff);
      $('.i-m-major').css({
        position: 'fixed',
        top: topMinus + 'px'
      });
    } else {
      $('.i-m-major').css({
        position: 'absolute',
        top: 0
      });
    }

    // Handle phone content
    var title2Top = $('.p-p-title.p-p-t-2').offset().top - 500;
    var title3Top = $('.p-p-title.p-p-t-3').offset().top - 500;
    if (top <= title2Top) {
      $('.i-m-major').addClass('hidden');
      $('.i-m-major.i-m-search').removeClass('hidden');
    }
    if (top > title2Top && top <= title3Top) {
      $('.i-m-major').addClass('hidden');
      $('.i-m-major.i-m-preview').removeClass('hidden');
    }
    if (top > title3Top) {
      $('.i-m-major').addClass('hidden');
      $('.i-m-major.i-m-shipping').removeClass('hidden');
    }
  });
}
