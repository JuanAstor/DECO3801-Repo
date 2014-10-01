// JavaScript Document
$(document).ready(function(){
    
    // Fix height of page content to match window minus header height
    $('page').css("min-height", $(window).height() - $('header').height() );
    
    $('nav h4:first').click(function(){
        window.location.href = "index.php";
    });

    $('nav h4').click(function () {
        $(this).next('navgroup').stop().slideToggle(400);
    });

    $('nav-handle').click(function () {
        $('nav').stop().slideToggle(400);
    });
});

$(window).resize(function() {
    $('page').css("min-height", $(window).height() - $('header').height() );
});