<?php Loader::packageElement('flash_message', 'clinica', array('flash' => $flash)); ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Clinica Transaction Search'), t('View e-commerce transactions conducted on clinica.org.'), false, false ); ?>
	
	<div id="ctManager">
		<div class="ccm-pane-options">
			<?php Loader::packageElement('dashboard/search_form_advanced', 'clinica', array('columns' => $columns, 'searchInstance' => $searchInstance, 'searchRequest' => $searchRequest)); ?>
		</div>
		
		<div class="ccm-pane-body">
			<table id="transactionList" border="0" cellspacing="0" cellpadding="0" class="ccm-results-list">
				<thead>
					<tr>
						<th><input id="checkAllBoxes" type="checkbox" /></th>
						<th>Domain</th>
						<th>Root Page</th>
						<th>Resolve Wildcard Subdomains</th>
						<th>Match Wildcards Under</th>
					</tr>
				</thead>
				<tbody>
					<?php //print_r($listResults); ?>
					<?php /*foreach($domainsList AS $domainObj): ?>
						<tr>
							<td><?php echo $form->checkbox('domainID[]', $domainObj->getID()); ?></td>
							<td><a href="<?php echo $this->action('edit', $domainObj->getID()) ?>"><?php echo $domainObj->getDomain(); ?></a></td>
							<td class="helpTooltip" title="<?php echo $domainObj->getPath(); ?>"><?php echo Page::getByID( $domainObj->getPageID() )->getCollectionName(); ?></td>
							<td><?php echo (bool) $domainObj->getResolveWildcards() ? 'Yes' : 'No'; ?></td>
							<td class="helpTooltip" title="<?php echo $domainObj->getWildcardRootPath(); ?>"><?php echo Page::getByID( $domainObj->getWildcardParentID() )->getCollectionName(); ?></td>
						</tr>
					<?php endforeach;*/ ?>
				</tbody>
			</table>
		</div>		
	</div>
	
	<div class="ccm-pane-footer"></div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>