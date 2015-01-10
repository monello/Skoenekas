jQuery(function( $ ){
	$('#dnaSideMenu a').click(function(){
		$('#dnaSideMenu a').removeClass("active");
		var href = $(this).attr("href");
		$.scrollTo( href, 1000,
			{
				offset: {
					top: -230,
					left: 0
				}
			}
		);
		$(this).addClass("active");
		history.pushState({}, '', $(this).attr("href"));
		return false;
	});
});
