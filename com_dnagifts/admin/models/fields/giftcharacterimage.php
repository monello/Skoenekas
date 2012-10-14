<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

//require_once dirname(__FILE__) . '/../../helpers/dnagifts.php';
JLoader::register('DnaGiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');

/**
 * Bannerclient Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_dnagifts
 * @since		1.6
 */
class JFormFieldGiftCharacterImage extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'GiftCharacterImage';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptions()
	{
		return DnaGiftsHelper::getGiftImages('characters');
	}
}
