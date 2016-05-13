<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='//fonts.googleapis.com/css?family=Quicksand:400,700' rel='stylesheet' type='text/css' />
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'clinica'); ?>
    <?php 
    	function getTheURL($url_id) {
		   $opg = Page::getById($url_id);
		   $url=Loader::helper('navigation'); 
		   $canonical=$url->getCollectionURL($opg); 
		   $canonical=preg_replace("/index.php\?cID=1$/","",$canonical); 
		   echo $canonical;
		}
    ?>
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
						<?php
						//test
						 $a = new Area('Homepage Content');
						 $a->display($c); 
						?>
					</div>
				</div>
				<!-- begin homeblock -->
				<div class="row blockRow">
					<div class="span3 flex">
						<a href="<?php getTheURL(821); ?>">
							<div class="homeBlock">
								<i class="fa fa-user-plus"></i>
								<h3>Work at Clinica</h3>
							</div>
						</a>
					</div>
					<div class="span3 flex">
						<a href="<?php getTheURL(617); ?>">
							<div class="homeBlock">
								<i class="fa fa-money"></i>
								<h3>Paying Your Bill</h3>
							</div>
						</a>
					</div>
					<div class="span3 flex">
						<a target="_blank" href="https://www.nextmd.com/index.aspx?link=clinicafamilyhealth">
							<div class="homeBlock myConnection">
								<h3>My CLINICA Connection</h3>
							</div>
						</a>
					</div>
					<div class="span3 flex">
						<a target="_blank" href="https://external.clinica.org/">
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