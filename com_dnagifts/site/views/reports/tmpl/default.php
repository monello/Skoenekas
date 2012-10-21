<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<div id="dnaReportSpace">

<h2><?php echo JText::_('COM_DNAGIFTS_REPORTS_HEADER'); ?></h2>

<table width="100%" id="pickreporttable"><thead>
    <tr>
      <th><?php echo JText::_('COM_DNAGIFTS_RESPORTS_TABLE_COL_TESTDATE'); ?></th>
      <th><?php echo JText::_('COM_DNAGIFTS_RESPORTS_TABLE_COL_TESTNAME'); ?></th>
      <th><?php echo JText::_('COM_DNAGIFTS_RESPORTS_TABLE_COL_REPORT'); ?></th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach($this->reports as $i => $report): ?>
    <tr>
      <td><?php echo $report->started_datetime; ?></td>
      <td><?php echo $report->test_name; ?></td>
      <td><a href="<?php echo JURI::base(true); ?>/index.php?option=com_dnagifts&task=reports.dlpdf&f=<?php echo str_replace("\s","\%20",$report->report_name) ?>"><?php echo str_replace("\s","%20",$report->report_name) ;?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

</div>

<div id="postTestHome">
  <a href="<?php echo JURI::base() ?>"><?php echo jText::_('COM_DNAGIFTS_TEST_HOMEPAGE'); ?></a>
</div>