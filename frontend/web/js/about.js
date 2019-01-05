$(document).ready(function() {
  checkHash();
  //prepareContent('contact');
});

$(document).on('click', '.about-menu a', function() {
  if (!$(this).hasClass('active')) {
    var section = $(this).attr('href').replace('#', '');
    prepareContent(section);
  }

  return false;
});

function checkHash() {
  var target = location.hash.replace('#', '');
  if (target) {
    prepareContent(target);
  }
}

function prepareContent(section) {
  $('.about-menu a').removeClass('active');
  $('.about-menu a[data-section="'+section+'"]').addClass('active');
  $('.section-block').hide();
  $('.section-' + section).fadeIn(500);
}
