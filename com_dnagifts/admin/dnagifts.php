<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');

$tempmessage = 'Hi Juan, hierdie is net \'n voorsmakie, moet nog nie regte data in tik nie wat dit sal verlore gaan elke keer as ek die component re-install. '.
    'Hou ook ingedagte dit is nog \'n work-in-progress so sal nog baie verbeter en features by kry oor die volgende paar dae. - Morn&eacute; -';
//JError::raiseNotice( 100, $tempmessage );

// Get an instance of the controller prefixed by DnaGifts
$controller = JController::getInstance('DnaGifts');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();