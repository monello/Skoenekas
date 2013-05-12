<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

JLoader::register('DnaGiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');

/**
 * DnaGifts JSON (Ajax) Controller
 */
class DnaGiftsControllerDnaGifts extends JControllerForm
{
  public function getQ1()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_ISCHRISTIAN_LABEL');
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_ISCHRISTIAN_DESC');
    
    $buttons = '<table id="pretestquestiontable" height="100%" width="100%">
        <tbody>
          <tr id="trButtons">
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 1}" href="#" class="pretestbutton btnAnswer hasTip" title="">Yes</a></div>
                      </td>
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 0}" href="#" class="pretestbutton btnAnswer hasTip" title="">No</a></div>
                      </td>
                    </tr>
        </tbody>
      </table>';
		
    echo json_encode(array(
      "success"       => true, 
      "label"         => $label,
      "questionText"  => $questionText,
      "buttons"       => $buttons
    ));
	}
	
  public function saveQ1()
	{
    $answer = JRequest::getCmd('answer');
    
    $user	= JFactory::getUser();
    $user_id = (int) $user->get('id');
    $id = DnaGiftsHelper::hasPretestID($user_id);
    
    $db   = JFactory::getDbo();
    $query = $db->getQuery(true);
    
    if (!$id) {
      $query->insert('#__dnagifts_pretest_info');
      $query->columns('user_id, is_christian, in_church');
      $query->values((int) $user_id . ',' . (int) $answer . ',-1');
    } else {
    	$query->update('#__dnagifts_pretest_info');
    	$query->set('is_christian = '.(int) $answer);
    	$query->where('id = ' . (int) $id);
    }
    
    $db->setQuery($query);
    
    if (!$db->query()) {
      $this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_ANSWER'));
      echo json_encode(array("success"=> false, "message" => JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_ANSWER')));
      return false;
    }
    echo json_encode(array("success" => true));
	}
  
}
