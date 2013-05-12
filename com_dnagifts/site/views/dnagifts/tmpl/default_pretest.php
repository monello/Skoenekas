<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if ($this->hasPretestInfo) { return; }

$user = JFactory::getUser();
?>
<script>
	var autoSuggestData = {
		churchList: <?php echo json_encode($this->autoSuggestData['churchList']); ?>,
    	pastorList: <?php echo json_encode($this->autoSuggestData['pastorList']); ?>,
    	cityList: <?php echo json_encode($this->autoSuggestData['cityList']); ?>
  	};
</script>

<?php echo JText::_('COM_DNAGIFTS_PRETEST_HEAD'); ?>
<p><?php
  echo JText::_('COM_DNAGIFTS_PRETEST_WELCOME');
  echo " ".$user->get("name")."</p><p>";
  echo JText::_('COM_DNAGIFTS_PRETEST_BLURB');
?></p>

<form action="<?php echo JRoute::_('index.php?option=com_dnagifts'); ?>"
			method="post" name="adminForm" id="adminForm" class="form-validate">
	<fieldset>
			<legend><?php echo JText::_( 'COM_DNAGIFTS_PRETEST_LEGEND_DETAILS' ); ?></legend>
			<div class="formelm">
        <?php echo $this->form->getLabel('is_christian'); ?>
        <?php echo $this->form->getInput('is_christian'); ?>
			</div>
      
      <div class="formelm">
        <?php echo $this->form->getLabel('in_church'); ?>
        <?php echo $this->form->getInput('in_church'); ?>
			</div>
      
      <div id="extrachurchinfo" style="display:none">
        <div class="formelm" style="padding-left:15px;">
          <?php echo $this->form->getLabel('church_name'); ?>
          <?php echo $this->form->getInput('church_name'); ?>
        </div>
      
        <div class="formelm" style="padding-left:15px;">
          <?php echo $this->form->getLabel('pastor_reverend'); ?>
          <?php echo $this->form->getInput('pastor_reverend'); ?>
        </div>
      </div>
      
      <div class="formelm">
        <?php echo $this->form->getLabel('your_city'); ?>
        <?php echo $this->form->getInput('your_city'); ?>
			</div>
      
      <div class="formelm">
        <?php echo $this->form->getLabel('your_country'); ?>
        <?php echo $this->form->getInput('your_country'); ?>
			</div>
      
      <div class="formelm">
        <?php echo $this->form->getLabel('believe_divine'); ?>
        <?php echo $this->form->getInput('believe_divine'); ?>
			</div>
      
		</fieldset>
		
		<?php
			// Note: Due to the fact that this form submits to the main controller.php,
			//			we make the task "submit" and not "dnagifts.submit"
			//			If you mahe the task "dnagifts.submit" Joomla will look for the
			//			"dnagifts" controller in the controllers folder, which is not what we
			//			want in this case, we need to to call the root-controller (controller.php)
		?>
		<input type="hidden" name="task" value="submit" />
		<input type="hidden" name="jform[menuid]" value="<?php echo JSite::getMenu()->getActive()->id; ?>" />
		<?php echo JHtml::_('form.token'); ?>
		
		<button type="submit" class="button"><?php echo JText::_('COM_DNAGIFTS_PRETEST_SUBMITBTN'); ?></button>
</form>

