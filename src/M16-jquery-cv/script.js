// script.js

$(document).ready(function() {
  // Smooth scroll for internal links
  $('a.nav-link[href^="#"]').on('click', function(e) {
    e.preventDefault();
    var target = this.hash;
    var $target = $(target);
    if ($target.length) {
      $('html, body').animate({
        scrollTop: $target.offset().top - 60 // offset for fixed navbar
      }, 600);
    }
    // collapse navbar on mobile
    if ($('.navbar-collapse').hasClass('show')) {
      $('.navbar-toggler').click();
    }
  });

  // Highlight nav items on scroll
  var sections = $('section[id]');
  var navLinks = $('a.nav-link');

  $(window).on('scroll', function() {
    var currentPos = $(this).scrollTop() + 70;
    sections.each(function() {
      var top = $(this).offset().top;
      var bottom = top + $(this).outerHeight();
      var id = $(this).attr('id');
      if (currentPos >= top && currentPos <= bottom) {
        navLinks.removeClass('active');
        $('a.nav-link[href="#' + id + '"]').addClass('active');
      }
    });
  });
});
