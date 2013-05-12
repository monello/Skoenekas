root.myNamespace.create('DnaGifts.test', {
    language: 'en',
    translations:
    {
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
        thetestis: "Die toets is",
        generating: "<div class=\"rptgenerating\">U DNA Gawes rapport is amper gereed</div>"
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
        thetestis: "The test is",
        generating: "<div class=\"rptgenerating\">Your DNA report is almost ready</div>"
      }
    },
    translate: function(key)
    {
      var ns = DnaGifts.test;
      return ns.translations[ns.language][key];
    },
    is_paused: false,
    is_stopped: false,
    currQuestion: undefined,
    passPretestQuestion: false,
    nextPretest: 1,
    timeForPretestQuestion: function()
    {
    	var ns = DnaGifts.test;
    	if (ns.passPretestQuestion) {
        	ns.passPretestQuestion = false;
        	return false;
        }
    	
    	if (hasPretestInfo == 0 && ns.currQuestion && ns.currQuestion > 0) {
        	if (ns.currQuestion % 10 == 0) {
        		ns.passPretestQuestion = true;  		
        		return true;
        	}
        }
        return false;
    },
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
        jQuery("#backButton").hide();
        jQuery("#dnaProgress").show();
        if(parseInt(surveyconfig.show_progressbar)) {
            jQuery("#dnaProgressBar").show();
        }
        jQuery("#dnaCountdown").hide();
        jQuery("#dnaMessages").html('<em style="color: #ff8000">'+ns.translate('nextQuestionLoading')+'</em>').show();
             
        ns.clearPreviousQuestion();
        
        if(ns.timeForPretestQuestion()) {
        	ns.placeNextPretestQuestion();
        	return false;
        }
        
        ns.currQuestion = ns.fetchNextQuestion();
        
        if (!ns.currQuestion && ns.currQuestion !== 0) {
            ns.testComplete();
            return false;
        }
        
        // load the next question
        ns.placeNextQuestion();
        setTimeout(function() {
            ns.showNextQuestion();
            
            if(parseInt(surveyconfig.use_timing)) {
                // restart the countdown
                nsCD.startCountDown();
            }
            jQuery("#dnaPauseButton").show();
            jQuery(".dnaPauseDivider").show();
            jQuery("#dnaPassButton").show();
            jQuery("#dnaMessages").hide();
            if (parseInt(surveyconfig.use_timing)){
                jQuery("#dnaCountdown").show();
                jQuery("#pauseTestContainer").show();
            }
        }, 500);
        
        return true;
    },
    testComplete: function()
    {
        var ns = DnaGifts.test;
        ns.updateProgress();
        if (parseInt(surveyconfig.use_timing))
            jQuery("#dnaCountdown").countdown("pause");
        ns.is_stopped = true;
        jQuery(".dnaAnswerButton, #dnaLoadingDiv").hide();
        jQuery("#dnaMessages").html('<em style="color: #ff8000">'+ns.translate('completedTest')+'</em>').show();
        jQuery("#dnaQuestionText").html(ns.translate("thankYou"));
        jQuery("#dnaQuestionText").show();
        jQuery("#dnaCountdown").hide();
        jQuery("#dnaMessages").show();
        jQuery("#dnaProgressBar").fadeOut(1500);
        
        // kick off some ajax to increment the Completed-counter for this test
        var url=juri+'/index.php?option=com_dnagifts&format=json&task=test.logTestComplete';
        jQuery.ajax({
            type: "POST",
            url: url,
            data: {
                test_id: surveyconfig.id
            },
            success: function(json) {
                jQuery("#notificationtab").html(json.message);
                jQuery("#notificationtab").show();
                setInterval(function(){window.location = reporting_url+surveyconfig.id}, 5000);
            }
        });
    },
    executePause: function()
    {
        var ns = DnaGifts.test;
        ns.clearPreviousQuestion();
        jQuery("#dnaPauseButton").hide();
        jQuery(".dnaPauseDivider").hide();
        jQuery(".dnaPlayButton").show();
        jQuery("#dnaInteractions").hide();
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
        jQuery("#dnaInteractions").show();
        var url=juri+'/index.php?option=com_dnagifts&format=json&task=test.logUserTest';
        jQuery.ajax({
            type: "POST",
            url: url,
            data: {
                test_id: surveyconfig.id
            },
            success: function(json_data){
                user_test_id = json_data.user_test_id;
            }
        });
        return false;
    },
    clearPreviousQuestion: function()
    {
        var ns = DnaGifts.test;
        if (!Base.countdown.is_paused)
            jQuery("#dnaMessages").html('<em style="color: #ff8000">'+ns.translate('nextQuestionLoading')+'</em>').show();
        else
            jQuery("#dnaMessages").html('<em style="color: #ff8000">'+ns.translate('hitPlay')+'</em>').show();
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
        jQuery("#dnaButtonsBar").show();
    },
    fetchNextQuestion: function()
    {
        var ns = DnaGifts.test;
        var nsCD = Base.countdown;
        var nextquestion = undefined;
        ns.question_id = undefined;
        jQuery.each(surveydata, function(index, elem) {
            if (!elem.answer && elem.answer !== 0) {
                nextquestion = index;
                ns.question_id = elem.id;
                nsCD.duration = (parseInt(elem.duration)) ? parseInt(elem.duration) : parseInt(surveyconfig.default_duration);
                return false;
            }
            return true;
        });
        return nextquestion;
    },
    placeNextPretestQuestion: function()
    {
      var ns = DnaGifts.test;
  		var url=juri+'/index.php?option=com_dnagifts&format=json&task=dnagifts.getQ'+ns.nextPretest;
      jQuery.ajax({
        type: "POST",
        url: url,
  			success: function(json) {
  				if (json.success) {
  					jQuery("#dnaQuestionText").html(json.questionText);
            jQuery("#dnaButtonsBar table:first").hide();
            jQuery(json.buttons).appendTo("#dnaButtonsBar");
          	jQuery("#dnaLoadingDiv").hide();
            jQuery("#dnaQuestionText").show();
            jQuery("#dnaMessages").hide();
  				}
  			}
      });
    },
    placeNextQuestion: function()
    {
        // this function updates the UI and adds the new question to the screen
        jQuery("#dnaQuestionText").html(surveydata[this.currQuestion].question);
        this.updateProgress();
    },
    updateProgress: function()
    {
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
        jQuery('#dnaCountdown').countdown('pause').hide();
        
        // this function will save the answer to the JS object
        var answer = jQuery(this).metadata().answer;
        surveydata[ns.currQuestion].answer = answer;
        
        // now we send it to the database too.
        var url=juri+'/index.php?option=com_dnagifts&format=json&task=test.saveAnswer';
        jQuery.ajax({
            type: "POST",
            url: url,
            data: {
                user_test_id: user_test_id,
                question_id: ns.question_id,
                score: answer
            }
        });
        
        // ... and attempt to load the next question
        ns.is_stopped = false;
        jQuery('#dnaCountdown').countdown('resume').show();
        jQuery(".dnaPauseDivider").hide();
        jQuery("#dnaPauseButton").hide();
        jQuery("#dnaPassButton").hide();
        ns.nextQuestion();
        return false;
    },
    savePretestQuestion: function()
    {
      var ns = DnaGifts.test;
      
      // this function will save the answer to the JS object
      var answr = jQuery(this).metadata().answer;
      
      // now we send it to the database too.
      var url=juri+'/index.php?option=com_dnagifts&format=json&task=dnagifts.saveQ'+ns.nextPretest;
      ns.nextPretest++;
      jQuery.ajax({
            type: "POST",
            url: url,
            data: {answer: answr}
        });
      
      // ... and attempt to load the next question
      jQuery("#pretestquestiontable").remove();
      jQuery("#dnaButtonsBar table:first").show();
      ns.nextQuestion();
      return false;
    },
    countQuestions: function()
    {
        var counts = {total: 0, done: 0, togo: 0};
        jQuery.each(surveydata, function(index) {
            counts.total++
            if (surveydata[index].answer || surveydata[index].answer === 0)
                counts.done++;
        });
        counts.togo = counts.total - counts.done;
        counts.progress = Math.round(counts.done / counts.total * 100);
        return counts;
    },
    
    autoPassQuestion: function()
    {
        var ns = DnaGifts.test;
        jQuery(".dnaPauseDivider").hide();
        jQuery("#dnaPauseButton").hide();
        jQuery("#dnaPassButton").hide();
        ns.requeueQuestion();
        ns.nextQuestion();
    },
    
    requeueQuestion: function()
    {
        surveydata.push(surveydata.splice(DnaGifts.test.currQuestion,1)[0]);
    },
    
    pauseTest: function()
    {
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
        if(parseInt(surveyconfig.use_timing)) {
            nsCD.createCountDown(7, this.autoPassQuestion);
        }
        
        /*
		// autocomplete setups
		if (autoSuggestData) {
			jQuery( "#jform_church_name" ).autocomplete({ source: autoSuggestData.churchList });
			jQuery( "#jform_pastor_reverend" ).autocomplete({ source: autoSuggestData.pastorList });
			jQuery( "#jform_your_city" ).autocomplete({ source: autoSuggestData.cityList });
	  	}
	  	*/
    }
});

root.myNamespace.create('DnaGifts.pretestQuestions', {
  question1: {},
  question2: {},
  question3: {},
  question4: {},
  question5: {},
  question6: {},
  question7: {},
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
    jQuery(".playbutton, .pausebutton").bind("click", ns.executePlay);
    jQuery("#dnaPassButton").bind("click", ns.autoPassQuestion);
    jQuery(".btnAnswer").bind("click", ns.saveAnswer);
    jQuery("#progressbar").progressbar({ value: 0 });
    jQuery(document).on("click", ".pretestbutton", ns.savePretestQuestion);
});
