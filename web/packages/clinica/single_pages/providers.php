<div class="container-fluid" style="padding:0;">
	<div class="row-fluid">
		<div class="span3">
			<div class="well" style="padding:8px 0;">
				<ul class="nav nav-list serifFont">
					<li><a>Alphabetical</a></li>
					<li class="nav-header">By Location</li>
					<li><a>Federal Heights</a></li>
					<li><a>Lafayette</a></li>
					<li><a>Pecos</a></li>
					<li><a>People's</a></li>
					<li><a>Thornton</a></li>
					<li class="divider"></li>
					<li><a>Dental</a></li>
				</ul>
			</div>
		</div>
		<div class="span9">
			<?php if($this->controller->getTask() == 'profile'): ?>
				
				<div class="provider profile clearfix">
					<?php if( $personnelObj->getPictureFileObj()->getFileID() >= 1 ): ?>
						<img class="thumbnail pull-left" src="<?php echo $image->getThumbnail($personnelObj->getPictureFileObj(), 200, 300, true)->src; ?>" />
					<?php else: ?>
						<span class="thumbnail placeholder pull-left">Photo Unavailable</span>
					<?php endif; ?>
					<h3 style="margin-top:0;"><?php echo "{$personnelObj->getFirstName()} {$personnelObj->getLastName()}"; ?> <small><?php echo $personnelObj->getTitle(); ?></small></h3>
					<p>Location: <?php echo $personnelObj->getProviderHandle(true); ?></p>
					<?php echo $personnelObj->getDescription(); ?>
				</div>
				
			<?php else: ?>
				<?php// $a = new Area('Main Content'); $a->display($c); ?>
				<div class="clearfix">
					<h2 class="pull-left">Our Providers (Alphabetical)</h2>
					<div class="pull-right">
						<input id="providerFilter" type="text" value="" style="margin-top:10px;" placeholder="Search by provider name" />
					</div>
				</div>
				<div id="providersList" class="row-fluid" style="margin-top:1em;">
					<div class="span6">
						<?php foreach($listColumn1 AS $personnelObj): ?>
							<?php Loader::packageElement('partials/provider_quickview', 'clinica', array('personnelObj' => $personnelObj, 'image' => $image)); ?>
						<?php endforeach; ?>
					</div>
					<div class="span6">
						<?php foreach($listColumn2 AS $personnelObj): ?>
							<?php Loader::packageElement('partials/provider_quickview', 'clinica', array('personnelObj' => $personnelObj, 'image' => $image)); ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		var $providers = $('a.provider', '#providersList');
		
		$('#providerFilter').on('keyup', function(){
			var _str = this.value.toLowerCase();
			$providers.each(function(idx, element){
				var $item = $(element);
				$item.toggle( $item.attr('data-name').toLowerCase().indexOf(_str) !== -1 );
			});
		});
	});
</script>
