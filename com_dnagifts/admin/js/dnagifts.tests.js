root.myNamespace.create('DnaGifts.Test', {
   updateButtons: function(isUpdate) {
      var help = Base.Helpers;
      var edit = (isUpdate) ? "-edit" : "";
      
      jQuery("#button_id"+edit).attr("disabled",true);
      
      var url='index.php?option=com_dnagifts&format=json&task=test.getButtonsByLanguage';
      var language = jQuery("#language"+edit).val();
      var test_id = help.getRecordID("test-form");
      
      if (!language) {
         return false;
      }
      
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            record_id: test_id,
            language: language,
            is_update: isUpdate,
            button_id: DnaGifts.Test.button_id
         },
         success: function(json_data) {
            help.deleteOptions("button_id"+edit);
            help.appendOption("button_id"+edit, '', "- Select Button -");
            if (json_data.results && json_data.results.buttons.length) {
               jQuery.each(json_data.results.buttons, function(idx, button) {
                  help.appendOption("button_id"+edit, button.value, button.text);
               });  
               jQuery("#button_id"+edit).attr("disabled",false);
               if (isUpdate) {
                  jQuery("#button_id"+edit+" option[value='"+DnaGifts.Test.button_id+"']").attr("selected", true);
               }
            }
         }
      });
   },
   // this function updates the questions dropdown list after selecting a language
   updateQuestions: function(isUpdate) {
      var help = Base.Helpers;
      var edit = (isUpdate) ? "-edit" : "";
      
      jQuery("#question_id"+edit).attr("disabled",true);
      jQuery("#show_duration"+edit).attr("disabled",true);
      jQuery("#show_duration"+edit).val();
      
      var url='index.php?option=com_dnagifts&format=json&task=test.getQuestionsByLanguage';
      var language = jQuery("#qlanguage"+edit).val();
      var test_id = help.getRecordID("test-form");
      
      if (!language) {
         return false;
      }
      
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            record_id: test_id,
            language: language,
            is_update: isUpdate,
            question_id: DnaGifts.Test.question_id
         },
         success: function(json_data) {
            help.deleteOptions("question_id"+edit);
            help.appendOption("question_id"+edit, '', "- Select Question -");
            if (json_data.results && json_data.results.questions.length) {
               jQuery.each(json_data.results.questions, function(idx, question) {
                  var text = (question.text.length > 30) ? question.text.substring(0,27)+"..." : question.text;
                  help.appendOption("question_id"+edit, question.value, question.code + ": "+text);
               });
               jQuery("#question_id"+edit).attr("disabled",false);
               jQuery("#show_duration"+edit).attr("disabled",false);
               if (isUpdate) {
                  jQuery("#question_id"+edit+" option[value='"+DnaGifts.Test.question_id+"']").attr("selected", true);
               }
            }
         }
      });
   },
   updateExistingButton: function() {
      var help = Base.Helpers;
      var button_id = jQuery("#button_id-edit").val();
      var language = jQuery("#language-edit").val();
      
      if (!jQuery("#language-edit").val()) {
         alert("Please select a Language");
         return false;
      }
      if (!button_id) {
         alert("Please select a Button");
         return false;
      }
      
      var url='index.php?option=com_dnagifts&format=json&task=test.updateTestButton';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            link_id: DnaGifts.Test.link_id,
            button_id: button_id
         },
         success: function(json_data) {
            if (json_data.success) {
               var test_id = jQuery("#test-button-"+DnaGifts.Test.link_id).metadata().test_id;
               jQuery("#test-button-"+DnaGifts.Test.link_id+" .testButtonText:first").html(json_data.text);
               jQuery("#test-button-"+DnaGifts.Test.link_id+" .testButtonLanguage:first").html("("+language+")");
               jQuery("#test-button-"+DnaGifts.Test.link_id).metadata().button_id = button_id;
               jQuery("#test-button-"+DnaGifts.Test.link_id).metadata().language = language;
               jQuery( "#edit-test-button" ).dialog( "close" );
            } else {
               alert("There was an error updating this button");
            }
            return false;
         }
      });
      return false;
      
   },
   updateExistingQuestion: function() {
      var help = Base.Helpers;
      var question_id = jQuery("#question_id-edit").val();
      var language = jQuery("#qlanguage-edit").val();
      var show_duration = parseInt(jQuery("#show_duration-edit").val()) ? parseInt(jQuery("#show_duration-edit").val()) : 0;
   
      if (!jQuery("#qlanguage-edit").val()) {
         alert("Please select a Language");
         return false;
      }
      if (!question_id) {
         alert("Please select a Question");
         return false;
      }
      
      var url='index.php?option=com_dnagifts&format=json&task=test.updateTestQuestion';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            link_id: DnaGifts.Test.link_id,
            question_id: question_id,
            show_duration: show_duration
         },
         success: function(json_data) {
            if (json_data.success) {
               var test_id = jQuery("#test-question-"+DnaGifts.Test.link_id).metadata().test_id;
               jQuery("#test-question-"+DnaGifts.Test.link_id+" .testQuestionText:first").html(json_data.text);
               jQuery("#test-question-"+DnaGifts.Test.link_id+" .testQuestionLanguage:first").html("("+language+")");
               jQuery("#test-question-"+DnaGifts.Test.link_id+" .testShowDuration:first").html("("+show_duration+" sec)");
               jQuery("#test-question-"+DnaGifts.Test.link_id).metadata().question_id = question_id;
               jQuery("#test-question-"+DnaGifts.Test.link_id).metadata().language = language;
               jQuery("#test-question-"+DnaGifts.Test.link_id).metadata().show_duration = show_duration;
               jQuery( "#edit-test-question" ).dialog( "close" );
            } else {
               alert("There was an error updating this question");
            }
            DnaGifts.Test.link_id = undefined;
            return false;
         }
      });
      return false;
      
   },
   saveNewButton: function() {
      var help = Base.Helpers;
      var test_id = jQuery(this).metadata().test_id;
      var button_id = jQuery("#button_id").val();
   
      if (!jQuery("#language").val()) {
         alert("Please select a Language");
         return false;
      }
      if (!button_id) {
         alert("Please select a Button");
         return false;
      }
      var url='index.php?option=com_dnagifts&format=json&task=test.saveNewTestButton';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            test_id: test_id,
            button_id: button_id
         },
         success: function(json_data) {
            if (json_data.success) {
               jQuery("div#select_buttons ul:first").append(json_data.html);
               help.deleteOptions("button_id");
               help.appendOption("button_id", '', "- Select Button -");
               jQuery("#button_id").attr("disabled", true);
               jQuery("#language option:first").attr("selected", true);
            } else {
               alert(json_data.error);
            }
            return false;
         }
      });
      return false;
   },
   saveNewQuestion: function() {
      var help = Base.Helpers;
      var test_id = jQuery(this).metadata().test_id;
      var question_id = jQuery("#question_id").val();
      var show_duration = parseInt(jQuery("#show_duration").val()) ? parseInt(jQuery("#show_duration").val()) : 0;
   
      if (!jQuery("#qlanguage").val()) {
         alert("Please select a Language");
         return false;
      }
      if (!question_id) {
         alert("Please select a Question");
         return false;
      }
      var url='index.php?option=com_dnagifts&format=json&task=test.saveNewTestQuestion';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            test_id: test_id,
            question_id: question_id,
            show_duration: show_duration
         },
         success: function(json_data) {
            if (json_data.success) {
               jQuery("div#select_questions ul:first").append(json_data.html);
               help.deleteOptions("question_id");
               help.appendOption("question_id", '', "- Select Question -");
               jQuery("#question_id").attr("disabled", true);
               jQuery("#show_duration").attr("disabled", true);
               jQuery("#qlanguage option:first").attr("selected", true);
               jQuery("#show_duration").val('');
            } else {
               alert(json_data.error);
            }
            return false;
         }
      });
      return false;
   },
   goEditButton: function() {
      var mdata = jQuery("#test-button-"+DnaGifts.Test.link_id).metadata();
      jQuery("#language-edit option[value='"+mdata.language+"']").attr("selected", true);
      jQuery("#language-edit option[value='"+mdata.language+"']").trigger("change");
   },
   goEditQuestion: function() {
      var mdata = jQuery("#test-question-"+DnaGifts.Test.link_id).metadata();
      jQuery("#qlanguage-edit option[value='"+mdata.language+"']").attr("selected", true);
      jQuery("#qlanguage-edit").trigger("change");
      jQuery("#show_duration-edit").val(mdata.show_duration);
   },
   goDeleteButton: function() {
      var goahead = confirm("Are you sure you want to delete this button?");
      if (!goahead) {
         return false;
      }
      var ns = DnaGifts.Test;
      var link_id = jQuery(this).parent().parent().metadata().link_id;
      
      jQuery(this).parent().parent().remove();
     
      var url='index.php?option=com_dnagifts&format=json&task=test.deleteTestButton';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {link_id: link_id},
         success: function(json_data) {
            if (json_data.success) {
               ns.updateButtonOrdering();
            } else {
               alert("There was an error deleting this button, please reload the page");
            }
            return false;
         }
      });
      return false;
   },
   goDeleteQuestion: function() {
      var goahead = confirm("Are you sure you want to delete this question?");
      if (!goahead) {
         return false;
      }
      var ns = DnaGifts.Test;
      var link_id = jQuery(this).parent().parent().metadata().link_id;
      
      jQuery(this).parent().parent().remove();
     
      var url='index.php?option=com_dnagifts&format=json&task=test.deleteTestQuestion';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {link_id: link_id},
         success: function(json_data) {
            if (json_data.success) {
               ns.updateQuestionOrdering();
            } else {
               alert("There was an error deleting this question, please reload the page");
            }
            return false;
         }
      });
      return false;
   },
   reorderButton: function(elem, moveType) {
      var ns = DnaGifts.Test;
      var this_li = jQuery(elem).parent().parent();
      
      if (moveType == "top" || moveType == "up") {
         // check if it is already at the top
         var first_li = jQuery("div#select_buttons ul li:first");
         if (jQuery(this_li).attr("id") == jQuery(first_li).attr("id")) {
            return false;
         }
         
         // move button
         if (moveType == "up") {
            jQuery(this_li).insertBefore(jQuery(this_li).prev());
         } else {
            jQuery(this_li).insertBefore(first_li);
         }
      } else if (moveType == "down" || moveType == "bottom") {
         // check if it is already at the bottom
         var last_li = jQuery("div#select_buttons ul li:last");
         if (jQuery(this_li).attr("id") == jQuery(last_li).attr("id")) {
            return false;
         }
         // move to the bottom
         if (moveType == "bottom") {
            jQuery(this_li).insertAfter(last_li);
         } else {
            jQuery(this_li).insertAfter(jQuery(this_li).next());
         }
      } else {
         return false;
      }
      
      // re-order buttons on db
      ns.updateButtonOrdering();
      jQuery(".actionBtn").trigger("mouseout");
      return false;
   },
   reorderQuestion: function(elem, moveType) {
      var ns = DnaGifts.Test;
      var this_li = jQuery(elem).parent().parent();
      
      if (moveType == "top" || moveType == "up") {
         // check if it is already at the top
         var first_li = jQuery("div#select_questions ul li:first");
         if (jQuery(this_li).attr("id") == jQuery(first_li).attr("id")) {
            return false;
         }
         
         // move question
         if (moveType == "up") {
            jQuery(this_li).insertBefore(jQuery(this_li).prev());
         } else {
            jQuery(this_li).insertBefore(first_li);
         }
      } else if (moveType == "down" || moveType == "bottom") {
         // check if it is already at the bottom
         var last_li = jQuery("div#select_questions ul li:last");
         if (jQuery(this_li).attr("id") == jQuery(last_li).attr("id")) {
            return false;
         }
         // move to the bottom
         if (moveType == "bottom") {
            jQuery(this_li).insertAfter(last_li);
         } else {
            jQuery(this_li).insertAfter(jQuery(this_li).next());
         }
      } else {
         return false;
      }
      
      // re-order questions on db
      ns.updateQuestionOrdering();
      jQuery(".actionBtn").trigger("mouseout");
      return false;
   },
   getButtonsOrder: function(){
      var list = [];
      jQuery.each(jQuery("#select_buttons li"), function(idx, li){
         list.push(jQuery(li).metadata().link_id);
      });
      return list;
   },
   updateButtonOrdering: function(){
      var ns = DnaGifts.Test;
      var list = ns.getButtonsOrder();
      var url='index.php?option=com_dnagifts&format=json&task=test.reorderTestButtons';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {buttons: list}
      });
   },
   getQuestionsOrder: function(){
      var list = [];
      jQuery.each(jQuery("#select_questions li"), function(idx, li){
         list.push(jQuery(li).metadata().link_id);
      });
      return list;
   },
   updateQuestionOrdering: function(){
      var ns = DnaGifts.Test;
      var list = ns.getQuestionsOrder();
      var url='index.php?option=com_dnagifts&format=json&task=test.reorderTestQuestions';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {questions: list}
      });
   },
   saveUseTiming: function() {
      var use_timing = jQuery("input[name='user_timing']:checked").val();
      var test_id = jQuery("#tdTestConfig").metadata().test_id;
      
      jQuery("#svUseTiming").hide();
      jQuery("#spUseTiming").show();
      
      var url='index.php?option=com_dnagifts&format=json&task=test.saveUseTiming';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            test_id: test_id,
            use_timing: use_timing
         },
         success : function(json_data) {
            if (!json_data.success) {
               alert(json_data.message);
            }
            jQuery("#spUseTiming").hide();
            jQuery("#svUseTiming").show();
         }
      });
   },
   saveDefaultDuration: function() {
      var default_duration = jQuery("#default_duration").val();
      var test_id = jQuery("#tdTestConfig").metadata().test_id;
      
      jQuery("#svDefaultDuration").hide();
      jQuery("#spDefaultDuration").show();
      
      var url='index.php?option=com_dnagifts&format=json&task=test.saveDefaultDuration';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            test_id: test_id,
            default_duration: default_duration
         },
         success : function(json_data) {
            if (!json_data.success) {
               alert(json_data.message);
            }
            jQuery("#spDefaultDuration").hide();
            jQuery("#svDefaultDuration").show();
         }
      });
   },
   saveTestDuration: function() {
      var test_duration = jQuery("#test_duration").val();
      var test_id = jQuery("#tdTestConfig").metadata().test_id;
      
      jQuery("#svTestDuration").hide();
      jQuery("#spTestDuration").show();
      
      var url='index.php?option=com_dnagifts&format=json&task=test.saveTestDuration';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            test_id: test_id,
            test_duration: test_duration
         },
         success : function(json_data) {
            if (!json_data.success) {
               alert(json_data.message);
            }
            jQuery("#spTestDuration").hide();
            jQuery("#svTestDuration").show();
         }
      });
   },
   saveShowProgressbar: function() {
      var show_progressbar = jQuery("input[name='show_progressbar']:checked").val();
      var test_id = jQuery("#tdTestConfig").metadata().test_id;
      
      jQuery("#svShowProgressbar").hide();
      jQuery("#spShowProgressbar").show();
      
      var url='index.php?option=com_dnagifts&format=json&task=test.saveShowProgressbar';
      jQuery.ajax({
         type: "POST",
         url: url,
         data: {
            test_id: test_id,
            show_progressbar: show_progressbar
         },
         success : function(json_data) {
            if (!json_data.success) {
               alert(json_data.message);
            }
            jQuery("#spShowProgressbar").hide();
            jQuery("#svShowProgressbar").show();
         }
      });
   }
});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
   var ns = DnaGifts.Test;
   jQuery.metadata.setType('attr','data');
   
   jQuery("#language").bind("change", function(){ns.updateButtons(false)} );
   jQuery("#language-edit").bind("change", function(){ns.updateButtons(true)} );
   jQuery("#qlanguage").bind("change", function(){ns.updateQuestions(false)} );
   jQuery("#qlanguage-edit").bind("change", function(){ns.updateQuestions(true)} );
   
   jQuery("#select_buttons .sortable").sortable({
      placeholder: "ui-state-highlight",
      stop: ns.updateButtonOrdering
   });
   jQuery("#select_questions .sortable").sortable({
      placeholder: "ui-state-highlight",
      stop: ns.updateQuestionOrdering
   });
		 jQuery(".sortable").disableSelection();
   
   jQuery(".actionBtn").live("mouseover", function(){ jQuery(this).addClass("ui-state-hover"); })
   jQuery(".actionBtn").live("mouseout", function(){ jQuery(this).removeClass("ui-state-hover"); })
   
   jQuery("#saveNewButton").bind("click", ns.saveNewButton);
   jQuery("#saveNewQuestion").bind("click", ns.saveNewQuestion);
   
   // activate the Test-Button actions
   jQuery('#select_buttons .toTopBtn').live( "click", function() {ns.reorderButton(this, "top")} );
   jQuery('#select_buttons .upOneBtn').live( "click", function() {ns.reorderButton(this, "up")} );
   jQuery('#select_buttons .downOneBtn').live( "click", function() {ns.reorderButton(this, "down")} );
   jQuery('#select_buttons .toBottomBtn').live( "click", function() {ns.reorderButton(this, "bottom")} );
   jQuery('#select_buttons .goDeleteBtn').live("click", ns.goDeleteButton);
   jQuery('#select_buttons .goEditBtn').live("click", function() {
      DnaGifts.Test.link_id = jQuery(this).parent().parent().metadata().link_id;
      DnaGifts.Test.button_id = jQuery(this).parent().parent().metadata().button_id;
      jQuery( "#edit-test-button" ).dialog( "open" );
    });
   
   jQuery('#select_questions .toTopBtn').live( "click", function() {ns.reorderQuestion(this, "top")} );
   jQuery('#select_questions .upOneBtn').live( "click", function() {ns.reorderQuestion(this, "up")} );
   jQuery('#select_questions .downOneBtn').live( "click", function() {ns.reorderQuestion(this, "down")} );
   jQuery('#select_questions .toBottomBtn').live( "click", function() {ns.reorderQuestion(this, "bottom")} );
   jQuery('#select_questions .goDeleteBtn').live("click", ns.goDeleteQuestion);
   jQuery('#select_questions .goEditBtn').live("click", function() {
      DnaGifts.Test.link_id = jQuery(this).parent().parent().metadata().link_id;
      DnaGifts.Test.question_id = jQuery(this).parent().parent().metadata().question_id;
      jQuery( "#edit-test-question" ).dialog( "open" );
    });
   
   // Activate the Modal Dialogue
   jQuery("#edit-test-button").dialog({
      autoOpen: false,
      modal: true,
      buttons: {
         "Save Changes": ns.updateExistingButton,
         Cancel: function() {
            jQuery( this ).dialog( "close" );
         }
      },
      open: ns.goEditButton,
      close: function(){DnaGifts.Test.link_id = DnaGifts.Test.button_id = undefined}
   });
   jQuery("#edit-test-question").dialog({
      autoOpen: false,
      modal: true,
      width: 400,
      buttons: {
         "Save Changes": ns.updateExistingQuestion,
         Cancel: function() {
            jQuery( this ).dialog( "close" );
         }
      },
      open: ns.goEditQuestion,
      close: function(){DnaGifts.Test.link_id = DnaGifts.Test.question_id = undefined}
   });
   
   jQuery("#svUseTiming").bind("click", ns.saveUseTiming);
   jQuery("#svDefaultDuration").bind("click", ns.saveDefaultDuration);
   jQuery("#svTestDuration").bind("click", ns.saveTestDuration);
   jQuery("#svShowProgressbar").bind("click", ns.saveShowProgressbar);
   
   jQuery("a.ajaxSaveBtn").button({
      icons: {
         primary: "ui-icon-disk"
      },
      text: false
   });
   
});