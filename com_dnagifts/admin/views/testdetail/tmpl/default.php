<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');

?>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>/administrator';
</script>
<h1>Test Analysis</h1>
<table cellpadding="5" cellspacing="0" border="1">
	<tr>
		<td><strong>Test done by:<strong></td>
		<td colspan="3"><?php echo $this->user->name ?></td>
	</tr>
	<tr>
		<td><strong>Session ID:<strong></td>
		<td><?php echo $this->testsummary->session_id ?> (UTID: <?php echo $this->testsummary->id; ?>)</td>
		
		<td><strong>Start Date:<strong></td>
		<td><?php echo $this->testsummary->started_datetime ?></td>
	</tr>
	<tr>
		<td><strong>User's Browser:<strong></td>
		<td><?php echo $this->testsummary->user_browser ?></td>
		
		<td><strong>User's Platform:<strong></td>
		<td><?php echo $this->testsummary->user_platform ?></td>
	</tr>
	<?php if (strlen($this->testsummary->report_name) > 10): ?>
	<tr>
		<td><strong>Report Name:<strong></td>
		<td><?php echo $this->testsummary->report_name ?></td>
		
		<td><strong>Date Sent:<strong></td>
		<td><?php echo $this->testsummary->date_sent ?></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td><strong>Percentage Complete:</strong></td>
		<td colspan="3">
			<?php echo $this->stats['percentComplete'] ?>% | 
			This test has: <?php echo $this->stats['questionCount'] ?> questions. This user answered: <?php echo $this->stats['answerCount'] ?>, skipped: <?php echo $this->stats['skippedCount'] ?> and missed: <?php echo $this->stats['missedQuestions'] ?>
		</td>
	</tr>
</table>

<fieldset id="dnaFiltersSet">
	<legend>Filters</legend>

<div id="dnaFilters">
	<?php if ($this->stats['questionCount'] > 0) : ?>
		<a href="javascript:void(0);" id="showall">Show All (<?php echo $this->stats['questionCount'] ?>)</a> | 
	<?php endif; ?>
	<?php if ($this->stats['missedQuestions'] > 0) : ?>
		<a href="javascript:void(0);" id="showmissed">Show Missed Questions (<?php echo $this->stats['missedQuestions'] ?>)</a> | 
	<?php endif; ?>
	<?php if ($this->stats['skippedCount'] > 0) : ?>
		<a href="javascript:void(0);" id="showskipped">Show Skipped Questions (<?php echo $this->stats['skippedCount'] ?>)</a> |
	<?php endif; ?>
	<?php if ($this->stats['answerCount'] > 0) : ?>
		<a href="javascript:void(0);" id="showgood">Show Answers Questions (<?php echo $this->stats['answerCount'] ?>)</a>
	<?php endif; ?>
</div>


<div id="fltScoreWrap">
	<strong>Score:</strong> 
	<select id="fltScores">
		<option value="-1">- Select Answer -</option>
	<?php foreach ($this->scoregroups as $group) : ?>
		<option value="<?php echo $group->answer_score; ?>"><?php echo $group->button_text; ?> (<?php echo $group->howmany; ?>)</option>"
	<?php endforeach; ?>
	</select>
</div>
</fieldset>


<?php
$cntr = 1;
foreach ($this->testdata as $row):
	$answerObj = false;
	$answerClass = 'noanswer';
	
	foreach ($this->answerdata as $answer) :
		if ($answer->question_id == $row->question_id) {
			$answerClass = 'hasanswer';
			$answerObj = $answer;
			break;
		}
	endforeach;
	
	if (!$answerObj) {
		foreach ($this->skippeddata as $answer) :
			if ($answer->question_id == $row->question_id) {
				$answerClass = 'answerskipped';
				$answerObj = $answer;
				break;
			}
		endforeach;
	}
	
	$btnText = '';
	if ($answerObj) {
		foreach ($this->buttonscores as $button) {
			if ($button->score == $answerObj->answer_score) {
				$btnText = $button->button_text;
			}
		}
	}
?>

<div class="dnaTestCard <?php echo $answerClass; ?> scr_<?php echo $answerClass == 'hasanswer' ? $answerObj->answer_score : $answerClass; ?>">
	<div class="dnaQuesText"><?php echo $row->question_text; ?></div>
	<div class="dnaAnswer">
		<div class="dnaGiftBlock" style="background-color: <?php echo $row->color_hex; ?>;"><?php echo $row->name; ?></div>
		<div class="dnaAnsText">
		<?php if ($answerObj) :
				if((int) $answerObj->is_skipped > 0) {
					$skipstr = $answerObj->is_skipped > 1 ? $answerObj->is_skipped ." times" : $answerObj->is_skipped." time";
					echo "<em>Answer was skipped $skipstr and never completed</em>";
				} else {
					echo '<span class="answer"><strong> Answer:</strong> '.$btnText.'</span>  (Score: '.$answerObj->answer_score.')';
				}
			else:
				echo "<em>No answer found</em>";
			endif; ?>
		</div>
	</div>
	<div class="dnaQuesNmbr">
		Question Order: <?php echo $cntr; ?> 
		| Question ID: <?php echo $row->question_id; ?> 
		<?php if ($answerObj) : ?>| Answer Time: <?php echo $answerObj->answer_datetime; endif; ?>
	</div>
</div>

<?php 
	$cntr++;
endforeach; 
?>