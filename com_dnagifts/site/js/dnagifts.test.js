root.myNamespace.create('DnaGifts.test', {
    language: 'en',
    translations: {
      af: {
        nextQuestionLoading: "Volgende vraag laai ...",
        completedTest: "U het die toets voltooi",
        thankYou: "Dankie dat u aan die Dynamic Natutal Ability (DNA) toets deelgeneem het.<br/>U resultate sal binnekort aan u ge-epos word.",
        hitPlay: "Kliek die \"Play\" knoppie sodra u gereed is om voort te gaan...",
        question: "vraag",
        questions: "vrae",
        completed: "voltooi",
        togo: "om te gaan",
        complete: "voltooi",
        thetestis: "Die toets is"
      },
      en: {
        nextQuestionLoading: "Next question loading ...",
        completedTest: "You have completed the test",
        thankYou: "Thank you for participating in the Dynamic Natural Ability (DNA) Test.<br/>We will be emailing your report to you soon.",
        hitPlay: "Click the play-button as soon as you are ready to continue...",
        question: "question",
        questions: "questions",
        completed: "completed",
        togo: "to go",
        complete: "complete",
        thetestis: "The test is"
      }
    },
    translate: function(key) {
      var ns = DnaGifts.test;
      return ns.translations[ns.language][key];
    },
    is_paused: false,
    is_stopped: false,
    currQuestion: undefined,
    nextQuestion: function()
    {
        var ns = DnaGifts.test;
        var nsCD = Base.countdown;
        
        if (ns.is_stopped)
            return false;
        
        if (nsCD.is_paused) {
            if (ns.is_paused)
                ns.executePause();
            ns.is_paused = true;
            return false;
        }
        jQuery("#startmessage").hide();
        jQuery("#dnaProgress, #dnaProgressBar").show();
        jQuery("#dnaCountdown").html('<em style="color: #ff8000">'+ns.translate('nextQuestionLoading')+'</em>');
        
        ns.clearPreviousQuestion();
        
        ns.currQuestion = ns.fetchNextQuestion();
        
        if (!ns.currQuestion && ns.currQuestion !== 0) {
            ns.testComplete();
            return false;
        }
        
        // load the next question
        ns.placeNextQuestion();
        
        setTimeout(function() {
            ns.showNextQuestion();
        
            // restart the countdown
            nsCD.startCountDown();
            
            jQuery("#dnaPauseButton").show();
            jQuery(".dnaPauseDivider").show();
            jQuery("#dnaPassButton").show();
            jQuery("#dnaCountdown").show();
        }, 1000);
        
        return true;
    },
    testComplete: function() {
        var ns = DnaGifts.test;
        ns.updateProgress();
        jQuery("#dnaCountdown").countdown("pause");
        ns.is_stopped = true;
        jQuery(".dnaAnswerButton, #dnaLoadingDiv").hide();
        jQuery("#dnaCountdown").html('<em style="color: #ff8000">'+ns.translate('completedTest')+'</em>');
        jQuery("#dnaQuestionText").html(ns.translate("thankYou"));
        jQuery("#dnaQuestionText, #dnaCountdown").show();
        jQuery("#dnaProgressBar").fadeOut(1500, function(){jQuery("#postTestHome").show();});
    },
    executePause: function()
    {
        var ns = DnaGifts.test;
        ns.clearPreviousQuestion();
        jQuery("#dnaPauseButton").hide();
        jQuery(".dnaPauseDivider").hide();
        jQuery(".dnaPlayButton").show();
    },
    executePlay: function()
    {
        var ns = DnaGifts.test;
        var nsCD = Base.countdown;
        ns.is_paused = false;
        nsCD.is_paused = false;
        jQuery("#dnaPauseDiv").hide();
        ns.nextQuestion();
        jQuery(".dnaPlayButton").hide();
    },
    clearPreviousQuestion: function()
    {
        var ns = DnaGifts.test;
        if (!Base.countdown.is_paused)
            jQuery("#dnaCountdown").html('<em style="color: #ff8000">'+ns.translate('nextQuestionLoading')+'</em>');
        else
            jQuery("#dnaCountdown").html('<em style="color: #ff8000">'+ns.translate('hitPlay')+'</em>');
        jQuery("#dnaQuestionText").hide();
        jQuery(".dnaAnswerButton").hide();
        
        if (!Base.countdown.is_paused)
            jQuery("#dnaLoadingDiv").show();
        else
            jQuery("#dnaPauseDiv").show();
    },
    showNextQuestion: function()
    {
        jQuery("#dnaLoadingDiv").hide();
        jQuery("#dnaQuestionText").show();
        jQuery(".dnaAnswerButton").show();
    },
    fetchNextQuestion: function()
    {
        var nsCD = Base.countdown;
        var nextquestion = undefined;
        jQuery.each(surveydata, function(index) {
            if (!surveydata[index].answer) {
                nextquestion = index;
                nsCD.duration = surveydata[index].duration;
                return false;
            }
            return true;
        });
        return nextquestion;
    },
    placeNextQuestion: function()
    {
        // this function updates the UI and adds the new question to the screen
        jQuery("#dnaQuestionText").html(surveydata[this.currQuestion].question);
        
        this.updateProgress();
    },
    updateProgress: function(){
        var ns = DnaGifts.test;
        var counts = this.countQuestions();
        var ssdone = counts.done != 1 ? ns.translate('questions') : ns.translate('question');
        var sstogo = counts.togo != 1 ? ns.translate('questions') : ns.translate('question');
        jQuery("#progressbar").progressbar("value", counts.progress);
        jQuery("#progresspercent").text(ns.translate("thetestis")+" "+counts.progress+"% "+ns.translate('complete'));
        jQuery("#dnaProgress").html(
            counts.done + " " + ssdone + " " + ns.translate('completed')+" | " +
            counts.togo + " " + sstogo + " " + ns.translate('togo'));
    },
    saveAnswer: function()
    {
        var ns = DnaGifts.test;
        
        // if the user answers a question during the count-down to pause, pause-action will be cancelled
        if(Base.countdown.is_paused) {
            ns.executePlay();
        }
        
        ns.is_stopped = true;
        jQuery('#dnaCountdown').countdown('pause');
        
        // this function will save the answer
        var answer = jQuery(this).metadata().answer;
        surveydata[ns.currQuestion].answer = answer;
        
        // ... and attempt to load the next question
        ns.is_stopped = false;
        jQuery('#dnaCountdown').countdown('resume');
        jQuery(".dnaPauseDivider").hide();
        jQuery("#dnaPauseButton").hide();
        jQuery("#dnaPassButton").hide();
        ns.nextQuestion();
        return false;
    },
    countQuestions: function()
    {
        var counts = {total: 0, done: 0, togo: 0};
        jQuery.each(surveydata, function(index) {
            counts.total++
            if (surveydata[index].answer)
                counts.done++;
        });
        counts.togo = counts.total - counts.done;
        counts.progress = Math.round(counts.done / counts.total * 100);
        return counts;
    },
    
    autoPassQuestion: function() {
        var ns = DnaGifts.test;
        jQuery(".dnaPauseDivider").hide();
        jQuery("#dnaPauseButton").hide();
        jQuery("#dnaPassButton").hide();
        var questionDict = surveydata.shift();
        surveydata.push(questionDict);
        ns.nextQuestion();
    },
    
    pauseTest: function() {
        jQuery("#dnaPauseButton").hide();
        jQuery(".dnaPauseDivider").hide();
        Base.countdown.is_paused = true;
        DnaGifts.test.autoPassQuestion();
    },

    //------------------------------------------------------------------------
    onload_functions: function()
    {
        var nsCD = Base.countdown;
        nsCD.is_paused = true;
        jQuery("#dnaPauseButton").hide();
        jQuery(".dnaPauseDivider").hide();
        nsCD.createCountDown(7, this.autoPassQuestion);
        //nsCD.startCountDown();
        //this.nextQuestion();
        
    }
});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
    var ns = DnaGifts.test;
    jQuery.metadata.setType('attr','data');
    ns.language = jQuery("#dnaTestSpace").metadata().userlanguage;
    ns.onload_functions();
    jQuery("#dnaPauseButton").bind("click", ns.pauseTest);
    jQuery(".playbutton").bind("click", ns.executePlay);
    jQuery("#dnaPassButton").bind("click", ns.autoPassQuestion);
    jQuery(".btnAnswer").bind("click", ns.saveAnswer);
    jQuery("#progressbar").progressbar({ value: 0 });
});
