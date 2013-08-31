root.myNamespace.create('Base.test', {
    is_paused: false,
    is_stopped: false,
    currQuestion: undefined,
    nextQuestion: function()
    {
        var ns = Base.test;
        var nsCD = Base.countdown;
        
        if (ns.is_stopped)
            return false;
        
        if (nsCD.is_paused) {
            if (ns.is_paused)
                ns.executePause();
            ns.is_paused = true;
            return false;
        }
        $("#countdown").html('<em style="color: LightGrey">Next question loading ...</em>');
        
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
            
            $("#pausebutton").show();
            $("#pausedivider").show();
            $("#passbutton").show();
            $("#countdown").show();
        }, 1000);
        
        return true;
    },
    testComplete: function() {
        var ns = Base.test;
        ns.updateProgress();
        $("#countdown").countdown("pause");
        ns.is_stopped = true;
        $(".answer, #loadingdiv").hide();
        $("#countdown").html('<em style="color: LightGrey">You have completed the test</em>');
        $("#questiontext").html("Thank you for participating in the Dymaic Natural Ability (DNA) Test.<br/>We will be emailing your report to [email address]");
        $("#questiontext, #countdown").show();
    },
    executePause: function()
    {
        var ns = Base.test;
        ns.clearPreviousQuestion();
        $("#pausebutton").hide();
        $("#pausedivider").hide();
        $("#pausebutton").hide();
        $("#playbutton").show();
    },
    executePlay: function()
    {
        var ns = Base.test;
        var nsCD = Base.countdown;
        ns.is_paused = false;
        nsCD.is_paused = false;
        $("#pausediv").hide();
        ns.nextQuestion();
        $("#playbutton").hide();
    },
    clearPreviousQuestion: function()
    {
        if (!Base.countdown.is_paused)
            $("#countdown").html('<em style="color: LightGrey">Next question loading ...</em>');
        else
            $("#countdown").html('<em style="color: LightGrey">Click the play-button to continue...</em>');
        $("#questiontext").hide();
        $(".answer").hide();
        
        if (!Base.countdown.is_paused)
            $("#loadingdiv").show();
        else
            $("#pausediv").show();
    },
    showNextQuestion: function()
    {
        $("#loadingdiv").hide();
        $("#questiontext").show();
        $(".answer").show();
    },
    fetchNextQuestion: function()
    {
        var nsCD = Base.countdown;
        var nextquestion = undefined;
        $.each(surveydata, function(index) {
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
        $("#questiontext").html(surveydata[this.currQuestion].question);
        
        this.updateProgress();
    },
    updateProgress: function(){
        var counts = this.countQuestions();
        var ssdone = counts.done != 1 ? 's' : '';
        var sstogo = counts.togo != 1 ? 's' : '';
        $("#progress").html(counts.done + " Question"+ssdone+" completed | "+counts.togo+" Question"+sstogo+" to go");
    },
    saveAnswer: function()
    {
        var ns = Base.test;
        ns.is_stopped = true;
        $('#countdown').countdown('pause');
        
        // this function will save the answer
        var answer = $(this).metadata().answer;
        surveydata[ns.currQuestion].answer = answer;
        
        // ... and attempt to load the next question
        ns.is_stopped = false;
        $('#countdown').countdown('resume');
        $('#countdown').hide();
        $("#pausedivider").hide();
        $("#pausebutton").hide();
        $("#passbutton").hide();
        ns.nextQuestion();
        return false;
    },
    countQuestions: function()
    {
        var counts = {total: 0, done: 0, togo: 0};
        $.each(surveydata, function(index) {
            counts.total++
            if (surveydata[index].answer)
                counts.done++;
        });
        counts.togo = counts.total - counts.done;
        return counts;
    },
    autoPassQuestion: function() {
        var ns = Base.test;
        $("#pausedivider").hide();
        $("#pausebutton").hide();
        $("#passbutton").hide();
        var questionDict = surveydata.shift();
        surveydata.push(questionDict);
        ns.nextQuestion();
    },
    
    pauseTest: function() {
        $("#pausebutton").hide();
        $("#pausedivider").hide();
        Base.countdown.is_paused = true;
        Base.test.autoPassQuestion();
    },
    
    //------------------------------------------------------------------------
    onload_functions: function()
    {
        var nsCD = Base.countdown;
        nsCD.createCountDown(7, this.autoPassQuestion);
        nsCD.startCountDown();
        this.nextQuestion();
        $.metadata.setType('attr','data');
    }
});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
    var nsTst = Base.test;
    // Example of how to ensure certain functions only execute or get queued if
    //  a given page_namespace is present
    if (root.exists_page_namespace('dna.TestSpace'))
    {
        // check if the given namspace already exists
        if (root.myNamespace.exists('Base.test')) {
            //alert("That namespace already exists :: DNA");
        }
        else { 
            //alert("That namespace is still available :: DNA");
        }
        Base.test.onload_functions()
    }
    else
    {
        alert("No valid page namespace was found");
    }
    
    $("#pausebutton").bind("click", nsTst.pauseTest);
    $(".playbutton").bind("click", nsTst.executePlay);
    $("#passbutton").bind("click", nsTst.autoPassQuestion);
    $(".answerbutton").bind("click", nsTst.saveAnswer);
});