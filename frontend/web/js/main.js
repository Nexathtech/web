$(document).on('click', '.disabled', function(e) {
  e.preventDefault();
});

if (!getCookie('cookies_caution')) {
  setTimeout(function () {
    $('.cookie-message').fadeIn(800);
  }, 12000);
  $(document).on('click', '.c-m-close', function () {
    $('.cookie-message').fadeOut(300);
    setCookie('cookies_caution', 1, 300);
  });
}

function openTopNav() {
  var x = document.getElementById('top-nav');
  if (x.className === 'top-nav') {
    x.className += ' responsive';
  } else {
    x.className = 'top-nav';
  }
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  var exDays = exdays || 30;
  d.setTime(d.getTime() + (exDays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return null;
}
