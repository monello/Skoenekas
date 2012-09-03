<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');
JLoader::register('DnaGiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');

/**
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @since		1.5
 */
class DnaGiftsControllerTest extends JControllerForm
{
  public function pdf()
  {
    DnagiftsHelper::generatepdf('Morne Louw', $title='DNA Gifts - Report',
				$subject='Test Results', $keywords='DNA Gifts, Free Test',
				$documentname='results001', $displaytype='I');
  }
  
  public function testmail()
  {
	# Set some variables for the email message
	$subject = "You have a new message";
	$body = "Here is the body of your message.";
	$to = "louw.morne@gmail.com";
	$from = array("louw.morne@ymail.com", "Morne Louw");
	 
	# Invoke JMail Class
	$mailer = JFactory::getMailer();
	 
	# Set sender array so that my name will show up neatly in your inbox
	$mailer->setSender($from);
	 
	# Add a recipient -- this can be a single address (string) or an array of addresses
	$mailer->addRecipient($to);
	 
	$mailer->setSubject($subject);
	$mailer->setBody($body);
	 
	# If you would like to send as HTML, include this line; otherwise, leave it out
	$mailer->isHTML();
	
	$file = JPATH_SITE."/README.txt";
	$mailer->addAttachment($file);
	
	# Send once you have set all of your options
	$mailer->send();
	
	echo "EMAIL SENT";
  }
  
	public function abspath() {
		echo JURI::root();	
		echo "<br/>";
		echo getcwd();
		echo "<br/>";
		echo "DS: ".DS;
		echo "<br/>";
		echo JPATH_SITE;
	}
}
