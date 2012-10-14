root.myNamespace.create('DnaGifts.Gift', {
    updateImagePreview: function(type)
    {
        var imgname = jQuery("#jform_"+type+"_image").val();
        imgsrc = juri+"/media/com_dnagifts/images/"+type+"/"+imgname;
        console.log("IMGSRC: "+imgsrc);
        jQuery("div#imagesContainer-"+type+" img:first").attr('src',imgsrc);
    }
});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
   var ns = DnaGifts.Gift;
   jQuery("#jform_characters_image").bind("change", function(){ns.updateImagePreview('characters')});
   jQuery("#jform_text_image").bind("change", function(){ns.updateImagePreview('text')});
});