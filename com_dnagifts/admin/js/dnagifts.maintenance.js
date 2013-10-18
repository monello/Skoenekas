root.myNamespace.create('DnaGifts.maintenance', {
	saveApprovedBtn: function()
	{
		var oldvalue = jQuery("select#approvedvalue option:selected").val();
		var newvalue = jQuery("#newapproved").val();
		var fieldtype = jQuery(this).metadata().fieldtype;
		
		if (!oldvalue || oldvalue == 0) {
			alert("Please select a value");
			return false;
		}
		if (!newvalue) {
			alert("You did not enter a proper value");
			return false;
		}
		
		var goahead = confirm("Are you sure you want to update all the occurrences of the value: "+oldvalue+" to "+newvalue+"?");
		if (!goahead)
			return false;
		
		DnaGifts.maintenance.showprocessing();
		
		var url=juri+'/index.php?option=com_dnagifts&format=json&task=maintenance.saveMappedValue';
		jQuery.ajax({
			type: "POST",
			url: url,
			data: {
				oldvalue: oldvalue,
				newvalue: newvalue,
				counter: 0,
				fieldtype: fieldtype
			},
			success: function(json) {
				if (!json.success) {
					alert(json.message);
					return false;
				}
				DnaGifts.maintenance.hideprocessing();
				var selectedOption = jQuery("select#approvedvalue option:selected");
				jQuery(selectedOption).html(newvalue);
				jQuery(selectedOption).val(newvalue);
				jQuery("#newapproved").val('');
				DnaGifts.maintenance.updateAutoSuggestValue(oldvalue, newvalue);
			},
			error: function(err) {
				alert("An Error occurred.\nStatus Text: "+err.statusText+"\nStatus: "+err.status+"\nReady State: "+err.readyState);
			}
		});
	},
	saveAsIsValue: function()
	{
		var counter = jQuery(this).metadata().counter;
		var oldvalue = newvalue = jQuery(this).metadata().value;
		var fieldtype = jQuery(this).metadata().fieldtype;
		var howmany = jQuery(this).metadata().howmany;
		
		var goahead = confirm("You are keeping this value as is "+oldvalue+"\nThis will affect "+howmany+" values.\nAre you sure you want to continue?");
		if (!goahead)
			return false;
		
		DnaGifts.maintenance.showprocessing();
		
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
				DnaGifts.maintenance.hideprocessing();
				jQuery("tr#tr_"+json.counter).fadeOut().remove();
				DnaGifts.maintenance.addAutoSuggestValue(newvalue);
				jQuery("#approvedvalue").append('<option value="'+newvalue+'">'+newvalue+'</option>');
			},
			error: function(err) {
				alert("An Error occurred.\nStatus Text: "+err.statusText+"\nStatus: "+err.status+"\nReady State: "+err.readyState);
			}
		});
	},
	
	saveMappedValue: function()
	{
		var counter = jQuery(this).metadata().counter;
		var oldvalue = jQuery(this).metadata().value;
		var fieldtype = jQuery(this).metadata().fieldtype;
		var newvalue = jQuery("#mapped_"+counter).val();
		var howmany = jQuery(this).metadata().howmany;

		if (!newvalue) {
			alert("You did not enter a proper value");
			return false;
		}
		
		var goahead = confirm("Are you sure you want to update all the occurrences of the value: "+oldvalue+" to "+newvalue+"?\nThis will affect "+howmany+" values.");
		if (!goahead)
			return false;
		
		DnaGifts.maintenance.showprocessing();
		
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
				DnaGifts.maintenance.hideprocessing();
				jQuery("tr#tr_"+json.counter).fadeOut().remove();
				DnaGifts.maintenance.addAutoSuggestValue(newvalue);
				jQuery("#approvedvalue").append('<option value="'+newvalue+'">'+newvalue+'</option>');
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
		var howmany = jQuery(this).metadata().howmany;
		
		var goahead = confirm("Are you sure you want to delete all the occurrences of the value: "+oldvalue+"?\nThis will affect "+howmany+" values.\nIf you continue, this action cannot be undone");
		if (!goahead)
			return false;
		
		DnaGifts.maintenance.showprocessing();
		
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
				DnaGifts.maintenance.hideprocessing();
				jQuery("tr#tr_"+json.counter).fadeOut().remove();
			},
			error: function(err) {
				alert("An Error occurred.\nStatus Text: "+err.statusText+"\nStatus: "+err.status+"\nReady State: "+err.readyState);
			}
		});
	},
	addAutoSuggestValue: function(newvalue)
	{
		var i = autoSuggestData.indexOf(newvalue);
		if (i < 0)
			autoSuggestData.unshift(newvalue);
	},
	deleteAutoSuggestValue: function(oldvalue)
	{
		var i = autoSuggestData.indexOf(oldvalue);
		autoSuggestData.splice(i,1);
	},
	updateAutoSuggestValue: function(oldvalue, newvalue)
	{
		var i = autoSuggestData.indexOf(oldvalue);
		autoSuggestData[i] = newvalue;
	},
	showprocessing: function()
	{
		jQuery("#maintenanceWrapper").addClass("isprocessing");
		jQuery("#maintenanceWrapper :input").attr("disabled", true);
		jQuery("#processing").show();
	},
	hideprocessing: function()
	{
		jQuery("#maintenanceWrapper").removeClass("isprocessing");
		jQuery("#maintenanceWrapper :input").attr("disabled", false);
		jQuery("#processing").fadeOut();
	},
	//------------------------------------------------------------------------
    onload_functions: function()
    {
		var ns = DnaGifts.maintenance;
		jQuery( '.autocomplete' ).autocomplete({ source: autoSuggestData });
		jQuery(document).on("click", ".asisBtn", ns.saveAsIsValue);
		jQuery(document).on("click", ".saveBtn", ns.saveMappedValue);
		jQuery(document).on("click", ".deleteBtn", ns.deleteBadValue);
		jQuery(document).on("click", "#saveApprovedBtn", ns.saveApprovedBtn);
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

