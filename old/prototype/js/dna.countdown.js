root.myNamespace.create('Base.countdown', {
    shortly: undefined,
    duration: undefined,
    togo: 7,
    is_paused: false,
    createCountDown: function(duration, callback)
    {
        this.duration = duration ? duration : 7; // defaults to 7 seconds
        $('#countdown').countdown({until: this.shortly, onExpiry: callback, onTick: this.watchCountDown}); 
    },
    startCountDown: function()
    {
        this.shortly = new Date(); 
        this.shortly.setSeconds(this.shortly.getSeconds() + this.duration); 
        $('#countdown').countdown('change', {until: this.shortly}); 
    },
    watchCountDown: function(periods) {
        var ns = Base.countdown;
        ns.togo = periods[6];
        ss = ns.togo > 1 ? 's' : '';
        if (ns.is_paused)
            $('#countdown').html('<span style="color: #ff8000">Pausing in ' + ns.togo + ' second'+ ss+'</span>');
        else
            $('#countdown').text('Just ' + ns.togo + ' second'+ ss +' to go');
        return true;
    }
});

 
