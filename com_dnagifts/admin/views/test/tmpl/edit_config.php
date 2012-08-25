<?php
// No direct access.
defined('_JEXEC') or die;
echo JHtml::_('sliders.panel', JText::_('COM_DNAGIFTS_TEST_CONFIG_HEADER'), 'publishing-details');
?>
<fieldset class="panelform">
  <?php if ($this->item->id == 0): ?>
		<div id="system-message-container">
			<dl id="system-message">
				<dt class="notice">Notice</dt>
				<dd class="notice message">
					<ul>
						<li><?php echo JText::_('COM_DNAGIFTS_TEST_NOTICE_SAVE_CONFIG'); ?></li>
					</ul>
				</dd>
			</dl>
		</div>
	<?php else: ?>
		<table width="450px" id="tdTestConfig" data="{test_id: <?php echo $this->item->id; ?>}">
			<tbody>
				<tr id="trUseTiming">
					<td>Use question timing?</td>
					<td width="120px">
						<?php if ($this->item->use_timing == 1): ?>
						<input type="radio" name="user_timing" id="use_timing_yes" value="1" checked="checked"/><label for="use_timing_yes">Yes</label>
						<input type="radio" name="user_timing" id="use_timing_no" value="0"/><label for="use_timing_no">No</label>
						<?php else: ?>
						<input type="radio" name="user_timing" id="use_timing_yes" value="1"/><label for="use_timing_yes">Yes</label>
						<input type="radio" name="user_timing" id="use_timing_no" value="0" checked="checked"/><label for="use_timing_no">No</label>
						<?php endif; ?>
					</td>
					<td width="40px">
						<a href="#" class="ajaxSaveBtn" name="svUseTiming" id="svUseTiming">save</a>
						<img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/spinner16x16.gif" id="spUseTiming" height="16px" width="16px" style="display: none"/>
					</td>
				</tr>
				<tr id="trDefaultDuration" >
					<td>Default duration to show each question?</td>
					<td><input type="text" name="default_duration" id="default_duration" value="<?php echo $this->item->default_duration; ?>" size="10" maxlength="5"/> seconds</td>
					<td>
						<a href="#" class="ajaxSaveBtn" name="svDefaultDuration" id="svDefaultDuration">save</a>
						<img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/spinner16x16.gif" id="spDefaultDuration" height="16px" width="16px" style="display: none"/>
					</td>
				</tr>
				<tr id="trTestDuration">
					<td>What is the estimated total test duration?</td>
					<td><input type="text" name="test_duration" id="test_duration" value="<?php echo $this->item->test_duration; ?>" size="10" maxlength="5"/> minutes</td>
					<td>
						<a href="#" class="ajaxSaveBtn" name="svTestDuration" id="svTestDuration">save</a>
						<img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/spinner16x16.gif" id="spTestDuration" height="16px" width="16px" style="display: none"/>
					</td>
				</tr>
				<tr id="trShowProgressbar">
					<td>Show test progress bar?</td>
					<td>
						<?php if ($this->item->show_progressbar == 1): ?>
						<input type="radio" name="show_progressbar" id="show_progressbar_yes" value="1" checked="checked"/><label for="show_progressbar_yes">Yes</label>
						<input type="radio" name="show_progressbar" id="show_progressbar_no" value="0"/><label for="show_progressbar_no">No</label>
						<?php else: ?>
						<input type="radio" name="show_progressbar" id="show_progressbar_yes" value="1"/><label for="show_progressbar_yes">Yes</label>
						<input type="radio" name="show_progressbar" id="show_progressbar_no" value="0" checked="checked"/><label for="show_progressbar_no">No</label>
						<?php endif; ?>
					</td>
					<td>
						<a href="#" class="ajaxSaveBtn" name="svShowProgressbar" id="svShowProgressbar">save</a>
						<img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/spinner16x16.jpg" id="spShowProgressbar" height="16px" width="16px" style="display: none"/>
					</td>
				</tr>
			</tbody>	
		</table>
	<?php endif; ?>
</fieldset>
