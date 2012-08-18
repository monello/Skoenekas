root.myNamespace.create('Base.countdown', {
    language: 'af',
    running: false,
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
    is_paused: false,
    createCountDown: function(duration, callback)
    {
        Base.countdown.duration = (parseInt(duration)) ? parseInt(duration) : parseInt(surveyconfig.default_duration); 
        jQuery('#dnaCountdown').countdown({until: this.shortly, onExpiry: callback, onTick: this.watchCountDown}); 
    },
    startCountDown: function()
    {
        this.shortly = new Date(); 
        this.shortly.setSeconds(this.shortly.getSeconds() + Base.countdown.duration); 
        jQuery('#dnaCountdown').countdown('change', {until: this.shortly}); 
    },
    watchCountDown: function(periods) {
        var ns = Base.countdown;
        ns.togo = periods[6];
        ss = ns.togo > 1 ? 's' : '';
        if (ns.running) {
            if (ns.is_paused) {
                jQuery('#dnaMessages').html('<em style="color:#ff8000">' + ns.translate("pause") + ' ' + ns.togo + ' ' + ns.translate("second") + ss+'</em>').show();
                jQuery('#dnaCountdown').hide()
            }
            else
                jQuery('#dnaCountdown').html(ns.translate("just") + ' <span style="font-size: 14pt;font-weight:bold;">' + ns.togo + '</span> ' + ns.translate("second") + ss + ' ' + ns.translate("togo")).show();
            jQuery("#dnaInteractions").show();
        } else {
            jQuery('#dnaCountdown').html('&nbsp;');
            ns.running = true;
        }
        
        return true;
    }
});

Base.Helpers.bind_load(function () {
    var ns = Base.countdown;
    jQuery.metadata.setType('attr','data');
    ns.language = jQuery("#dnaTestSpace").metadata().userlanguage;
});
