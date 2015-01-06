$(document).ready(function() {
	var currslide = 1;

	$('#myCarousel').carousel({
		interval: 7777
	});
	
	$('#myCarousel').bind('slide.bs.carousel', function() {
		$("#dnaHeptagons"+currslide).fadeOut(500);
	});
	
	$('#myCarousel').bind('slid.bs.carousel', function() {
		$(".heptagons").hide();
		currslide = $("#myCarousel div div.active").index() + 1;
		$(".heptagon").hide();
		$("#dnaHeptagons"+currslide).fadeIn(200);
	});

	//$('ol.carousel-indicators li').tooltip();
	$('[data-toggle="tooltip"]').tooltip(); 
	
});
