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
    <tr>
      <td>2012/09/12</td>
      <td>Example Test Name</td>
      <td><a href="<?php echo JURI::base(true).'/components/com_dnagifts/store/DNA%20Gifts%20Assessment%20Report%20(42-20120910232321-1).pdf'; ?>">DNA Gifts Assessment Report</a></td>
    </tr>
  </tbody>
</table>

</div>