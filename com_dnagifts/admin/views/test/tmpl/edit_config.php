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
		<ul>
     <li>Use question timing?</li>
     <li>Show test progress bar?</li>
     <li>Default show duration for questions?</li>
		 <li>Estimated total test duration?</li>
    </ul>
	<?php endif; ?>
</fieldset>