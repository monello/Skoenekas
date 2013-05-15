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
  /***************************************************************************** QUESTION 1 ************************************************************************************************************/
  public function getQ1()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_ISCHRISTIAN_LABEL');
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_ISCHRISTIAN_DESC');
    
    $buttons = '<table id="pretestquestiontable" height="100%" width="100%">
        <tbody>
          <tr id="trButtons">
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 1, field: \'is_christian\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Yes</a></div>
                      </td>
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 0, field: \'is_christian\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">No</a></div>
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
  
  /***************************************************************************** QUESTION 2 ************************************************************************************************************/
  public function getQ2()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_INCHURCH_LABEL');
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_INCHURCH_DESC');
    
    $buttons = '<table id="pretestquestiontable" height="100%" width="100%">
        <tbody>
          <tr id="trButtons">
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 1, field: \'in_church\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Yes</a></div>
                      </td>
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 0, field: \'in_church\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">No</a></div>
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
	
  /***************************************************************************** QUESTION 2 ************************************************************************************************************/
  public function getQ3()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_CHURCHNAME_LABEL');
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_CHURCHNAME_LABEL');
    
    $buttons = '<table id="pretestquestiontable" height="100%" width="100%">
        <tbody>
          <tr id="trButtons">
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;">
                        <input id="textfield" name="church_name" type="text"size="50" maxlength="50" class="text ui-widget-content ui-corner-all" style="height:20px"/>
                        </div>
                      </td>
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 0, field: \'church_name\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Save</a></div>
                      </td>
                    </tr>
        </tbody>
      </table>
      <script type="text/javascript">
        console.log("Preparing text field");
        DnaGifts.pretest.attachAutoSuggest("church_name");
        jQuery("#textfield").bind("blur", DnaGifts.pretest.copyTextAnswer);
      </script>
      ';
		
    echo json_encode(array(
      "success"       => true, 
      "label"         => $label,
      "questionText"  => $questionText,
      "buttons"       => $buttons
    ));
	}
	
  /***************************************************************************** QUESTION 3 ************************************************************************************************************/
  public function getQ4()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_PASTORREVEREND_LABEL');
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_PASTORREVEREND_DESC');
    
    $buttons = '<table id="pretestquestiontable" height="100%" width="100%">
        <tbody>
          <tr id="trButtons">
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;">
                        <input id="textfield" name="pastor_reverend" type="text"size="50" maxlength="50" class="text ui-widget-content ui-corner-all" style="height:20px"/>
                        </div>
                      </td>
                      <td align="center" width="50%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 0, field: \'pastor_reverend\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Save</a></div>
                      </td>
                    </tr>
        </tbody>
      </table>
      <script type="text/javascript">
        console.log("Preparing text field");
        DnaGifts.pretest.attachAutoSuggest("pastor_reverend");
        jQuery("#textfield").bind("blur", DnaGifts.pretest.copyTextAnswer);
      </script>
      ';
		
    echo json_encode(array(
      "success"       => true, 
      "label"         => $label,
      "questionText"  => $questionText,
      "buttons"       => $buttons
    ));
	}
  
  
  
  
  
  /****************************************************************************************************************************************************************************************************/
  /***************************************************************************** SAVE ANSWER ***********************************************************************************************************/
  /****************************************************************************************************************************************************************************************************/
  public function saveAnswer()
	{
    $field = JRequest::getVar('field');
    $answer = JRequest::getVar('answer');
    
    $user	= JFactory::getUser();
    $user_id = (int) $user->get('id');
    $id = DnaGiftsHelper::hasPretestID($user_id);
    
    $db   = JFactory::getDbo();
    $query = $db->getQuery(true);
    
    if (!$id) {
      if($field == 'is_christian') {
        $query->insert('#__dnagifts_pretest_info');
        $query->columns('user_id, is_christian, in_church');
        $query->values((int) $user_id . ',' . (int) $answer . ',-1');
      } else {      
        $errtext = "Cannot save this question because pretest-record does not exist";
        $this->setError($errtext);
        echo json_encode(array("success"=> false, "message" => $errtext));
        return false;
      }
    } else {
    	$query->update('#__dnagifts_pretest_info');
      if (gettype($answer) == "integer") {
        $query->set($field.'  = '.(int) $answer);
      } else {
        $query->set($field.'  = '.$db->quote($answer));
      }
      $query->where('id = ' . (int) $id);
    }
    $db->setQuery($query);
    
    if (!$db->query()) {
      $this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_ANSWER'));
      echo json_encode(array("success"=> false, "message" => JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_ANSWER')));
      return false;
    }
    echo json_encode(array("success" => true, "answer" => $answer));
	}
  
  
  
}
