<?php defined('C5_EXECUTE') or die("Access Denied.");
header('Content-Type: text/css'); 
header('X-Content-Type-Options: nosniff');
?>

#flexHeader,
#flexHeader,
#flexHeader div.main,
#flexHeader div.main,
#flexHeader div.sub,
#clinicaWelcome .span4 img {
	behavior: url('<?php echo CLINICA_TOOLS_URL; ?>css3pie');
}

.mdnzr-no-rgba #flexHeader div.sub {
	background:transparent url('<?php echo CLINICA_IMAGES_URL; ?>opaque_orange.png');
}
