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
    currQuestion: 0,
    nextQuestion: function()
    {
        var ns = DnaGifts.test;
        var nsCD = Base.countdown;
        var nsP = DnaGifts.pretest;
        
        jQuery(".tip-wrap").hide();
        
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
        ns.fetchNextQuestion();
		
        if(nsP.timeForPretestQuestion()) {
          nsP.placeNextPretestQuestion();
        	return false;
        }
        
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
			jQuery("#dnaMessages").hide();
			jQuery("#dnaPauseButton").show();
            jQuery(".dnaPauseDivider").show();
            jQuery("#dnaPassButton").show();
            if (parseInt(surveyconfig.use_timing)){
				jQuery("#dnaCountdown").show();
                jQuery("#pauseTestContainer").show();
            }
        }, 300);
        
        return true;
    },
    testComplete: function()
    {
        var ns = DnaGifts.test;
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
                setTimeout(function(){window.location = reporting_url+surveyconfig.id}, 5000);
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
        ns.updateProgress();
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
				if (json_data.success) {
					user_test_id = json_data.user_test_id;
				} else {
					jQuery("#dnaTestSpace").hide();
					alert(json_data.message);
					window.location = juri+'/index.php?option=com_dnagifts&view=dnagifts';
				}
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
        jQuery("#pretestquestiondiv").remove();
        jQuery("#dnaLoadingDiv").hide();
        jQuery("#dnaQuestionText").show();
        jQuery(".dnaAnswerButton").show();
        jQuery("#dnaButtonsBar, #dnaButtonsBar table:first").show();
    },
	fetchNextQuestion: function()
    {
        var ns = DnaGifts.test;
        var nsCD = Base.countdown;
        ns.question_id = undefined;
        jQuery.each(surveydata, function(index, elem) {
            if (!elem.answer && elem.answer !== 0) {
                ns.currQuestion = index;
                ns.question_id = elem.id;
                nsCD.duration = (parseInt(elem.duration)) ? parseInt(elem.duration) : parseInt(surveyconfig.default_duration);
                return false;
            }
            return true;
        });
        return true;
    },
    placeNextQuestion: function()
    {
        // this function updates the UI and adds the new question to the screen
        jQuery("#dnaQuestionText").html(surveydata[this.currQuestion].question);
    },
    updateProgress: function()
    {
        var ns = DnaGifts.test;
        var counts = this.countQuestions();
        var ssdone = counts.done != 1 ? ns.translate('questions') : ns.translate('question');
		if (!counts.togo)
			ns.currQuestion = undefined;
		else
			ns.currQuestion = counts.done;
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
        var counts = ns.countQuestions();
        ns.clearPreviousQuestion();
        jQuery(".dnaPauseDivider").hide();
        jQuery("#dnaPauseButton").hide();
        jQuery("#dnaPassButton").hide();
        
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
				score: answer,
				prev_question_id: ns.prev_question_id,
				prev_score: ns.prev_score,
				done: counts.done
			},
			success: function(json_data) {
				if (!json_data.success) {
					jQuery("#dnaTestSpace").hide();
					alert(json_data.message);
					location.reload();
				}
			}
		});
		
        ns.updateProgress();
		ns.updatePrevResults(ns.question_id,answer);
        
        // ... and attempt to load the next question
		setTimeout(function() {
			ns.is_stopped = false;
			jQuery('#dnaCountdown').countdown('resume').show();
			ns.nextQuestion();
		}, 1500);
        return false;
    },
	updatePrevResults: function (qid,answer)
	{
		var ns = DnaGifts.test;
		ns.prev_question_id = qid;
		ns.prev_score = answer;
	},
    countQuestions: function()
    {
        var counts = {total: 0, done: 0, togo: 0};
        jQuery.each(surveydata, function(index, elem) {
            counts.total++
            if (elem.answer || elem.answer === 0)
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
			nsCD.createCountDown(surveyconfig.default_duration, this.autoPassQuestion);
        }
		jQuery("html, body").animate({ scrollTop: jQuery('#dnaTestSpace').offset().top }, 1000);
    }
});

root.myNamespace.create('DnaGifts.pretest', {
    positions_log: [],
    flight_checks_done: false,
    intro_questions: {
      1: {required: true, complete: false, has_children: false},
      2: {required: true, complete: false, has_children: true, children: [3,4]},
      3: {required: false, complete: false, has_children: false},
      4: {required: false, complete: false, has_children: false},
      5: {required: true, complete: false, has_children: false},
      6: {required: true, complete: false, has_children: false},
      7: {required: true, complete: false, has_children: false}
    },
    passPretestQuestion: false,
    doPreFlightChecks: function()
    {
      var nsP = DnaGifts.pretest;
      if (nsP.flight_checks_done)
        return true;
        
      var url=juri+'/index.php?option=com_dnagifts&format=json&task=dnagifts.checks';
      jQuery.ajax({
        type: "POST",
        url: url,
        async: false,
  			success: function(json) {
  				if (json.success) {
            nsP.flight_checks_done = true;
            if (!json.data)
              return true;
            
            jQuery.each(json.data, function(idx, qinfo) {
              if (typeof qinfo == "number")  {
                nsP.setComplete(qinfo, true);
              } else {
                nsP.setComplete(qinfo[0], true);
                nsP.makeChildrenRequired(qinfo[0], qinfo[1]);
              }
            });
            return true;
  				}
  			}
      });
      return true;
    },
    timeForPretestQuestion: function()
    {
      var ns = DnaGifts.test;
    	var nsP = DnaGifts.pretest;
      
      if (!nsP.countRemaining() || jQuery.inArray(ns.currQuestion, nsP.positions_log) > -1 )
        return false;
      
      nsP.doPreFlightChecks();
      
    	if (nsP.passPretestQuestion) {
        nsP.passPretestQuestion = false;
        return false;
      }
    	
      if (hasPretestInfo == 0 && ns.currQuestion && ns.currQuestion > 0) {
        if (ns.currQuestion % 7 == 0) {
          nsP.passPretestQuestion = true;
          nsP.positions_log.push(ns.currQuestion);
          return true;
        }
      }
      return false;
    },
    placeNextPretestQuestion: function()
    {
      var nsP = DnaGifts.pretest;
      Base.countdown.is_paused = true;
      Base.countdown.show_pausecount = false;
      Base.countdown.is_running = false;
      jQuery("#dnaMessages").hide();
      DnaGifts.test.is_stopped = true;
      
      var nextPretest = nsP.getNextIntroQuestion();
      if (!nextPretest) 
        return false;
      
      // make sure any previous preset fields are deleted
      jQuery("#pretestquestiondiv").remove();
      
      var nsP = DnaGifts.pretest;
  		var url=juri+'/index.php?option=com_dnagifts&format=json&task=dnagifts.getQ'+nextPretest;
      jQuery.ajax({
        type: "POST",
        url: url,
  			success: function(json) {
  				if (json.success) {
  					jQuery("#dnaQuestionText").html(json.label + '<br/>' + json.questionText);
					jQuery("#dnaButtonsBar table:first").hide();
					jQuery(json.buttons).appendTo("#dnaButtonsBar");
					jQuery("#dnaLoadingDiv").hide();
					jQuery("#dnaQuestionText").show();
					jQuery("#dnaButtonsBar").show();
					jQuery("#dnaMessages").hide();
					nsP.attachAutoSuggest();
					nsP.attachCopyAnswer();
  				}
  			}
      });
    },
    copyTextAnswer: function()
    {
      jQuery(".pretestbutton").metadata().answer = jQuery("#textfield").val();
    },
    copySelectedOption: function()
    {
      jQuery(".pretestbutton").metadata().answer = jQuery("select#textfield").val();
    },
    attachCopyAnswer: function()
    {
      var textfield = jQuery("#textfield");
      if (!textfield)
        return true;
        
      var nsP = DnaGifts.pretest;
      switch (jQuery(textfield).attr("name")) 
        {
          case "church_name":
          case "pastor_reverend":
          case "your_city":
            jQuery("#textfield").bind("blur", nsP.copyTextAnswer);
            break;
          case "your_country":
            jQuery("#textfield").bind("change", DnaGifts.pretest.copySelectedOption);
            break;
          default:
            return true;
        }
    },
    attachAutoSuggest: function() 
    {
      jQuery( 'input[name="church_name"]' ).autocomplete({ source: autoSuggestData.churchList });
      jQuery( 'input[name="pastor_reverend"]' ).autocomplete({ source: autoSuggestData.pastorList });
      jQuery( 'input[name="your_city"]' ).autocomplete({ source: autoSuggestData.cityList });
    },
    savePretestQuestion: function()
    {
      var ns = DnaGifts.test;
      var nsP = DnaGifts.pretest;
      
      // this function will save the answer to the JS object
      var answr = jQuery(this).metadata().answer;
	  if ((!answr && answr != 0) || answr < 0) {
		alert("Please provide an answer to this question");
		return false;
	  }
      var fld = jQuery(this).metadata().field;
      
      // now we send it to the database too.
      var currPretest = nsP.getNextIntroQuestion();
      if (!currPretest) 
        return false;
      
      nsP.setComplete(currPretest, true);
      nsP.makeChildrenRequired(currPretest, answr);
      
      var url=juri+'/index.php?option=com_dnagifts&format=json&task=dnagifts.saveAnswer';
      jQuery.ajax({
        type: "POST",
        url: url,
        data: {answer: answr, field: fld},
        async: false
      });
      
      // ... and attempt to load the next question
      jQuery("#pretestquestiondiv").remove();
      jQuery("#dnaButtonsBar table:first").show();
      
      jQuery("#dnaMessages").show();
      Base.countdown.is_paused = false;
      Base.countdown.show_pausecount = true;
      Base.countdown.is_running = true;
      DnaGifts.test.is_stopped = false;
      
      ns.nextQuestion();
      return false;
    },
    countRequired: function() 
    {
    	var nsP = DnaGifts.pretest;
      var howmany = 0;
      jQuery.each(nsP.intro_questions, function(qNum, attribs) {
        if (attribs.required)
          howmany++;
      });
      return howmany;
    },
    setRequired: function(qNum, status) 
    {
      var nsP = DnaGifts.pretest;
      nsP.intro_questions[qNum].required = status;
    },
    setComplete: function(qNum, status) 
    {
      var nsP = DnaGifts.pretest;
      nsP.intro_questions[qNum].complete = status;
    },
    countRemaining : function() 
    {
      var nsP = DnaGifts.pretest;
      var howmany = 0;
      jQuery.each(nsP.intro_questions, function(qNum, attribs) {
        if (attribs.required && !attribs.complete)
          howmany++;
      });
      return howmany;
    },
    getNextIntroQuestion: function() 
    {
      var nsP = DnaGifts.pretest;
      for (var qNum = 1; qNum <= 7; qNum++) {
        var question = nsP.intro_questions[qNum];
        if (question.required && !question.complete)
          return qNum;
      }
      return false;
    },
    makeChildrenRequired: function(qNum, answer) 
    {
      if (!answer)
        return false;
        
      var nsP = DnaGifts.pretest;
      if (!nsP.intro_questions[qNum].has_children)
        return false;
      
      jQuery.each(nsP.intro_questions[qNum].children, function(idx, question_number){
        nsP.setRequired(question_number, true);
      });
    }
    
});



/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
	var ns = DnaGifts.test;
    var nsP = DnaGifts.pretest;
    jQuery.metadata.setType('attr','data');
    ns.language = jQuery("#dnaTestSpace").metadata().userlanguage;
    ns.onload_functions();
	jQuery("#dnaPauseButton").bind("click", ns.pauseTest);
    jQuery(".playbutton, .pausebutton").bind("click", ns.executePlay);
    jQuery("#dnaPassButton").bind("click", ns.autoPassQuestion);
    jQuery(".btnAnswer").bind("click", ns.saveAnswer);
    jQuery("#progressbar").progressbar({ value: 0 });
    jQuery(document).on("click", ".pretestbutton", nsP.savePretestQuestion);
});
