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
	<tr>
		<td><strong>Percentage Complete:</strong></td>
		<td colspan="3"> <?php echo $this->stats['percentComplete'] ?>%</td>
	</tr>
	<?php endif; ?>
</table>

<fieldset id="dnaFiltersSet">
	<legend>Filters</legend>
<?php if ($this->stats['missedQuestions'] > 0) : ?>
<div id="dnaFilters">
	<a href="javascript:void(0);" id="showall">Show All (<?php echo $this->stats['questionCount'] ?>)</a> | 
	<a href="javascript:void(0);" id="showmissed">Show Missed Questions (<?php echo $this->stats['missedQuestions'] ?>)</a> | 
	<a href="javascript:void(0);" id="showgood">Show Answers Questions (<?php echo $this->stats['answerCount'] ?>)</a>
</div>
<?php endif; ?>

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
			$answerObj = $answer;
			$answerClass = 'hasanswer';
			break;
		}
	endforeach;
	
	$btnText = '';
	if ($answerObj) {
		foreach ($this->buttonscores as $button) {
			if ($button->score == $answerObj->answer_score) {
				$btnText = $button->button_text;
			}
		}
	}
?>

<div class="dnaTestCard <?php echo $answerClass; ?> scr_<?php echo $answerObj->answer_score; ?>">
	<div class="dnaQuesText"><?php echo $row->question_text; ?></div>
	<div class="dnaAnswer">
		<div class="dnaGiftBlock" style="background-color: <?php echo $row->color_hex; ?>;"><?php echo $row->name; ?></div>
		<div class="dnaAnsText">
		<?php if ($answerObj) :
				echo '<span class="answer"><strong> Answer:</strong> '.$btnText.'</span>  (Score: '.$answerObj->answer_score.')';
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