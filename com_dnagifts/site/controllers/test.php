<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @since		1.5
 */
class DnaGiftsControllerTest extends JControllerForm
{
	public function loadtest() {
    $test_id = JRequest::getCmd('id');
    $this->setRedirect(JRoute::_('index.php?option=com_dnagifts&view=test&id='.$test_id, false));
  }
}
