<div class="container">
	<div class="row">
		<div class="span12">
			<div id="flexHeader">
				<div class="main clearfix">
					<!--<a href="<?php echo $this->url(''); ?>">
						<img src="<?php echo CLINICA_IMAGES_URL; ?>logo_header.png" alt="Clinica Family Health Services Logo" />
					</a>-->
					<a id="clinicaLogo" href="<?php echo $this->url(''); ?>">
					    <img src="<?php echo CLINICA_IMAGES_URL; ?>logo_transparent.png" />
					</a>
					
					<!-- responsive "show on tablets/phones" -->
					<a id="responsiveTrigger" class="btn btn-navbar pull-right hidden-desktop hidden-tablet" data-toggle="collapse" data-target=".nav-collapse">
				        Navigation
				    </a>
					<div class="nav-collapse collapse pull-right">
						<?php
							$bt = BlockType::getByHandle('autonav');
							$bt->controller->orderBy 					= 'display_asc';
							$bt->controller->displayPages 				= 'top';
							$bt->controller->displaySubPages 			= 'none';
							$bt->controller->displaySubPageLevels 		= 'enough';
							$bt->render('templates/clinica_header');
						?>
					</div>
				</div>
				<div class="sub clearfix hidden-phone">
					<div class="pull-left">
						<!--<a class="active">English</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a>Espa&ntilde;ol</a>-->
					</div>
					<div class="pull-right">
						<?php $a = new GlobalArea('Header Orange Bar Right'); $a->display($c); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
