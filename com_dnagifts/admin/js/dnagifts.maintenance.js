root.myNamespace.create('DnaGifts.maintenance', {
	saveMappedValue: function()
	{
		var counter = jQuery(this).metadata().counter;
		var oldvalue = jQuery(this).metadata().value;
		var fieldtype = jQuery(this).metadata().fieldtype;
		var newvalue = jQuery("#mapped_"+counter).val();

		if (!newvalue) {
			alert("You did not enter a proper value");
			return false;
		}
		
		var url=juri+'/index.php?option=com_dnagifts&format=json&task=maintenance.saveMappedValue';
		jQuery.ajax({
			type: "POST",
			url: url,
			data: {
				oldvalue: oldvalue,
				newvalue: newvalue,
				counter: counter,
				fieldtype: fieldtype
			},
			success: function(json) {
				if (!json.success) {
					alert(json.message);
					return false;
				}
				
				jQuery("tr#tr_"+json.counter).fadeOut().remove();
			},
			error: function(err) {
				alert("An Error occurred.\nStatus Text: "+err.statusText+"\nStatus: "+err.status+"\nReady State: "+err.readyState);
			}
		});
	},
	deleteBadValue: function()
	{
		var counter = jQuery(this).metadata().counter;
		var oldvalue = jQuery(this).metadata().value;
		var fieldtype = jQuery(this).metadata().fieldtype;
		
		var url=juri+'/index.php?option=com_dnagifts&format=json&task=maintenance.deleteBadValue';
		jQuery.ajax({
			type: "POST",
			url: url,
			data: {
				oldvalue: oldvalue,
				counter: counter,
				fieldtype: fieldtype
			},
			success: function(json) {
				if (!json.success) {
					alert(json.message);
					return false;
				}
				
				jQuery("tr#tr_"+json.counter).fadeOut().remove();
			},
			error: function(err) {
				alert("An Error occurred.\nStatus Text: "+err.statusText+"\nStatus: "+err.status+"\nReady State: "+err.readyState);
			}
		});
	},
	
	//------------------------------------------------------------------------
    onload_functions: function()
    {
		var ns = DnaGifts.maintenance;
		jQuery( '.autocomplete' ).autocomplete({ source: autoSuggestData });
		jQuery(document).on("click", ".saveBtn", ns.saveMappedValue);
		jQuery(document).on("click", ".deleteBtn", ns.deleteBadValue);
    }
});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
	var ns = DnaGifts.maintenance;
	jQuery.metadata.setType('attr','data');
    ns.onload_functions();
});

