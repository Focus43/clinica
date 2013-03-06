<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Enriqueta:400,700' rel='stylesheet' type='text/css'>
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
</head>

<body data-background="<?php echo $backgroundImage; ?>">
	
	<div id="minHeighter">
		<?php Loader::packageElement('theme_header', 'clinica'); ?>
				
		<div id="clinicaWelcome" class="container">
			<div class="row visible-desktop">
				<div class="abstract heavy blue">
					<?php $area = new Area('Tag Line'); $area->display($c); ?>
				</div>
			</div>
			<div class="row">
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
	
	<div class="homeBody">
		<div class="section">
			<div class="inner">
				<div class="container">
					<div class="row">
						<div class="span12">
							<?php $a = new Area('Main Content 1'); $a->display($c); ?>
						</div>
					</div>
					<div class="row">
						<div class="abstract orange">
							<?php $area = new Area('Abstract Text'); $area->display($c); ?>
						</div>
					</div>
				</div>				
			</div>
		</div>
		<div class="section paper">
			<div class="inner">
				<div class="container">
					<div class="row">
						<div class="span12">
							<?php $a = new Area('Main Content 2'); $a->display($c); ?>
						</div>
					</div>
					<!--<div class="row">
						<div class="abstract orange">
							<?php $area = new Area('Abstract Text 2'); $area->display($c); ?>
						</div>
					</div>-->
				</div>				
			</div>
		</div>
		<div class="section grid">
			<div class="inner">
				<div class="container">
					<div class="row">
						<div class="span12">
							<?php $a = new Area('Main Content 3'); $a->display($c); ?>
						</div>
					</div>
					<div class="row">
						<div class="abstract orange">
							<?php $area = new Area('Abstract Text 3'); $area->display($c); ?>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>