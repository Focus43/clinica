<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<link href='http://fonts.googleapis.com/css?family=Enriqueta:400,700' rel='stylesheet' type='text/css'>
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
</head>

<body>
	
	<div id="homeWrap" data-background="<?php echo $backgroundImage; ?>">
		<div class="homeInner">
			
			<div class="forceHeight">
				<?php Loader::packageElement('theme_header', 'clinica'); ?>
				
				<div class="container visible-desktop">
					<div class="row">
						<div class="span12" style="text-align:center;">
							<img src="<?php echo CLINICA_IMAGES_URL; ?>tagline.png" />
						</div>
					</div>
				</div>
				
				<div id="homeMain" class="container">
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
			
			<div class="pageContent">
				<div class="container">
					<div class="row">
						<div class="span3">
							<?php $a = new Area('Footer Editable Area 1'); $a->display($c); ?>
						</div>
						<div class="span3">
							<?php $a = new Area('Footer Editable Area 2'); $a->display($c); ?>
						</div>
						<div class="span3">
							<?php $a = new Area('Footer Editable Area 3'); $a->display($c); ?>
						</div>
						<div class="span3">
							<?php $a = new Area('Footer Editable Area 4'); $a->display($c); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>