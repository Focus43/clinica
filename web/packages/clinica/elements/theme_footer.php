<div id="cFooter">
	<div class="container content">
		<div class="row">
			<div class="span8">
				<div class="container-fluid" style="padding:0;">
					<div class="row-fluid">
						<div class="span4">
							<?php $a = new GlobalArea('Footer Area 1'); $a->display($c); ?>
							<!--<h4>Visiting Clinica</h4>
							<ul class="unstyled">
								<li><a>Link 1</a></li>
								<li><a>Link 2 Here</a></li>
							</ul>-->
						</div>
						<div class="span4">
							<?php $a = new GlobalArea('Footer Area 2'); $a->display($c); ?>
							<!--<h4>Get Involved</h4>
							<ul class="unstyled">
								<li><a>Volunteer With Clinica</a></li>
								<li><a>Donations</a></li>
							</ul>-->
						</div>
						<div class="span4">
							<?php $a = new GlobalArea('Footer Area 3'); $a->display($c); ?>
							<!--<h4>Something Else</h4>
							<ul class="unstyled">
								<li><a>Link 1</a></li>
								<li><a>Link 2 Here</a></li>
							</ul>-->
						</div>
					</div>
				</div>
			</div>
			<div class="span4">
				<?php $a = new GlobalArea('Footer Area 4'); $a->display($c); ?>
				<!--<h4>Contact Us</h4>
				<ul class="unstyled">
					<li>1345 Plaza Court North, 1A, Lafayette, CO 80026</li>
					<li>Patient Services: (303) 123-4567</li>
				</ul>-->
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
						<a>Terms of Use</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a>Privacy Policy</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a>Security Policy</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
