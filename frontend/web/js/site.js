var s = skrollr.init({forceHeight: false});
$(document).ready(function(){
  if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    // if not mobile device, unmute the video
    var video = document.getElementById('video1');
    video.volume = 0.5;
    video.muted = false;
  }

  setTimeout(function() {
    checkHash();
  }, 200);
});

// calculate position from top and assign according class to menu item
$(document).scroll(function () {
  var top = $(document).scrollTop();
  if (top >=0) {
    $('.top-nav a').removeClass('active');
  }
  if (top >= 640) {
    $('.top-nav a').removeClass('active');
    $('.top-nav a:eq(0)').addClass('active');
  }

  if (top >= 800) {
    $('.arch.arch-blue.skrollable.skrollable-between').addClass('empty');
  }
  if (top < 800 || top > 1900) {
    $('.arch.arch-blue.skrollable.skrollable-between').removeClass('empty');
  }

  if (top >= 4000) {
    $('.top-nav a').removeClass('active');
    $('.top-nav a:eq(1)').addClass('active');
  }
  if (top >= 6900) {
    $('.top-nav a').removeClass('active');
    $('.top-nav a:eq(2)').addClass('active');
  }
  if (top >= 11400) {
    $('.top-nav a').removeClass('active');
    $('.top-nav a:eq(3)').addClass('active');
  }
});

function checkHash() {
  var hashLocation = location.hash.split('#');
  if (hashLocation[1]) {
    scrollToSection(hashLocation[1]);
  }
}

function scrollToSection(section) {
  var top = 0;
  switch(section) {
    case 'section-station':
      top = 640;
      break;
    case 'section-printing':
      top = 9200;
      break;
    case 'section-plus':
      top = 13200;
      break;
    case 'section-koders':
      top = 17400;
      break;
  }

  $(document).scrollTop(top);
}