<div class="container-fluid" style="padding:0;">
	<div class="row-fluid">
		<div class="span3">
			<div class="well" style="padding:8px 0;">
				<ul id="providerTypeList" class="nav nav-list serifFont">
					<li class="<?php echo !isset($providerHandle) ? 'active' : ''; ?>"><a href="<?php echo $this->url('providers'); ?>">Alphabetical</a></li>
					<li class="nav-header">By Location</li>
					<li class="<?php echo ($providerHandle == ClinicaPersonnel::PROVIDER_FEDERAL_HEIGHTS) ? 'active' : ''; ?>"><a href="<?php echo $this->action('location', ClinicaPersonnel::PROVIDER_FEDERAL_HEIGHTS); ?>">Federal Heights</a></li>
					<li class="<?php echo ($providerHandle == ClinicaPersonnel::PROVIDER_LAFAYETTE) ? 'active' : ''; ?>"><a href="<?php echo $this->action('location', ClinicaPersonnel::PROVIDER_LAFAYETTE); ?>">Lafayette</a></li>
					<li class="<?php echo ($providerHandle == ClinicaPersonnel::PROVIDER_PECOS) ? 'active' : ''; ?>"><a href="<?php echo $this->action('location', ClinicaPersonnel::PROVIDER_PECOS); ?>">Pecos</a></li>
					<li class="<?php echo ($providerHandle == ClinicaPersonnel::PROVIDER_PEOPLES) ? 'active' : ''; ?>"><a href="<?php echo $this->action('location', ClinicaPersonnel::PROVIDER_PEOPLES); ?>">People's</a></li>
					<li class="<?php echo ($providerHandle == ClinicaPersonnel::PROVIDER_THORNTON) ? 'active' : ''; ?>"><a href="<?php echo $this->action('location', ClinicaPersonnel::PROVIDER_THORNTON); ?>">Thornton</a></li>
					<li class="divider"></li>
					<li class="nav-header">Dental Providers</li>
					<li class="<?php echo ($providerHandle == ClinicaPersonnel::PROVIDER_PECOS_DENTAL) ? 'active' : ''; ?>"><a href="<?php echo $this->action('location', ClinicaPersonnel::PROVIDER_PECOS_DENTAL); ?>">Pecos</a></li>
					<li class="<?php echo ($providerHandle == ClinicaPersonnel::PROVIDER_THORNTON_DENTAL) ? 'active' : ''; ?>"><a href="<?php echo $this->action('location', ClinicaPersonnel::PROVIDER_THORNTON_DENTAL); ?>">Thornton</a></li>
				</ul>
			</div>
			<?php $a = new Area('Providers Sidebar'); $a->display($c); ?>
		</div>
		<div class="span9">
			<?php if($this->controller->getTask() == 'profile'): ?>
				
				<?php if($personnelObj->getPersonnelID() >= 1): ?>
				    <div class="row-fluid provider profile">
                        <div class="span3">
                            <?php if( $personnelObj->getPictureFileObj()->getFileID() >= 1 ): ?>
                                <img class="thumbnail" src="<?php echo $image->getThumbnail($personnelObj->getPictureFileObj(), 200, 300, true)->src; ?>" />
                            <?php else: ?>
                                <span class="thumbnail placeholder">Photo Unavailable</span>
                            <?php endif; ?>
                        </div>
                        <div class="span9">
                            <h3 style="margin-top:0;"><?php echo "{$personnelObj->getFirstName()} {$personnelObj->getLastName()}"; ?> <small><?php echo $personnelObj->getTitle(); ?></small></h3>
                            <p><strong>Location:</strong> <?php echo $personnelObj->getProviderLocations(true); ?></p>
                            <?php echo $personnelObj->getDescription(); ?>
                        </div>
                    </div>
				<?php else: ?>
					<div class="alert alert-danger"><h5>Provider cannot be found.</h5></div>
				<?php endif; ?>
				
			<?php else: ?>
				
				<div class="clearfix">
					<h2 class="pull-left">Our Providers <small id="providerTypeLabel"></small></h2>
					<div class="pull-right">
						<input id="providerFilter" type="text" value="" style="margin-top:10px;" placeholder="Search by name" />
					</div>
				</div>
				<div id="providersList" class="row-fluid">
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
		var $providersList 	= $('#providersList'),
			$providers 		= $('a.provider', $providersList);
		
		// search filter
		$('#providerFilter').on('keyup', function(){
			var _str = this.value.toLowerCase();
			if( _str.length ){
				$providersList.addClass('applyFilter');
			}else{
				$providersList.removeClass('applyFilter');
			}
			$providers.each(function(idx, element){
				var $item = $(element);
				$item.toggle( $item.attr('data-name').toLowerCase().indexOf(_str) !== -1 );
			});
		});
	});
</script>
