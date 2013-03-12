<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Transaction Details'), t('View transaction details.'), false, false ); ?>
	
	<div id="ctManager">
		<div class="ccm-pane-body">
			<div class="clearfix">
				<h3 class="lead pull-left"><?php echo Loader::helper('text')->unhandle($transactionObj->getTypeHandle()) . ' amount $' . number_format($transactionObj->getAmount(), 2); ?></h3>
				<div class="pull-right">
					Made <span class="badge badge-info"><?php echo date('M d, Y', strtotime($transactionObj->getDateCreated())); ?></span>
					&nbsp; Card <span class="badge badge-success">**** <?php echo $transactionObj->getCardLastFour(); ?>, <?php echo $transactionObj->getCardExpMonth(); ?>/<?php echo $transactionObj->getCardExpYear(); ?></span>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<p>Message from sender</p>
					<blockquote>
						<?php echo $transactionObj->getMessage() != '' ? $transactionObj->getMessage() : '<i>Empty</i>'; ?>
					</blockquote>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<h4>Contact Information</h4>
					<table class="table table-bordered table-condensed trxn-details">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Address</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $transactionObj->getFirstName(); ?> <?php echo $transactionObj->getMiddleInitial(); ?> <?php echo $transactionObj->getLastName(); ?></td>
								<td><a class="helpTooltip" title="Send an email" href="mailto:<?php echo $transactionObj->getEmail(); ?>"><?php echo $transactionObj->getEmail(); ?></a></td>
								<td><?php echo $transactionObj->getPhone(); ?></td>
								<td>
									<?php echo $transactionObj->getAddress1(); ?> <?php echo $transactionObj->getAddress2(); ?> <?php echo $transactionObj->getCity(); ?>, <?php echo $transactionObj->getState(); ?> <?php echo $transactionObj->getZip(); ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<h4>Transaction Information (Authorize.Net)</h4>
					<table class="table table-bordered trxn-details">
						<thead>
							<tr>
								<th>Auth Code</th>
								<th>AVS Response</th>
								<th>Transaction ID</th>
								<th>Method</th>
								<th>Type</th>
								<th>MD5 Hash</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $transactionObj->getAuthNetAuthorizationCode(); ?></td>
								<td><?php echo $transactionObj->getAuthNetAvsResponse(); ?></td>
								<td><?php echo $transactionObj->getAuthNetTransactionID(); ?></td>
								<td><?php echo $transactionObj->getAuthNetMethod(); ?></td>
								<td><?php echo $transactionObj->getAuthNetTransactionType(); ?></td>
								<td><?php echo $transactionObj->getAuthNetMd5Hash(); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="ccm-pane-footer"></div>
	</div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>