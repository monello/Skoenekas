<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item):
	$ordering	= ($this->listOrder == 'ordering');
	
	switch ($item->status) {
		case 1:
			$cssclass_icon = "goodicon";
			$cssclass_text = "goodstatus";
			$tooltip = "Status Good::This Test was completed 100% and the report was generated";
			break;
		case 2:
			$cssclass_icon = "incompleteicon";
			$cssclass_text = "incompletestatus";
			$tooltip = "Status Incomplete (>80%)::This test was started but only completed between 80% and 99% of the test";
			break;
		case 3:
			$cssclass_icon = "noreporticon";
			$cssclass_text = "noreportstatus";
			$tooltip = "Status No-Report::This Test was completed 100%, but the report was not generated. PLEASE INVESTIGATE";
			break;
		case 4:
			$cssclass_icon = "extraanswersicon";
			$cssclass_text = "extraanswersstatus";
			$tooltip = "Status Extra-Answers::This Test has more answers than questions. PLEASE INVESTIGATE";
			break;
		case 5:
			$cssclass_icon = "incompletelessicon";
			$cssclass_text = "incompletelessstatus";
			$tooltip = "Status Incomplete (<80%)::This test was started but completed less than 80% of the test";
			break;
	} 
?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<a href="<?php JURI::root(true) ?>/administrator/index.php?option=com_dnagifts&view=testdetail&id=<?php echo (int) $item->id; ?>" 
				title="View Test Analysis::Click here to see a detailed breakdown of this test" 
				class="hasTip viewreport"></a>
			<?php if ((int) $item->progress >= 80): ?>
				<a href="<?php JURI::root(true) ?>/index.php?option=com_dnagifts&format=raw&view=report&id=<?php echo (int) $item->id; ?>" 
					title="Download Report Results::Click here to download the Test Results Report of this test in PDF format" 
					class="hasTip pdfreport modal"
					rel="{size: {x: 1000, y: 550}, handler: 'iframe'}"></a>
			<?php endif; ?>
		</td>
		<td>
			<?php echo $item->name; ?> (<?php echo $item->username; ?>)
		</td>
		<td>
			<?php echo $item->test_name; ?> (testid: <?php echo $item->test_id; ?>)
		</td>
		<td style="text-align:right">
			(<?php echo $item->answer_count . "/" . $item->question_count; ?>) &nbsp;
			<span title="<?php echo $tooltip ?>" class="hasTip progresstext <?php echo $cssclass_text; ?>">
				<?php echo $item->progress; ?>%
			</span>
		</td>
		<td>
			<?php echo JHtml::_('date', $item->started_datetime, JText::_('DATE_FORMAT_LC2')); ?>
		</td>
		<td align="center">
			<div title="<?php echo $tooltip ?>" class="hasTip statusicon <?php echo $cssclass_icon ?>"></div>
		</td>
		<td>
			<?php echo $item->report_name; ?>
		</td>
		<td>
			<?php echo $item->user_browser; ?>
		</td>
		<td>
			<?php echo $item->user_platform; ?>
		</td>
		<td style="text-align:right">
			<?php echo (int) $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>