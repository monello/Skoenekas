<?php
// No direct access.
defined('_JEXEC') or die;
//require_once JPATH_COMPONENT.'/helpers/dnagifts.php';
echo JHtml::_('sliders.panel', JText::_('COM_DNAGIFTS_TEST_QUESTIONS_HEADER'), 'publishing-details');
$record_id = ($this->item->id) ? $this->item->id : -1;
?>
<fieldset class="panelform">
  <div id="select_questions">
  
  <!-- Edit questions modal -->
	<div id="edit-test-question" title="Update Question Details">
		<table width="100%">
			<tr>
				<td>Language:</td>
				<td>
					<select title="<?php echo JText::_('COM_DNAGIFTS_TEST_FIELD_LANGUAGE_LABEL');?>" id="qlanguage-edit" name="qlanguage-edit" class="inputbox">
						<option value="">- Select Language -</option>
						<?php echo JHtml::_('select.options', DnaGiftsHelper::getLanguageOptions(), 'value', 'text');?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Question:</td>
				<td>
					<select title="<?php echo JText::_('COM_DNAGIFTS_TEST_QUESTION_SELECT');?>" id="question_id-edit" name="question_id-edit" class="inputbox" disabled="true">
						<option value="">- Select Question -</option>
					</select>
				</td>
			</tr>
      <tr>
				<td>Show Duration:</td>
				<td>
					<input type="text" title="<?php echo JText::_('COM_DNAGIFTS_TEST_DURATION_DESC');?>" id="show_duration-edit" name="show_duration-edit" class="inputbox">
				</td>
			</tr>
		</table>
	</div>
  
  <?php if ($this->item->id == 0): ?>
		<div id="system-message-container">
			<dl id="system-message">
				<dt class="notice">Notice</dt>
				<dd class="notice message">
					<ul>
						<li><?php echo JText::_('COM_DNAGIFTS_TEST_NOTICE_SAVE_QUESTIONS'); ?></li>
					</ul>
				</dd>
			</dl>
		</div>
	<?php else: ?>
			<ul class="sortable">
				<?php foreach(DnaGiftsHelper::getCurrentQuestions($record_id) as $i => $question): ?>
					<?php $colorpatch = "<div class=\"hasTip\" title=\"Gifting::This question is linked to ".$question->gift_name."\"style=\"display:inline; margin-right:5px; color:black; background-color: ".$question->color_hex."\">&nbsp;".$question->gift_code."&nbsp;</div>"; ?>
					<li id="test-question-<?php echo $question->id; ?>"
							data="{link_id: '<?php echo $question->id; ?>', test_id: '<?php echo $record_id; ?>', question_id:'<?php echo $question->value; ?>', language: '<?php echo $question->language; ?>', show_duration: <?php echo $question->show_duration; ?>}"
							class="ui-state-default">
						<div class="questionDetailsContainer">
							<a class="ui-icon ui-icon-arrowthick-2-n-s hasTip" title="Drag and Drop::Click and drag Question to new position" href="#" style="float:left">Drag Question</a>
							<div class="testQuestionText"><?php echo $colorpatch; ?><?php echo $question->question_code; ?>: <?php echo DnaGiftsHelper::addEllipsis($question->text, 30); ?></div>
							<div class="testQuestionLanguage">(<?php echo $question->language; ?>)</div>
              <div class="testShowDuration"> (<?php echo $question->show_duration; ?> sec)</div>
						</div>
						<div class="actionQuestionsContainer">
							<a class="ui-icon ui-icon-arrowthickstop-1-s actionBtn toBottomBtn hasTip"
									title="Quick Move::Question to bottom of list" href="#" style="float:right">To Bottom</a>
							<a class="ui-icon ui-icon-arrowthick-1-s actionBtn downOneBtn hasTip"
									title="Quick Move::Question down one position" href="#" style="float:right">Down One</a>
							<a class="ui-icon ui-icon-arrowthick-1-n actionBtn upOneBtn hasTip"
									title="Quick Move::Question up one position" href="#" style="float:right">Up One</a>
							<a class="ui-icon ui-icon-arrowthickstop-1-n actionBtn toTopBtn hasTip"
									title="Quick Move::Question to top of list" href="#" style="float:right">To Top</a>
							<strong class="actionButtonSpacer">&nbsp;</strong>
							<a class="ui-icon ui-icon-close actionBtn goDeleteBtn hasTip"
									title="Action::Click to Delete question" href="#" style="float:right">Delete</a>
							<a class="ui-icon ui-icon-pencil actionBtn goEditBtn hasTip"
									title="Action::Click to Edit question" href="#" style="float:right">Edit</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
	<?php endif; ?>
  </div>
  
  <?php if ($this->item->id > 0): ?>
	<div id="add_question">
		<select title="<?php echo JText::_('COM_DNAGIFTS_TEST_FIELD_LANGUAGE_LABEL');?>" id="qlanguage" name="qlanguage" class="inputbox">
			<option value="">- Select Language -</option>
			<?php echo JHtml::_('select.options', DnaGiftsHelper::getLanguageOptions(), 'value', 'text');?>
		</select>
		
		<select title="<?php echo JText::_('COM_DNAGIFTS_TEST_QUESTION_SELECT');?>" id="question_id" name="question_id" class="inputbox" disabled="true">
			<option value="">- Select Question -</option>
		</select>
		
    <input title="<?php echo JText::_('COM_DNAGIFTS_TEST_SHOW_DURATION');?>" id="show_duration" name="show_duration" class="inputbox" disabled="true" />
    
		<input type="button" id="saveNewQuestion" data="{test_id: '<?php echo $record_id; ?>'}" value="<?php echo JText::_('COM_DNAGIFTS_SAVEBUTTON_TEXT');?>"/>
	</div>
	<?php endif; ?>
</fieldset>