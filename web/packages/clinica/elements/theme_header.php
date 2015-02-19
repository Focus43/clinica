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
                        <span style="display:inline-block;padding-top:2px;">Language:&nbsp;&nbsp;</span>
                        <span style="display:inline-block;">
                            <div id="google_translate_element"></div>
                            <?php if( ! Page::getCurrentPage()->isEditMode() ): ?>
                            <script type="text/javascript">
                                function googleTranslateElementInit() {
                                    new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
                                }
                            </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                            <?php endif; ?>
                        </span>
                    </div>
					<div class="pull-right">
						<?php $a = new GlobalArea('Header Orange Bar Right'); $a->display($c); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
