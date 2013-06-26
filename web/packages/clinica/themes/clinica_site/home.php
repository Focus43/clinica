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
		<div id="bgContainer" class="hidden-phone" data-background="<?php echo $backgroundImage; ?>"></div>
		
		<?php Loader::packageElement('theme_header', 'clinica'); ?>
		
		<div class="container">
			<div class="row">
				<div class="span12 clearfix">
					<div class="clearfix" style="position:relative;z-index:5;min-height:20px;width:100%;">
						<div id="homeContent">
						    <?php $a = new Area('Homepage Content'); $a->display($c); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="tagLiner">
			<div class="tagLinerContent serifFont">
				<div class="container">
					<div class="row">
						<div class="span12">
							<?php $area2 = new Area('Tag Line'); $area2->setBlockLimit(1); $area2->display($c); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php Loader::packageElement('theme_footer', 'clinica', array('c' => $c)); ?>
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>