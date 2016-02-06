<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
JLoader::register('ReportsHelper', JPATH_COMPONENT.'/helpers/reports.php');

//$this->isLoggedIn = DnaGiftsHelper::authenticate();
$this->isLoggedIn 	= DnaGiftsHelper::isLoggedIn();
$first_name 		= ReportsHelper::extractFirstName($this->user->id);
$report_name		= ReportsHelper::generatePDFName($this->userTestID);
?>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>';
	var uid = <?php echo $this->user->id; ?>;
	var israw = <?php echo $this->israw; ?>;
</script>
<style>
div.actionsbar {
	background-color: white; 
	position: fixed; 
	top: 0px;
	left: 0px;
	height: 35px; 
	padding-left: 5px;
	width: 100%;
	box-shadow: 0px 10px 5px rgb(208,208,208);
	font-weight: bold;
	font-family: arial,helvetica,sans-serif;
	z-index: 1000;
}
div.actionsbar a { color: blue }
#dnaReportWrapper { font-family: arial,helvetica,sans-serif; }
#notificationcontainer { margin-top: 50px; }
/*.actionsbar { display: none }*/
</style>

<?php if ($this->israw > 0): ?>
<div class="actionsbar">
	<a id="resendReportBtn" href="#" class="hasTip" title="Email to User::Click here to resend the report of this test to the user">Email to User</a> | 
	<a href="<?php echo JURI::base(true); ?>/index.php?option=com_dnagifts&task=reports.dlpdf&f=<?php echo str_replace("\s","\%20",$report_name) ?>"" class="hasTip" title="Download as PDF::Click here to download the report of this test as a PDF. You can then mail attach it to an email manually">Download as PDF</a>
</div>
<?php endif; ?>

<div id="notificationcontainer">
  <div id="notificationtab">
	<img id="notificationspinner" src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/spinner16x16.gif">
	<span id="notificationtext"><?php echo JText::_('COM_DNAGIFTS_REPORT_PREPEMAIL'); ?></span>
  </div>
</div>

<script type="text/javascript">
	var dnaChartCount = 5; //9
	var dnaMaxScore = <?php echo $this->dnaMaxScore; ?>;
	var userTestID = <?php echo $this->userTestID; ?>;
	var dnaResults = <?php echo json_encode($this->dnaResults); ?>;
	var dnaReportCopy = {
		'motivationalflow': "<?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_CHARTHEAD'); ?>"
	};
	var first_name = '<?php echo $first_name; ?>';
</script>

<?php if ($this->israw < 1): ?>
<div id="fb-root"></div>
<?php endif; ?>

<div id="dnaReportWrapper">
	<img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/banner1-900px.png" style="margin-bottom: 30px" width="900px" height="189px" />
	<table id="tblReportSection" width="900" cellpadding="0" cellspacing="0">
		<tr>
			<td width="410">
				<span class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_REPORT_SCORINGTABLEHEADER'); ?></span>
			</td>
			<td width="20">
				&nbsp;
			</td>
			<td width="465">
				<span class="rptText16">Hi <?php echo $this->user->name; ?></span>
			</td>
		</tr>
		
		<tr>
			<td>
				
				<table id="tblScores" width="250" cellspacing="3">
					<thead>
						<th><?php echo JText::_('COM_DNAGIFTS_REPORT_THGIFT'); ?></th>
						<th><?php echo JText::_('COM_DNAGIFTS_REPORT_THSCORE'); ?></th>
						<th><?php echo JText::_('COM_DNAGIFTS_REPORT_THYOURGIFT'); ?></th>
					</thead>
					<tbody>
						<?php foreach($this->dnaResults as $data): ?>
							<tr class="tr<?php echo $data['label']; ?>">						
								<td><?php echo $data['abbr']; ?></td>
								<td class="tdScore"><?php echo $data['score']; ?></td>
								<td class="tdYourGift"><?php echo $data['label']; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</td>
			<td>&nbsp;</td>
			<td>
				<p>
				<?php echo JText::_('COM_DNAGIFTS_REPORT_INTRO_P1'); ?>
				<br/><br/>
				<span class="rptText12"><strong><?php echo JText::_('COM_DNAGIFTS_REPORT_HEREYOURESULTS'); ?></strong></span>
				<br/>
				<?php echo JText::_('COM_DNAGIFTS_REPORT_INTRO_P2'); ?>
				</p>
			</td>
		</tr>
		
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
		
		<tr>
			<td>
				<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_REPORT_YOURLINEPROFILE'); ?></p>
			</td>
			<td>&nbsp;</td>
			<td>
				<p class="rptText12"><strong><?php echo JText::_('COM_DNAGIFTS_REPORT_YOURLINEPROFILE_INTERP'); ?></strong></p>
			</td>
		</tr>
		<tr>
			<td>
				<table id="tblDNAChart">
					<tr>
						<td align="center">
							<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_HEAD'); ?>
						</td>
					</tr>
					<tr>
						<td>
							<img src="<?php echo $this->dnaChartSrc; ?>">
							<img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/primary-secondary-<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_PRIMSECIMG'); ?>-2.png" />
						</td>
					</tr>
				</table>
				
			</td>
			<td>&nbsp;</td>
			<td>
				<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_TEXT'); ?>
			</td>
		</tr>
		
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
		
		<tr>
			<td><p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACOMP_HEAD'); ?></p></td>
			<td>&nbsp;</td>
			<td>
				<p class="rptText12"><strong><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACOMP_INTERP'); ?></strong></p>
			</td>
		</tr>
		<tr>
			<td>
				<div id="piechart_div" style="width: 400px; height: 300px;"></div>
				<div id="picont" style="position:absolute;left: -1000px;">
					<div id="piechart_div_hidden" style="width: 400px; height: 210px;"></div>
				</div>
			</td>
			<td>&nbsp;</td>
			<td>
				<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACOMP_TEXT'); ?>
			</td>
		</tr>
		
		<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
		
		<tr>
			<td><p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD'); ?></p></td>
			<td>&nbsp;</td>
			<td>
				<p class="rptText12"><strong><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_INTERP'); ?></strong></p>
			</td>
		</tr>
		<tr>
			<td>
				<div id="linechart_div" style="width: 400px; height: 255px;"></div>
				<span id="line-auth">Authority</span><span id="line-strength">Strength</span><span id="line-valley">The Valley</span>
			</td>
			<td>&nbsp;</td>
			<td>
				<?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT'); ?>
			</td>
		</tr>
		
		
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
		
		<tr>
			<td colspan="3">
				<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY'); ?></p>
			</td>
		</tr>
		<?php $position = 0; ?>
		<tr>
			<td>
				<img src="<?php echo ReportsHelper::getHeaderImg($this->dnaResults, $position); ?>" /><br/>
				<img src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" />
				<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_STRENGTHMETER'); ?></p>
				<div id="gauge1chart_div" class="gaugecontainer"></div>
			</td>
			<td>&nbsp;</td>
			<td>
				
				<?php echo ReportsHelper::getGiftDescription($this->dnaResults, $position); ?>
			</td>
		</tr>
		
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
		<?php $position += 1; ?>
		<tr>
			<td colspan="3">
				<p class="rptText16 reportHeading"><?php echo strtoupper($first_name); ?><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY'); ?></p>
			</td>
		</tr>
		
		<tr>
			<td>
				<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_2NDDNAGIFT'); ?></p>
				<img src="<?php echo ReportsHelper::getHeaderImg($this->dnaResults, $position); ?>" /><br/>
				<img src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" />
				<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_STRENGTHMETER'); ?></p>
				<div id="gauge2chart_div" class="gaugecontainer"></div>
			</td>
			
			<td>&nbsp;</td>
			
		<?php $position += 1; ?>
			<td>
				<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_3RDDNAGIFT'); ?></p>
				<img src="<?php echo ReportsHelper::getHeaderImg($this->dnaResults, $position); ?>" /><br/>
				<img src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" />
				<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_STRENGTHMETER'); ?></p>
				<div id="gauge3chart_div" class="gaugecontainer"></div>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY_SUMMARY'); ?>
			</td>
		</tr>
		
		
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
		
		<!-- RXTRA GUAGES -->
		<tr>
			<td colspan="3">
				<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SERVICE'); ?></p>
			</td>
		</tr>
		
		<tr>
			<td colspan="3">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:0 !important">
					<tr>
						<td width="25%">
							<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_4THDNAGIFT'); ?></p>
							<?php $position += 1; ?>
							<img align="center" src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" />
						</td>
						<td width="25%">
							<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_5THDNAGIFT'); ?></p>
							<?php $position += 1; ?>
							<img align="center" src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" />
						</td>
						<td width="25%">
							<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_6THDNAGIFT'); ?></p>
							<?php $position += 1; ?>
							<img align="center" src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" />
						</td>
						<td width="25%">
							<p class="rptText16 reportHeading"><?php echo JText::_('COM_DNAGIFTS_7THDNAGIFT'); ?></p>
							<?php $position += 1; ?>
							<img align="center" src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" />
						</td>
					</tr>
					<tr><td colspan="4">&nbsp</td></tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						<td colspan="2" style="background-color: #999; color:#fff; text-align: center;"><p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_VALLEYLACKMOTIVATION'); ?></p></td>
					</tr>
				</table>
			</td>
		</tr>
		
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>

		
	</table>
</div>

<?php 

	$required_file = JPATH_ROOT.DS.'components'.DS.'com_jfbconnect'.DS.'libraries'.DS.'facebook.php';
	
	if (file_exists($required_file) && $this->israw < 1) {
		require_once $required_file;
	    $userMapModel = new JFBConnectModelUserMap();
	    $userMapModel->getData($this->user->id);
	    $accessToken = $userMapModel->_data->access_token;
	    
	    $jfbcLibrary = JFBConnectFacebookLibrary::getInstance();
	    $giftname = ReportsHelper::getGiftLabel($this->dnaResults, 0);
	    $aOrAn = ReportsHelper::aOrAn($giftname);
	    $post['message'] = 'My DNA Gift was just revealed, what it yours?';
	    $post['link'] = 'http://www.dnagifts.net/home/';
	    $post['name'] = 'The FREE DNA Gifts Test';
	    $post['caption'] = 'KNOW THYSELF';
	    $post['picture'] = 'http://www.dnagifts.net/media/com_dnagifts/images/ab520632-247f-11e3-8b68-e1d49c0db4f0-172px.jpg'; //$this->dnaChartSrc;
	    $post['description'] = $first_name.' has done the FREE DNA Gifts test. This test revealed my Dynamic Natural Ability. It was designed to help me to discover my life-purpose. Its insightful and will help you also to unlock your life purpose.';
	    $post['access_token'] = $accessToken;
	    if ($jfbcLibrary->getMappedFbUserId()) { // Check if there is a Facebook user logged in
	      $jfbcLibrary->setFacebookMessage($post);
	    } 
	}
	
?>


