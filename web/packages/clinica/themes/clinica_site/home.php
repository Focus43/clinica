<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='//fonts.googleapis.com/css?family=Enriqueta:400,700' rel='stylesheet' type='text/css' />
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'clinica'); ?>
</head>

<!-- Enjoy checking out what's under the hood? We should talk! www.focus-43.com -->

<body class="clinicaPage home">
	
	<div id="minHeighter">
		<div id="bgContainer" data-background="<?php echo $backgroundImage; ?>"></div>
		
		<?php Loader::packageElement('theme_header', 'clinica'); ?>
		
		<div class="container">
			<div class="row">
				<div class="span12 clearfix">
					<div style="position:relative;z-index:5;min-height:20px;width:100%;">
						<?php// $a = new Area('Homepage Content'); $a->display($c); ?>
						<div id="homeContent">
						    <?php $a = new Area('Homepage Content'); $a->display($c); ?>
						</div>
					</div>
					<!--<div id="homeContent">
						<?php $area1 = new Area('Editable Area 1'); $area1->setCustomTemplate('image', 'templates/align_center.php'); $area1->display($c); ?>
						<p class="centerize" style="margin-top:1.4em;">
							<a class="btn btn-large btn-info" href="<?php echo $this->url('/about'); ?>">Learn More About Clinica</a>
						</p>
					</div>-->
				</div>
			</div>
		</div>
		
		<div style="position:absolute;left:0;bottom:0;right:0;">
			<div style="position:relative;">
				<div id="tagLiner" class="serifFont">
					<div class="container">
						<div class="row">
							<div class="span12" style="color:#222;text-shadow:0 1px rgba(255,255,255,.55);">
								<?php $area2 = new Area('Tag Line'); $area2->setBlockLimit(1); $area2->display($c); ?>
							</div>
						</div>
					</div>
				</div>
				<?php// Loader::packageElement('theme_footer', 'clinica', array('c' => $c)); ?>
			</div>
		</div>
	</div>
	
	<?php Loader::packageElement('theme_footer', 'clinica', array('c' => $c)); ?>
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>