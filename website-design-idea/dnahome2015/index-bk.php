<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" 
   xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
	<head>
		<jdoc:include type="head" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
	</head>
	<body>
	<div class="container-fluid">
		<div class="header">
			<div id="dnaPageLogo" class="col-md-6 col-md-offset-3">
				<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/dnaPageLogo.png" />
			</div>
		</div>
		
		<div class="row-fluid">
			<nav class="col-md-8 col-md-offset-2">
					<ul class="nav nav-pills">
						<li><a id="homenav" href="<?php echo $this->baseurl ?>">Home</a></li>
						<li><a id="booknav" href="<?php echo $this->baseurl ?>">The Book</a></li>
						<li><a id="buynav" href="<?php echo $this->baseurl ?>/purchase">Purchase</a></li>
						<li><a id="testnav" href="<?php echo $this->baseurl ?>/free-test-en">Free Test</a></li>
						<li><a id="giftsnav" href="<?php echo $this->baseurl ?>">DNA Gifts</a></li>
						<li><a id="eventsnav" href="<?php echo $this->baseurl ?>">Events</a></li>
						<li><a id="seminarnav" href="<?php echo $this->baseurl ?>">Seminars</a></li>
					</ul>
			</nav>
		</div>
		<div class="row-fluid">
			<div id="dnaKnowThyself" class="col-md-8 col-md-offset-2">
				<img width="100%" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/dnaKnowThyself.png" />
			</div>
		</div>
	
	
				<div class="carousel slide" id="myCarousel" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-slide-to="0" data-target="#myCarousel" class="active perceiverDot" data-toggle="tooltip" title="Show Perceiver Gift"></li>
						<li data-slide-to="1" data-target="#myCarousel" class="servantDot" data-toggle="tooltip" title="Show Servant Gift"></li>
						<li data-slide-to="2" data-target="#myCarousel" class="teacherDot" data-toggle="tooltip" title="Show Teacher Gift"></li>
						<li data-slide-to="3" data-target="#myCarousel" class="exhorterDot" data-toggle="tooltip" title="Show Exhorter Gift"></li>
						<li data-slide-to="4" data-target="#myCarousel" class="giverDot" data-toggle="tooltip" title="Show Giver Gift"></li>
						<li data-slide-to="5" data-target="#myCarousel" class="rulerDot" data-toggle="tooltip" title="Show Ruler Gift"></li>
						<li data-slide-to="6" data-target="#myCarousel" class="mercyDot" data-toggle="tooltip" title="Show Mercy Gift"></li>
					</ol>
					
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img alt="" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/bootstrap-mdo-sfmoma-01.png">
						</div>
						<div class="item">
							<img alt="" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/bootstrap-mdo-sfmoma-02.png">
						</div>
						<div class="item">
							<img alt="" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/bootstrap-mdo-sfmoma-03.png">
						</div>
						<div class="item">
							<img alt="" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/bootstrap-mdo-sfmoma-01.png">
						</div>
						<div class="item">
							<img alt="" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/bootstrap-mdo-sfmoma-02.png">
						</div>
						<div class="item">
							<img alt="" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/bootstrap-mdo-sfmoma-03.png">
						</div>
						<div class="item">
							<img alt="" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/bootstrap-mdo-sfmoma-01.png">
						</div>
					</div>
					
					<!-- Controls -->
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
					
					
					<div id="dnaHeptagons0"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/heptagons0.png" /></div>
					<div id="dnaHeptagons7" class="heptagon"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/heptagons7.png" /></div>
					<div id="dnaHeptagons6" class="heptagon"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/heptagons6.png" /></div>
					<div id="dnaHeptagons5" class="heptagon"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/heptagons5.png" /></div>
					<div id="dnaHeptagons4" class="heptagon"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/heptagons4.png" /></div>
					<div id="dnaHeptagons3" class="heptagon"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/heptagons3.png" /></div>
					<div id="dnaHeptagons2" class="heptagon"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/heptagons2.png" /></div>
					<div id="dnaHeptagons1" class="heptagon"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/heptagons1.png" /></div>
					
					<div id="carouselMask"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/dnaMountainFrame.png" /></div>
					<div class="carousel-indicators-container">
					
				</div>
				</div>


		<div class="row-fluid">
			<div class="col-md-6 col-md-offset-3">
				<div id="dnaCallToActionContainer">
					<div id="dnaDoTheTest">
						<span class="dnaCallToAction"><a href="<?php echo $this->baseurl ?>/free-test-en">Do the free Test</a></span><br/>
						<span class="dnaCallToActionSub"><a href="<?php echo $this->baseurl ?>/free-test-en">Discover your Natural Abilities</a></span>
					</div>
					<div id="dnaDivider">|</div>
					<div id="dnaPurchaseBook">
						<span class="dnaCallToAction"><a href="<?php echo $this->baseurl ?>/purchase">Purchase the Book</a></span><br/>
						<span class="dnaCallToActionSub"><a href="<?php echo $this->baseurl ?>/purchase">Keep growing your Natural Abilities</a></span>
					</div>
				</div>
			</div>
		</div>
		
		<div id="rainbow" class="row-fluid"></div>
		
		<div id="dnaHomeBody" class="row-fluid">
			<div class="col-md-12"></div>
		</div>
		
		<div id="dnaFooterLinks" class="row-fluid">
			<div class="col-md-12">
				<footer>
				<div class="row-fluid">
				
				</div>
				</footer>
			</div>
		</div>
		
		<div id="dnaFooterLegals" class="row-fluid">
			<div class="span12">

			</div>
		</div>
		
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/main.js"></script>
		
	<!--
		<jdoc:include type="modules" name="top" /> 
		<jdoc:include type="component" />
		<jdoc:include type="modules" name="bottom" />
	-->
	</body>
</html>