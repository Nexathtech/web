'use strict';

var toggle = document.getElementById('toggle');
var navMenu = document.getElementById('nav-menu');
var showDescription = Array.from(document.querySelectorAll('.frequenti svg'));
var numbers = Array.from(document.querySelectorAll('.number'));
var screens = Array.from(document.querySelectorAll('.screen'));
var desc = Array.from(document.querySelectorAll('.ads-pages.desc'));
var figure = document.getElementById('figure');
var clickMe = document.getElementById('click-me');
var started = document.getElementById('started');
var numbersWrapper = document.getElementById('numbers-wrapper');
var cont = document.getElementById('cont');

showDescription.forEach(function (btn) {
  btn.addEventListener('click', function () {
    btn.classList.toggle('expand');
    var desc = btn.parentElement.nextElementSibling;
    desc.classList.toggle('expand');
  });
});

if (!/Android|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent || navigator.vendor || window.opera) && window.innerWidth > 1000) {
  var s = skrollr.init({ forceHeight: false });
} else {
  // toggle.addEventListener('click', () => {
  //   toggle.classList.toggle('extended')
  //   navMenu.classList.toggle('extended')
  //
  // }, true)


  var removeClass = function removeClass(array) {
    array.forEach(function (elem) {
      elem.classList.remove('slide');
    });
  };

  var prevScreen = null;
  var prevSlide = null;
  numbers.forEach(function (number, elem) {
    number.addEventListener('click', function (e) {
      window.scrollTo({
        'behavior': 'smooth',
        'left': 0,
        'top': numbersWrapper.offsetTop
      });
      started.style.opacity = '0';
      clickMe.style.opacity = '0';
      figure.classList.add('slide');
      removeClass(numbers);
      desc[elem].classList.add('slide');
      screens[elem].classList.add('slide');
      number.classList.add('slide');
      if (prevScreen) {
        prevScreen.classList.remove('slide');
        prevSlide.classList.remove('slide');
      }
      prevScreen = screens[elem];
      prevSlide = desc[elem];
    });
  });
}