<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='//fonts.googleapis.com/css?family=Quicksand:400,700' rel='stylesheet' type='text/css' />
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'clinica'); ?>
</head>

<!-- Enjoy checking out what's under the hood? We should talk! www.focus-43.com -->

<body class="clinicaPage home">
		<div id="minHeighter">
		<div class="imageOverlay"></div>
		<div id="bgContainer" class="hidden-phone" data-background="<?php echo $backgroundImage; ?>"></div>

		
		<?php Loader::packageElement('theme_header', 'clinica'); ?>
		
		<div class="container">
			<div class="row">
			<div class="span8 centered-span">
				<div class="row homeRow">
					<div class="mainCall">
	    			<h2 style="text-align: center;">Welcome</h2>
						<p>Here is a welcome message we wanted to share with you about the goings on at Clinica currently. Don't forget to check some things and be sure to do some other stuff too. It's gonna be great!</p>
						<?php
						//test
						 // $a = new Area('Homepage Content');
						 // $a->display($c); 
						?>
					</div>
				</div>
				<!-- begin homeblock -->
				<div class="row blockRow">
					<div class="span3 flex">
						<a href="#">
							<div class="homeBlock">
								<i class="fa fa-group"></i>
								<h3>Work at Clinica</h3>
							</div>
						</a>
					</div>
					<div class="span3 flex">
						<a href="#">
							<div class="homeBlock">
								<i class="fa fa-money"></i>
								<h3>Paying Your Bill</h3>
							</div>
						</a>
					</div>
					<div class="span3 flex">
						<a href="#">
							<div class="homeBlock myConnection">
								
								<h3>My CLINICA Connection</h3>
							</div>
						</a>
					</div>
					<div class="span3 flex">
						<a href="#">
							<div class="homeBlock">
								<i class="fa fa-sign-in"></i>
								<h3>Employee Login</h3>
							</div>
						</a>
					</div>
				</div>
				<!-- end homeblock -->
				</div>
			</div>
		</div>
	</div>
	
	<?php Loader::packageElement('theme_footer', 'clinica', array('c' => $c)); ?>
    
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>