$(document).ready(function() {
    var school = $(window);
    var page = $('html, body');



    $(window).scroll(function(){
        if ($(window).scrollTop() >= 100) {
            $('#header_top').addClass('animate__animated animate__slideInDown fix');
        }
        else {
            $('#header_top').removeClass('animate__animated animate__slideInDown fix');
        }
    });

















    
});