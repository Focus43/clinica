<div id="cFooter">
	<div class="container content">
		<div class="row">
		    <div class="span3">
                <?php $a = new GlobalArea('Footer Area 1'); $a->display($c); ?>
            </div>
            <div class="span3">
                <?php $a = new GlobalArea('Footer Area 2'); $a->display($c); ?>
            </div>
            <div class="span3">
                <?php $a = new GlobalArea('Footer Area 3'); $a->display($c); ?>
            </div>
            <div class="span3">
                <?php $a = new GlobalArea('Footer Area 4'); $a->display($c); ?>
            </div>
		</div>
	</div>
	
	<div class="legaleze">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="pull-left">
						Copyright &copy; <?php echo date('Y'); ?> Clinica Family Health Services. <span class="hidden-phone">All Rights Reserved.</span>
					</div>
					<div class="pull-right">
						<!--<a>Terms of Use</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a>Privacy Policy</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a>Security Policy</a>-->
                        <a href="https://www.facebook.com/pages/Clinica-Family-Health-Services/114217321986190" target="_blank"><img src="<?php echo CLINICA_IMAGES_URL; ?>ico_facebook.png" alt="Facebook" style="max-height:18px;" /></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
