<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
</head>

<body>
	
	<div id="homeWrap" data-background="<?php echo $backgroundImage; ?>">
		<div class="homeInner">
			
			<div class="forceHeight">
				<?php Loader::packageElement('theme_header', 'clinica'); ?>
			
				<div id="welcomeText" class="visible-desktop">
					<div class="container">
						<div class="row">
							<div class="span12">
								<div class="lead">
									<?php $area1 = new Area('Tag Line'); $area1->display($c); ?>
								</div>
							</div>
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
						<div class="span12">
							<div class="well">
								some content!
							</div>
						</div>
					</div>
					<?php for($i = 0; $i <= 10; $i++): ?>
					<div class="row">
						<div class="span3">
							<ul class="unstyled">
								<li>About Clinica</li>
								<li><a>First</a></li>
								<li><a>Seconds</a></li>
								<li><a>Thirds</a></li>
								<li><a>Fourths</a></li>
							</ul>
						</div>
					</div>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</div>
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>