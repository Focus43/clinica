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
				
		<!--<div id="clinicaWelcome" class="container">			
			<div class="row">
				<div class="span4">
					<?php $area2 = new Area('Editable Area 1'); $area2->setCustomTemplate('image', 'templates/align_center.php'); $area2->display($c); ?>
				</div>
				<div class="span4">
					<?php $area3 = new Area('Editable Area 2'); $area3->setCustomTemplate('image', 'templates/align_center.php'); $area3->display($c); ?>
				</div>
				<div class="span4" style="margin-bottom:130px;">
					<?php $area4 = new Area('Editable Area 3'); $area4->setCustomTemplate('image', 'templates/align_center.php'); $area4->display($c); ?>
				</div>
			</div>
		</div>-->
		
		<div style="position:absolute;left:0;bottom:0;right:0;">
			<div style="position:relative;">
				<div id="tagLiner" class="serifFont">
					<div class="container">
						<div class="row">
							<div class="span12">
								<?php $area = new Area('Tag Line'); $area->display($c); ?>
							</div>
						</div>
					</div>
				</div>
				<?php Loader::packageElement('theme_footer', 'clinica'); ?>
			</div>
		</div>
	</div>
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>