<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='//fonts.googleapis.com/css?family=Enriqueta:400,700' rel='stylesheet' type='text/css' />
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'clinica'); ?>
</head>

<body class="missGreek">
	
	<div class="container whiteBack">
	    <div class="row">
	        <div class="span12">
	            <div id="cHeader">
                    <a>
                        <img src="<?php echo CLINICA_IMAGES_URL; ?>miss_greek_logo.png" alt="CU Miss Greek" />
                    </a>
                </div>
	        </div>
	    </div>
	    <div class="row">
	        <div class="span12">
	            <div id="superShowWrap">
	                <div id="superShow">
                        <div class="inner" style="left:-40%;">
                            <div class="item" data-background="<?php echo CLINICA_IMAGES_URL ?>flatirons.jpg">
                                
                            </div>
                            <div class="item" data-background="<?php echo CLINICA_IMAGES_URL ?>flatirons2.jpg">
                                
                            </div>
                            <div class="item active" data-background="<?php echo CLINICA_IMAGES_URL ?>flatirons.jpg">
                                
                            </div>
                            <div class="item" data-background="<?php echo CLINICA_IMAGES_URL ?>flatirons2.jpg">
                                
                            </div>
                            <div class="item" data-background="<?php echo CLINICA_IMAGES_URL ?>flatirons.jpg">
                                
                            </div>
                        </div>
                    </div>
	            </div>
	        </div>
	    </div>
	    <div class="row">
	        <div class="span12">
	            <?php for($i = 0; $i <= 100; $i++): ?>
	               <p>asdfioweioewr arewer wer wer </p>
	            <?php endfor; ?>
	        </div>
	    </div>
	</div>
	
	
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>