root.myNamespace.create('DnaGifts.testdetail', {
	showall: function () 
	{
		var ns = DnaGifts.testdetail;
		ns.resetSelectListFilters();
		
		jQuery(".dnaTestCard").show();
	},
	showmissed: function () 
	{
		var ns = DnaGifts.testdetail;
		ns.resetSelectListFilters();
		
		jQuery(".dnaTestCard").show();
		jQuery(".hasanswer").fadeOut();
	},
	showgood: function () 
	{
		var ns = DnaGifts.testdetail;
		ns.resetSelectListFilters();
		
		jQuery(".dnaTestCard").show();
		jQuery(".noanswer").fadeOut();
	},
	filterByScores: function ()
	{
		var ns = DnaGifts.testdetail;
		ns.resetSelectListFilters("fltScores");
		
		var val = jQuery(this).val();
		var clss = "scr_" + val;
		if (val >= 0) {
			jQuery(".dnaTestCard").hide();
			jQuery("." + clss).show();
		} else {
			jQuery(".dnaTestCard").show();
		}
	},
	resetSelectListFilters: function(except)
	{
		if (except)
			jQuery("#dnaFiltersSet select").not("[id='"+except+"']").val(-1);
		else
			jQuery("#dnaFiltersSet select").val(-1);
	},
	
	//------------------------------------------------------------------------
    onload_functions: function()
    {
		var ns = DnaGifts.testdetail;
		jQuery(document).on( "click", "#showall", ns.showall );
		jQuery(document).on( "click", "#showmissed", ns.showmissed );
		jQuery(document).on( "click", "#showgood", ns.showgood );
		jQuery(document).on( "change", "#fltScores", ns.filterByScores );
		ns.resetSelectListFilters();
    }
});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
	var ns = DnaGifts.testdetail;
    ns.onload_functions();
});