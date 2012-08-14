root.myNamespace.create('Base.countdown', {
    language: 'af',
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
        this.duration = duration ? duration : 7; // defaults to 7 seconds
        jQuery('#dnaCountdown').countdown({until: this.shortly, onExpiry: callback, onTick: this.watchCountDown}); 
    },
    startCountDown: function()
    {
        this.shortly = new Date(); 
        this.shortly.setSeconds(this.shortly.getSeconds() + this.duration); 
        jQuery('#dnaCountdown').countdown('change', {until: this.shortly}); 
    },
    watchCountDown: function(periods) {
        var ns = Base.countdown;
        ns.togo = periods[6];
        ss = ns.togo > 1 ? 's' : '';
        if (ns.is_paused)
            jQuery('#dnaCountdown').html('<em style="color:#ff8000">' + ns.translate("pause") + ' ' + ns.togo + ' ' + ns.translate("second") + ss+'</em>');
        else
            jQuery('#dnaCountdown').text(ns.translate("just") + ' ' + ns.togo + ' ' + ns.translate("second") + ss + ' ' + ns.translate("togo"));
        return true;
    }
});

 
