<div id="cHeader">
	<div id="headerInner">
		<?php
			$bt = BlockType::getByHandle('autonav');
			$bt->controller->orderBy 					= 'display_asc';
			$bt->controller->displayPages 				= 'top';
			$bt->controller->displaySubPages 			= 'none';
			$bt->controller->displaySubPageLevels 		= 'enough';
			$bt->render('templates/header_navigation');
		?>
		<div class="orangeBar">
			<div class="pull-left">
				<a class="active">English</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a>Espanol</a>
			</div>
			<div class="pull-right">
				(303) 650-4460
			</div>
		</div>
	</div>
	<!--<div class="container">
		<div class="row">
			<div class="span12">
				<div class="well">
					<ul class="nav nav-pills">
						<li>About</li>
						<li>Innovations</li>
						<li>Patient Info.</li>
						<li>Giving/Volunteering</li>
						<li>Locations</li>
						<li>Contact</li>
					</ul>
				</div>
			</div>
		</div>
	</div>-->
	
</div>