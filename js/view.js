// JavaScript Document
$(document).ready(function(){
    
    $('page').css("min-height", $(window).height() - 50 );
    
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
    $('page').css("min-height", $(window).height() - 50 ); 
});