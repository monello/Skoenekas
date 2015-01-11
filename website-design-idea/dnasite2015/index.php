<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" 
   xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
	<head>
		<jdoc:include type="head" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
	</head>
	<body>
	
		<div id="dnaTopContainer" class="container-fluid navbar-fixed-top">
		
			<div class="row-fluid">
				<div class="col-md-12 header">
					<div id="dnaPageLogo" class="col-md-6 col-md-offset-3">
						<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/dnaPageLogo.png" />
					</div>
				</div>
			</div>
			
			<div class="row-fluid">
				<nav class="col-md-6 col-md-offset-3">
						<ul class="nav nav-pills">
							<li><a id="homenav" href="<?php echo $this->baseurl ?>">Home</a></li>
							<li><a id="booknav" href="<?php echo $this->baseurl ?>/the-book">The Book</a></li>
							<li><a id="buynav" href="<?php echo $this->baseurl ?>/purchase">Purchase</a></li>
							<li><a id="testnav" href="<?php echo $this->baseurl ?>/free-test-en">Free Test</a></li>
							<li><a id="giftsnav" href="<?php echo $this->baseurl ?>">DNA Gifts</a></li>
							<li><a id="eventsnav" href="<?php echo $this->baseurl ?>">Events</a></li>
							<li><a id="seminarnav" href="<?php echo $this->baseurl ?>">Seminars</a></li>
						</ul>
				</nav>
			</div>
			
		</div>
	
		<div class="container-fluid">
			<div id="dnaPageBody" class="row-fluid clearfix">
				<div id="dnaSideMenu" class="col-md-2 col-md-offset-1 affix">
					<jdoc:include type="modules" name="user1" /> 
				</div>
				<div class="col-md-6  col-md-offset-3">
					<jdoc:include type="component" />
				</div>
			</div>
			
			<div id="dnaFooterLinks" class="row-fluid clearfix">
				<div class="col-md-6 col-md-offset-3">
					<div class="row linksrow">
						<h2>Follow Us</h2>
						<a class="socialbutton facebook" href="http://www.facebook.com" title="Facebook" alt="Facebook" target="new">Facebook</a>
						<a class="socialbutton twitter" href="http://www.twitter.com" title="Twitter" alt="Twitter"target="new">Twitter</a>
						<a class="socialbutton pinterest" href="http://www.pinterest.com" title="Pinterest" alt="Pinterest" target="new">Pinterest</a>
						<a class="socialbutton googleplus" href="http://www.google.com" title="Google+" alt="Google+" target="new">Google+</a>
						<a class="socialbutton youtube" href="http://www.youtube.com" title="YouTube" alt="YouTube" target="new">YouTube</a>
						<a class="socialbutton skype" href="http://www.skype.com" title="Skype" alt="Skype" target="new">Skype</a>
						<a class="socialbutton rss" href="http://www.rss.com" title="RSS" alt="RSS" target="new">RSS</a>
						<a class="socialbutton sharethis" href="http://www.sharethis.com" title="ShareThis" alt="ShareThis" target="new">ShareThis</a>
					</div>
					
					<div class="row linksrow">
						<h2>Latest Tech</h2>
						<a class="techbutton htmlbtn" href="http://www.html5.com" title="HTML5" alt="HTML5" target="new">HTML5</a>
						<a class="techbutton cssbtn" href="http://www.css3.com" title="CSS3" alt="CSS3" target="new">CSS3</a>
						<a class="techbutton jsbtn" href="http://www.javascript.com" title="JavaScript" alt="JavaScript" target="new">JavaScript</a>
						<a class="techbutton jqbtn" href="http://www.jquery.com" title="JQuery" alt="JQuery" target="new">JQuery+</a>
						<a class="techbutton jquibtn" href="http://www.jqueryui.com" title="JQuery UI" alt="JQuery UI" target="new">JQuery UI</a>
					</div>
				</div>
			</div>
			
			<div id="dnaFooterLegals" class="row-fluid">
				<div class="col-md-6 col-md-offset-3">
					<p>&copy;<?php echo date("Y") ?> DNA Gifts. All Rights Reserved. | Terms of Use | Privacy Policy | Site by: Morn&eacute; Louw</p>
				</div>
			</div>
		</div>
		
		<a href="#0" class="cd-top">Top</a>
		
		<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.scrollTo.min.js"></script>
		<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/backtotop.js"></script>
		<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/main.js"></script>
	</body>
</html>