<div class="container">
	<div class="row">
		<div class="span12">
			<div id="flexHeader">
				<div class="main clearfix">
					<img src="<?php echo CLINICA_IMAGES_URL; ?>logo_header.png" alt="Clinica Family Health Services Logo" />
					
					<!-- responsive "show on tablets/phones" -->
					<a id="responsiveTrigger" class="btn pull-right hidden-desktop" data-toggle="collapse" data-target=".nav-collapse">
				        Navigation
				    </a>
					<div class="nav-collapse collapse pull-right">
						<?php
							$bt = BlockType::getByHandle('autonav');
							$bt->controller->orderBy 					= 'display_asc';
							$bt->controller->displayPages 				= 'top';
							$bt->controller->displaySubPages 			= 'none';
							$bt->controller->displaySubPageLevels 		= 'enough';
							$bt->render('templates/header_navigation');
						?>
					</div>
				</div>
				<div class="sub clearfix">
					<div class="pull-left">
						<a class="active">English</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a>Espanol</a>
					</div>
					<div class="pull-right">
						(303) 650-4460
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
