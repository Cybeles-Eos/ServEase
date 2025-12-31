AOS.init();
$(window).scroll(function () {
    if ($(document).scrollTop() > 50) {
      $('.header--desktop').addClass('desktop__scrolled');
    } else {
      $('.header--desktop').removeClass('desktop__scrolled');
    }
});