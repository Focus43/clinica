<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='//fonts.googleapis.com/css?family=Enriqueta:400,700' rel='stylesheet' type='text/css' />
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'clinica'); ?>
</head>

<!-- Enjoy checking out what's under the hood? We should talk! www.focus-43.com -->

<body class="clinicaPage default">
	<a id="onlineBillPay" href="<?php echo $this->url('bill_pay'); ?>" title="Online Bill Pay"></a>
	
	<div id="minHeighter">
		<?php Loader::packageElement('theme_header', 'clinica'); ?>
		<div class="container">
			<div class="row hidden-phone">
				<div class="span12">
					<h1><?php echo Page::getCurrentPage()->getCollectionName(); ?> <small class="visible-desktop"><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></small></h1>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<div id="cPrimary">
						<?php
							$bt = BlockType::getByHandle('autonav');
							$bt->controller->orderBy 					= 'display_asc';
							$bt->controller->displayPages 				= 'top';
							$bt->controller->displaySubPages 			= 'relevant_breadcrumb';
							$bt->controller->displaySubPageLevels 		= 'all';
							$bt->render('templates/clinica_breadcrumb');
						?>
						
						<div class="container-fluid" style="padding:0;">
							<div class="row-fluid">
								<div class="span3">
									<?php
										$bt = BlockType::getByHandle('autonav');
										$bt->controller->orderBy 					= 'display_asc';
										$bt->controller->displayPages 				= 'second_level';
										$bt->controller->displaySubPages 			= 'none';
										$bt->controller->displaySubPageLevels 		= 'enough';
										$bt->render('templates/clinica_sidebar');
									?>
									<?php $a = new Area('Sidebar Content'); $a->display($c); ?>
								</div>
								<div class="span9">
									<?php $a = new Area('Main Content'); $a->display($c); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="pushFooter"></div>
	</div>
	
	<?php Loader::packageElement('theme_footer', 'clinica'); ?>
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>