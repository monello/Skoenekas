/* DNA Gifts :: DNA Gifts page */

root.myNamespace.create('DnaGifts.General', {
  toggleExtraChurchInfo: function() {
    var hasChurch = jQuery("input[name='jform[in_church]']:checked").val();
    if (hasChurch > 0) {
      jQuery("#extrachurchinfo").slideDown();
    } else {
      jQuery("#extrachurchinfo").slideUp();
      jQuery("#jform_church_name, #jform_pastor_reverend").val('');
    }
  }
});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
  var ns = DnaGifts.General;
  jQuery.metadata.setType('attr','data');
  
  jQuery("fieldset#jform_in_church input:radio").bind('click', ns.toggleExtraChurchInfo);
  
  if (jQuery("#jform_church_name").val() || jQuery("#jform_pastor_reverend").val()) {
    jQuery("#extrachurchinfo").show();
  }
  
});