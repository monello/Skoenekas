root.myNamespace.create('DnaGifts.test', {
    question_id: -1,
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
	/* 
	 * This function is run from the play or pause button
	 * it does exactly the same thing for both buttons
	 */
	executePlay: function()
    {
        var ns = DnaGifts.test;
		ns.test_id = jQuery(this).metadata().test_id;
        jQuery("#dnaPauseDiv").hide();
		jQuery("#startmessage").hide();
		jQuery("#dnaLoadingDiv").show();
		
		ns.saveAndFetch();
		
        return false;
    },
	/* 
	 * This function is called every time a new question must be loaded
	 * It fires an asynchronous call to the server.
	 * The server will check if this is:
	 *	1. a brand new test the user is starting
	 *	2. continuing with a test
	 * In short, if answer is sent is it saves it, and if there is a next question it returns it
	 * The server side code will take care of creating a test record on starting a new test and
	 * 	finalizing a test on the last question.
	 */
	saveAndFetch: function(answer_score)
	{
		var ns = DnaGifts.test;
		ns.clearPreviousQuestion();
		var url=juri+'/index.php?option=com_dnagifts&format=json&task=test.saveAndFetch';
		jQuery.ajax({
			type: "POST",
			url: url,
			data: {
				test_id: ns.test_id,
				question_id: ns.question_id > 0 ? ns.question_id : undefined,
				answer_score: (answer_score || answer_score === 0) ? answer_score : undefined
			},
			success: function(json) {
				if (!json.success) {
					jQuery("#dnaTestSpace").hide();
					alert(json.message);
					location.reload();
					return false;
				}
			
				if (json.nextQuestion) {
					ns.renderQuestion(json);
				} else {
					ns.renderReport();
				}
			},
			error: function(err) {
				alert("An Error occurred.\nStatus Text: "+err.statusText+"\nStatus: "+err.status+"\nReady State: "+err.readyState);
			}
		});
		return false;
	},
	clearPreviousQuestion: function()
    {
        var ns = DnaGifts.test;
		
		// update stuff
        jQuery("#dnaMessages").html('<em style="color: #ff8000">'+ns.translate('nextQuestionLoading')+'</em>').show();
        Base.countdown.running = false;
		
		// hide stuff
		jQuery("#dnaCountdown").hide();
		jQuery("#dnaQuestionText").hide();
        jQuery(".dnaAnswerButton").hide();
		jQuery("#dnaInteractions").hide();
        
		// show stuff
        jQuery("#dnaLoadingDiv").show();
    },
	renderQuestion: function(json)
    {
		var ns = DnaGifts.test;
		var nsCD = Base.countdown;
		
		// update stuff
		ns.question_id = json.question_id;
		jQuery("#dnaQuestionText").html(json.question_text);
		ns.updateProgress(json);
		nsCD.running = true;
		
        // hide stuff
		jQuery("#pretestquestiondiv").remove();
		jQuery("#backButton").hide();
		jQuery("#dnaMessages").hide();
        jQuery("#dnaLoadingDiv").hide();
		
		// show stuff
        jQuery("#dnaQuestionText").show();
        jQuery(".dnaAnswerButton").show();
        jQuery("#dnaButtonsBar, #dnaButtonsBar table:first").show();
		jQuery("#dnaInteractions").show();
		jQuery("#dnaProgress").show();
		
		if(parseInt(surveyconfig.show_progressbar))
            jQuery("#dnaProgressBar").show();
			
		if (parseInt(surveyconfig.use_timing)){
			jQuery("#dnaCountdown").show();
			nsCD.startCountDown(json.show_duration);
        }
    },
	updateProgress: function(json)
    {
        var ns = DnaGifts.test;
		var ssdone = json.done != 1 ? ns.translate('questions') : ns.translate('question');
        var sstogo = json.togo != 1 ? ns.translate('questions') : ns.translate('question');
		
        jQuery("#progressbar").progressbar("value", json.progress);
        jQuery("#progresspercent").text(ns.translate("thetestis")+" "+json.progress+"% "+ns.translate('complete'));
        jQuery("#dnaProgress").html(
            json.done + " " + ssdone + " " + ns.translate('completed')+" | " +
            json.togo + " " + sstogo + " " + ns.translate('togo'));
    },
	renderReport: function() {
		var ns = DnaGifts.test;
        if (parseInt(surveyconfig.use_timing))
            jQuery("#dnaCountdown").countdown("pause");
        //ns.is_stopped = true;
        jQuery(".dnaAnswerButton, #dnaLoadingDiv").hide();
        jQuery("#dnaMessages").html('<em style="color: #ff8000">'+ns.translate('completedTest')+'</em>').show();
        jQuery("#dnaQuestionText").html(ns.translate("thankYou"));
        jQuery("#dnaQuestionText").show();
        jQuery("#dnaCountdown").hide();
        jQuery("#dnaMessages").show();
		jQuery("#dnaInteractions").hide();
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
                setTimeout(function(){window.location = reporting_url+surveyconfig.id}, 5000);
            }
        });
	},
	passQuestion: function()
    {
        var ns = DnaGifts.test;
		jQuery("#dnaInteractions").hide();
		ns.saveAndFetch();
    },
    saveAnswer: function()
	{
		var ns = DnaGifts.test;
		var answer_score = jQuery(this).metadata().answer;
		ns.clearPreviousQuestion();
		ns.saveAndFetch(answer_score);
		return false;
	},
	pauseTest: function()
	{
		// pause the countdown
		Base.countdown.is_paused = true;
		
		// hide the  top bar (this includes the countdown, interactions, and progress sections)
		jQuery("#dnaTopBar").hide();
		
		// hide the progress & button bars
		jQuery("#dnaProgressBar").hide();
		jQuery("#dnaButtonsBar").hide();
		
		// update the question text
		jQuery("#dnaQuestionText").html("This test is now pausing...");
		
		// reload the page
		location.reload();
	},
    //------------------------------------------------------------------------
    onload_functions: function(ns)
    {
		var nsCD = Base.countdown;
		jQuery(".playbutton, .pausebutton").bind("click", ns.executePlay);
		jQuery("#dnaPassButton").bind("click", ns.passQuestion);
		jQuery(".btnAnswer").bind("click", ns.saveAnswer);
		jQuery("#dnaPauseButton").bind("click", ns.pauseTest);
		jQuery("#progressbar").progressbar({ value: 0 });
		if(parseInt(surveyconfig.use_timing)) {
			nsCD.createCountDown(surveyconfig.default_duration, this.passQuestion);
        }
		jQuery("html, body").animate({ scrollTop: jQuery('#dnaTestSpace').offset().top }, 1000);
    }
});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
	var ns = DnaGifts.test;
    jQuery.metadata.setType('attr','data');
	ns.language = jQuery("#dnaTestSpace").metadata().userlanguage;
    ns.onload_functions(ns);
});
