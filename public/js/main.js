$(function(){

	// Hamburger Click
	$('.hamburger').on('click',function(e){
             e.preventDefault();
        toggleMenu();
    });
    
    function toggleMenu(){
        $('body').toggleClass('nav-open');
        $('.lines').toggleClass('open');
        // $('.link').toggleClass('bounce');

    }

    // Back to Top
    if ($('#back-to-top').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    // Accordion

    // disable right click
    // document.addEventListener('contextmenu', event => event.preventDefault());
 
    // document.onkeydown = function (e) {
 
    //     // disable F12 key
    //     if(e.keyCode == 123) {
    //         return false;
    //     }
 
    //     // disable I key
    //     if(e.ctrlKey && e.shiftKey && e.keyCode == 73){
    //         return false;
    //     }
 
    //     // disable J key
    //     if(e.ctrlKey && e.shiftKey && e.keyCode == 74) {
    //         return false;
    //     }
 
    //     // disable U key
    //     if(e.ctrlKey && e.keyCode == 85) {
    //         return false;
    //     }
    // }
    
});