// JavaScript Document
$(document).ready(function(){

	$('navgroup:first').slideDown();

	$('nav h4').click(function () {
		$(this).next().stop().slideToggle(400);
	});

	$('nav-handle').click(function () {
		$('nav').stop().slideToggle(400);
	});
});