<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item):
	$ordering	= ($this->listOrder == 'ordering');
?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->name; ?> (<?php echo $item->username; ?>)
		</td>
		<td>
			<?php echo $item->test_name; ?> (testid: <?php echo $item->test_id; ?>)
		</td>
		<td style="text-align:right">
			<?php echo $item->progress; ?>%
		</td>
		<td>
			<?php echo JHtml::_('date', $item->started_datetime, JText::_('DATE_FORMAT_LC2')); ?>
		</td>
		<td>
			<?php
			switch ($item->status) {
				case 1:
					$cssclass = "goodicon";
					$tooltip = "Status Good::This Test was completed 100% and the report was generated";
					break;
				case 2:
					$cssclass = "incompleteicon";
					$tooltip = "Status Incomplete::This test was started but the user never finished";
					break;
				case 3:
					$cssclass = "noreporticon";
					$tooltip = "Status No-Report::This Test was completed 100%, but the report was not generated. PLEASE INVESTIGATE";
					break;
				case 4:
					$cssclass = "extraanswersicon";
					$tooltip = "Status Extra-Answers::This Test has more answers than questions. PLEASE INVESTIGATE";
					break;
			} 
			?>
			<div title="<?php echo $tooltip ?>" class="hasTip statusicon <?php echo $cssclass ?>"></div>
		</td>
		<td>
			<?php echo $item->report_name; ?>
		</td>
		<td class="center">
			<?php echo (int) $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>