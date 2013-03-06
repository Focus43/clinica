<?php  defined('C5_EXECUTE') or die(_("Access Denied."));
$navItems = $controller->getNavItems();
?>

<ul class="breadcrumb">
	<li><a href="<?php echo $this->url(''); ?>">Clinica Home</a> <span class="divider">/</span></li>
	<?php foreach( $navItems AS $page ):
		if( $page->isCurrent ){ ?>
			<li class="active"><?php echo $page->name; ?></li>
		<?php }else{ ?>
			<li><a href="<?php echo $page->url; ?>"><?php echo $page->name; ?></a> <span class="divider">/</span></li>
		<?php }
	endforeach; ?>
</ul>
