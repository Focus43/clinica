<div class="row-fluid">
	
	<div class="span5">
		<h3>Support Clinica!</h3>
		<?php $area = new Area('Giving Page Content'); $area->display($c); ?>
	</div>
	
	<div class="span7">
		<form method="post" data-method="ajax" action="<?php echo $this->controller->secureAction('process'); ?>">
			<h3>Donation Form</h3>
			<div class="well">
				
				<?php Loader::packageElement('flash_message', 'clinica', array('flash' => $flash)); ?>
				
				<?php Loader::packageElement('payment_form/personal_info', 'clinica', array('form' => $form)); ?>
				
				<?php Loader::packageElement('payment_form/credit_card', 'clinica', array('form' => $form)); ?>
				
				<h4>Donation Amount</h4>
				<div class="controls controls-row poptip" data-placement="left" title="Donation Amount" data-content="On behalf of everyone at Clinica, and all the people we serve - thank you!">
					<div class="input-prepend input-append">
						<span class="add-on">$</span>
						<?php echo $form->text('amount'); ?>
						<span class="add-on">.00</span>
					</div>
				</div>
				
				<h4>Other</h4>
				<div class="controls">
					<?php
						$attrs = AttributeSet::getByHandle(ClinicaTransaction::TYPE_DONATION)->getAttributeKeys();
						foreach($attrs AS $akObj){ /** @var $akObj AttributeKey */
							echo '<label>'.$akObj->getAttributeKeyName().'</label>';
							echo $akObj->render('form');
						}
					?>
					<?php echo $form->textarea('message', '', array('class'=>'input-block-level','placeholder'=>'Message')); ?>
				</div>
				
				<button class="btn btn-block btn-primary btn-large">Submit Donation!</button>
			</div>
		</form>
	</div>
</div>


