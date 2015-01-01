$(document).ready(function() {
	var currslide = 1;
	$('.carousel').carousel({
		interval: 7777
	}).bind('slide', function() {
		$("#dnaHeptagons"+currslide).fadeOut(500);
	}).bind('slid', function() {
		$(".heptagons").hide();
		currslide = $("#myCarousel div div.active").index() + 1;
		$(".heptagon").hide();
		$("#dnaHeptagons"+currslide).fadeIn(200);
	});
	
	$('ol.carousel-indicators li').tooltip();
	
});
