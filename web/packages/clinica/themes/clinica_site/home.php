<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='//fonts.googleapis.com/css?family=Enriqueta:400,700' rel='stylesheet' type='text/css' />
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'clinica'); ?>
</head>

<!-- Enjoy checking out what's under the hood? We should talk! www.focus-43.com -->

<body id="pageTopTarget" class="clinicaPage" data-background="<?php echo $backgroundImage; ?>">
	<a id="scrollTopTrigger" class="serifFont" href="#pageTopTarget">Back To Top <i class="icon-arrow-up icon-white"></i></a>
	
	<div id="minHeighter">
		<?php Loader::packageElement('theme_header', 'clinica'); ?>
				
		<div id="tagLiner" class="serifFont">
			<div class="container">
				<div class="row">
					<div class="span12">
						<?php $area = new Area('Tag Line'); $area->display($c); ?>
					</div>
				</div>
			</div>
		</div>
				
		<div id="clinicaWelcome" class="container">			
			<div class="row" style="margin-bottom:20px;">
				<div class="span4">
					<?php $area2 = new Area('Editable Area 1'); $area2->setCustomTemplate('image', 'templates/align_center.php'); $area2->display($c); ?>
				</div>
				<div class="span4">
					<?php $area3 = new Area('Editable Area 2'); $area3->setCustomTemplate('image', 'templates/align_center.php'); $area3->display($c); ?>
				</div>
				<div class="span4">
					<?php $area4 = new Area('Editable Area 3'); $area4->setCustomTemplate('image', 'templates/align_center.php'); $area4->display($c); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div id="homeBody">
		<div class="section paper">
			<div class="inner">
				<div class="container">
					<div class="row">
						<div class="span12">
							<?php $a = new Area('Main Content 1'); $a->display($c); ?>
						</div>
					</div>
					<div class="row visible-desktop">
						<div class="abstract orange">
							<?php $area = new Area('Abstract Text'); $area->display($c); ?>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<?php Loader::packageElement('theme_footer', 'clinica'); ?>
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>