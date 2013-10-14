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
  public function checks()
  {
    echo json_encode(array(
      "success" => true, 
      "data"    => DnagiftsHelper::pretestFlightChecks()
    ));
  }

  /***************************************************************************** QUESTION 1 ************************************************************************************************************/
  public function getQ1()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_ISCHRISTIAN_LABEL');
		$questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_ISCHRISTIAN_DESC');
    
    $buttons = '<div id="pretestquestiondiv"><table id="pretestquestiontable" height="100%" width="50%" style="margin-left:auto; margin-right:auto;">
        <tbody>
          <tr id="trButtons">
                      <td align="center">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 1, field: \'is_christian\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Yes</a></div>
                      </td>
                      <td align="center">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 0, field: \'is_christian\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">No</a></div>
                      </td>
                    </tr>
        </tbody>
      </table></div>';
		
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
    
    $buttons = '<div id="pretestquestiondiv"><table id="pretestquestiontable" height="100%" width="50%" style="margin-left:auto; margin-right:auto;">
        <tbody>
          <tr id="trButtons">
                      <td align="center">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 1, field: \'in_church\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Yes</a></div>
                      </td>
                      <td align="center">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: 0, field: \'in_church\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">No</a></div>
                      </td>
                    </tr>
        </tbody>
      </table></div>';
		
    echo json_encode(array(
      "success"       => true, 
      "label"         => $label,
      "questionText"  => $questionText,
      "buttons"       => $buttons
    ));
	}
	
  /***************************************************************************** QUESTION 3 ************************************************************************************************************/
  public function getQ3()
	{
		$label = '';
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_CHURCHNAME_LABEL');
    
    $buttons = '<div id="pretestquestiondiv"><table id="pretestquestiontable" height="100%" width="50%" style="margin-left:auto; margin-right:auto;">
        <tbody>
          <tr id="trButtons">
                      <td align="center" width="75%">
                        <div class="dnaAnswerButton" style="display: block;">
                        <input id="textfield" name="church_name" type="text"size="50" maxlength="50" class="text ui-widget-content ui-corner-all" style="height:20px"/>
                        </div>
                      </td>
                      <td align="center" width="25%">
                        <div class="dnaAnswerButton" style="display: block;"><a data="{answer: undefined, field: \'church_name\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Save</a></div>
                      </td>
                    </tr>
        </tbody>
      </table>
      </div>';
		
    echo json_encode(array(
      "success"       => true, 
      "label"         => $label,
      "questionText"  => $questionText,
      "buttons"       => $buttons
    ));
	}
	
  /***************************************************************************** QUESTION 4 ************************************************************************************************************/
  public function getQ4()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_PASTORREVEREND_LABEL');
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_PASTORREVEREND_DESC');
    
    $buttons = '<div id="pretestquestiondiv"><table id="pretestquestiontable" height="100%" width="50%" style="margin-left:auto; margin-right:auto;">
        <tbody>
          <tr id="trButtons">
            <td align="center" width="75%">
              <div class="dnaAnswerButton" style="display: block;">
              <input id="textfield" name="pastor_reverend" type="text"size="50" maxlength="50" class="text ui-widget-content ui-corner-all" style="height:20px"/>
              </div>
            </td>
            <td align="center" width="25%">
              <div class="dnaAnswerButton" style="display: block;"><a data="{answer: undefined, field: \'pastor_reverend\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Save</a></div>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
      ';
		
    echo json_encode(array(
      "success"       => true, 
      "label"         => $label,
      "questionText"  => $questionText,
      "buttons"       => $buttons
    ));
	}
  
  /***************************************************************************** QUESTION 5 ************************************************************************************************************/
  public function getQ5()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_YOURCITY_LABEL');
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_YOURCITY_DESC');
    
    $buttons = '<div id="pretestquestiondiv"><table id="pretestquestiontable" height="100%" width="50%" style="margin-left:auto; margin-right:auto;">
        <tbody>
          <tr id="trButtons">
            <td align="center" width="75%">
              <div class="dnaAnswerButton" style="display: block;">
              <input id="textfield" name="your_city" type="text"size="50" maxlength="50" class="text ui-widget-content ui-corner-all" style="height:20px"/>
              </div>
            </td>
            <td align="center" width="25%">
              <div class="dnaAnswerButton" style="display: block;"><a data="{answer: undefined, field: \'your_city\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Save</a></div>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
      ';
		
    echo json_encode(array(
      "success"       => true, 
      "label"         => $label,
      "questionText"  => $questionText,
      "buttons"       => $buttons
    ));
	}
  
  /***************************************************************************** QUESTION 6 ************************************************************************************************************/
  public function getQ6()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_YOURCOUNTRY_LABEL');
    $questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_YOURCOUNTRY_DESC');
    $options_html = '';
    foreach ( DnaGiftsHelper::getCountryOptions() as $row ) {
      $options_html = $options_html .'<option value="'.$row->value.'">'.$row->text.'</option>';
    }
    
    $buttons = '<div id="pretestquestiondiv"><table id="pretestquestiontable" height="100%" width="50%" style="margin-left:auto; margin-right:auto;">
        <tbody>
          <tr id="trButtons">
            <td align="center" width="75%">
              <div class="dnaAnswerButton" style="display: block;">
              <select id="textfield" name="your_country">' . $options_html . '</select></div>
            </td>
            <td align="center" width="25%">
              <div class="dnaAnswerButton" style="display: block;"><a data="{answer: -1, field: \'your_country\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Save</a></div>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
      ';
		
    echo json_encode(array(
      "success"       => true, 
      "label"         => $label,
      "questionText"  => $questionText,
      "buttons"       => $buttons
    ));
	}
  
	/***************************************************************************** QUESTION 7 ************************************************************************************************************/
	public function getQ7()
	{
		$label = JText::_('COM_DNAGIFTS_PRETEST_FIELD_DIVINE_LABEL');
		$questionText = JText::_('COM_DNAGIFTS_PRETEST_FIELD_DIVINE_DESC');
    
		$buttons = '<div id="pretestquestiondiv"><table id="pretestquestiontable" height="100%" width="50%" style="margin-left:auto; margin-right:auto;">
		<tbody>
			<tr id="trButtons">
				<td align="center">
					<div class="dnaAnswerButton" style="display: block;"><a data="{answer: 1, field: \'believe_divine\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">Yes</a></div>
				</td>
				<td align="center">
					<div class="dnaAnswerButton" style="display: block;"><a data="{answer: 0, field: \'believe_divine\'}" href="#" class="pretestbutton btnAnswer hasTip" title="">No</a></div>
				</td>
			</tr>
		</tbody>
		</table></div>';
		
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
			switch ($field) {
				case 'church_name':
					$query->set($field.'  = '.$db->quote($this->camelCaseSentence($answer)));
					$query->set('church_mapped  = '.$db->quote($this->camelCaseSentence($answer)));
					break;
				case 'your_city':
					$query->set($field.'  = '.$db->quote($this->camelCaseSentence($answer)));
					$query->set('city_mapped  = '.$db->quote($this->camelCaseSentence($answer)));
					break;
				case 'pastor_reverend':
					$query->set($field.'  = '.$db->quote($this->camelCaseSentence($answer)));
					$query->set('pastor_mapped  = '.$db->quote($this->camelCaseSentence($answer)));
					break;
				default:
					if (gettype($answer) == "integer") {
						$query->set($field.'  = '.(int) $answer);
					} else {
						$query->set($field.'  = '.$db->quote($this->camelCaseSentence($answer)));
					}
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
  
	protected function camelCaseSentence($input) {
		$strlist = array();
        foreach ( explode(" ", strtolower($input)) as $word ) {
            $strlist[] = ucfirst($word);
        }
        return implode(" ", $strlist);
	}
  
}
