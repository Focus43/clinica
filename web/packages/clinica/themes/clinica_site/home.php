<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='//fonts.googleapis.com/css?family=Quicksand:400,700' rel='stylesheet' type='text/css' />
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'clinica'); ?>
</head>

<!-- Enjoy checking out what's under the hood? We should talk! www.focus-43.com -->

<body class="clinicaPage home">
		<div id="minHeighter">
		<div class="imageOverlay"></div>
		<div id="bgContainer" class="hidden-phone" data-background="<?php echo $backgroundImage; ?>"></div>

		
		<?php Loader::packageElement('theme_header', 'clinica'); ?>
		
		<div class="container">
			<div class="row homeRow">
				<div class="span12 mainCall">
					<h2>My Clinica Connection</h2>
					<p>Our free patient messaging system available to you all day, every day. </p>
					<a class="mainLogin" href ="#">Login</a>
					<p class="learnMore" ><a href="#">learn more about My CLINICA Connection</a></p>
				</div>
				<div class="span2"></div>
				<div class="span8">
					<div id="homeContent">
					   <?php $a = new Area('Homepage Content'); $a->display($c); ?>
					</div>
				</div>
				<div class="span2"></div>
				<!-- <div class="span12 clearfix">
					<div class="clearfix" style="position:relative;z-index:5;min-height:20px;width:100%;">
						
					</div>
				</div> -->
			</div>
		</div>
	</div>
	
	<?php Loader::packageElement('theme_footer', 'clinica', array('c' => $c)); ?>
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>