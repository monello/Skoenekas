<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');

$this->isLoggedIn = DnaGiftsHelper::authenticate();

?>

<div id="notificationcontainer">
  <div id="notificationtab"><?php echo JText::_('COM_DNAGIFTS_REPORT_PREPEMAIL'); ?></div>
</div>

<script type="text/javascript">var dnaChartCount = 2;</script>

<div id="dnaReportSpace">
	<a href="http://localhost/" class="hasTip" title="This is a tip Title::This is the tip body text">back</a>
</div>

<div id="gaugechart_div" style="width: 800px; height: 120px;"></div>
<div id="columnchart_div" style="width: 900px; height: 500px;"></div>
<div id="piechart_div" style="width: 900px; height: 500px;"></div>


<table >
<tr><td align="center"><strong>DNA CHART</strong></td></tr>
<tr><td>
<!--
Dark	| Light
FF0000	| CC6666
FFC000	| FFCC99
FFFF00	| FFFF99
00B050	| 99CC99
538ED5	| 66CCCC
333391	| 6666CC
990099	| 9966CC
-->
<?php
	$charttype = 'lxy';
	$chartsize = '400x300';
	$chartdata = 't:7,15,23,30,38,46,53|23,18,16,49,35,40,19';
	$chartscale = '0,60';
	$seriescolors = 'FF0000|FFC000|FFFF00|00B050|538ED5|333391|990099';
	$linestyle = '1';
	$visibleaxes = 'x,x,y'; // (x,y,t,b) (x-axis, y-axis, top, bottom)
	$axeslabels = '0:| |P|S|T|E|G|R|M| |1:| |23|18|16|49|35|40|19| |2:|0|10|20|30|40|50|60';
	$chartgrid = '100.0,25.0';
	$chartfill = 'bg,ls,0,FFFFFF,0.09,CC6666,0.10,FFCC99,0.095,FFFF99,0.095,99CC99,0.10,66CCCC,0.10,6666CC,0.09,9966CC,0.09,FFFFFF,0.2';
	$markers = 'd,FF0000,0,0,10|d,FFC000,0,1,10|d,FFFF00,0,2,10|d,00B050,0,3,10|d,538ED5,0,4,10|d,333391,0,5,10|d,990099,0,6,10'; // marker type, color, series index, which points, size
	$legends = 'Perceiver|Servant|Teacher|Exhorter|Giver|Ruler|Mercy';
	$primarybubble = 'y;s=bubble_text_small;d=bb,Primary+Gift,FF8,000;ds=0;dp=3';
	$secondarybubble = 'y;s=bubble_text_small;d=bb,Secondary+Gift,FF8,000;ds=0;dp=5';
	
?>
<img src="https://chart.googleapis.com/chart?cht=<?php echo $charttype;
	?>&chs=<?php echo $chartsize;
	?>&chd=<?php echo $chartdata;
	?>&chds=<?php echo $chartscale;
	?>&chco=<?php echo $seriescolors;
	?>&chls=<?php echo $linestyle;
	?>&chxt=<?php echo $visibleaxes;
	?>&chxl=<?php echo $axeslabels;
	?>&chg=<?php echo $chartgrid;
	?>&chf=<?php echo $chartfill;
	?>&chm=<?php echo $markers;
	?>&chdl=<?php echo $legends;
	?>&chem=<?php echo $primarybubble; ?>|<?php echo $secondarybubble; ?>">
</td></tr>

</table>

<!--
<img src="http://chart.apis.google.com/chart?chs=300x150&amp;cht=p3&amp;chco=7777CC|76A4FB|3399CC|3366CC&amp;chd=s:Uf9a&amp;chdl=January|February|March|April" class="gallery-img">

<img src="http://chart.apis.google.com/chart?cht=lxy&chs=400x250&chd=t:0,30,60,70,90,95,100|20,30,40,50,60,70,80|10,30,40,45,52|100,90,40,20,10|-1|5,33,50,55,7&chco=3072F3,ff0000,00aaaa&chls=2,4,1&chm=s,FF0000,0,-1,5|s,0000ff,1,-1,5|s,00aa00,2,-1,5">
<img src="http://chart.apis.google.com/chart?cht=bvg&amp;chs=200x125&amp;chd=s:hello,world&amp;chco=cc0000,00aa00">
<img src="http://chart.apis.google.com/chart?cht=p3&amp;chd=s:Uf9a&amp;chs=200x100&amp;chl=Rails|PHP|Java|.NET">
<img src="http://chart.apis.google.com/chart?cht=v&amp;chs=200x100&amp;chd=t:100,80,60,30,30,30,10">
<img src="http://chart.apis.google.com/chart?cht=lc&amp;chd=s:99,cefhjkqwrlgYcfgc,QSSVXXdkfZUMRTUQ,HJJMOOUbVPKDHKLH,AA&amp;chco=000000,000000,000000,000000,000000&amp;chls=1,1,0|1,1,0|1,1,0|1,4,0&amp;chs=200x125&amp;chxt=x,y&amp;chxl=0:|Sep|Oct|Nov|Dec|1:||50|100&amp;chg=25,25&amp;chm=b,76A4FB,0,1,0|b,224499,1,2,0|b,FF0000,2,3,0|b,80C65A,3,4,0">
-->



