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
			$tooltip = "Status Incomplete::This test was started but the user never finished";
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
	} 
?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<a href="#" title="View Report::Click here to see a detailed break down of this test" class="hasTip viewreport"></a>
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