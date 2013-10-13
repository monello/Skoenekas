root.myNamespace.create('Base.countdown', {
    language: 'af',
    running: true,
    translations: {
      af: {
        pause: "Wag in",
        second: "sekonde",
        just: "Net",
        togo: "om te gaan"
      },
      en: {
        pause: "Pausing in",
        second: "second",
        just: "Just",
        togo: "to go"
      }
    },
    translate: function(key) {
      var ns = Base.countdown;
      return ns.translations[ns.language][key];
    },
    shortly: undefined,
    duration: undefined,
    togo: 7,
    createCountDown: function(duration, callback)
    {
		Base.countdown.duration = (parseInt(duration)) ? parseInt(duration) : parseInt(surveyconfig.default_duration); 
		jQuery('#dnaCountdown').countdown({until: this.shortly, onExpiry: callback, onTick: this.watchCountDown}); 
    },
    startCountDown: function(duration_override)
    {
        this.shortly = new Date(); 
		var duration = duration_override ? duration_override : Base.countdown.duration;
        this.shortly.setSeconds(this.shortly.getSeconds() + duration); 
		jQuery('#dnaCountdown').countdown("resume");
        jQuery('#dnaCountdown').countdown('option', {until: this.shortly}); 
    },
    watchCountDown: function(periods) {
		var ns = Base.countdown;
        if (!ns.running)
          return true;
        ns.togo = periods[6];
        ss = ns.togo > 1 ? 's' : '';
		if (ns.togo < 1)
			return true;
			
        jQuery('#dnaCountdown').html(ns.translate("just") + ' <span style="font-size: 14pt;font-weight:bold;">' + ns.togo + '</span> ' + ns.translate("second") + ss + ' ' + ns.translate("togo")).show();
        jQuery("#dnaInteractions").show();
        
        return true;
    }
});

Base.Helpers.bind_load(function () {
    var ns = Base.countdown;
    jQuery.metadata.setType('attr','data');
    ns.language = jQuery("#dnaTestSpace").metadata().userlanguage;
});
