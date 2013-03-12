<div class="row-fluid">
	<div class="span6">
		<h3>Support Clinica!</h3>
		<p>Your financial support is invaluable.</p>
	</div>
	<div class="span6">
		<form method="post" data-method="ajax" action="<?php echo $this->controller->secureAction('process'); ?>">
			<h3>Donation Form</h3>
			<div class="well">
				
				<?php Loader::packageElement('flash_message', 'clinica', array('flash' => $flash)); ?>
				
				<h4>Your Information <small>Must match credit card entered below</small></h4>
				<div class="controls poptip" title="Email Address" data-placement="left" data-content="Your donation receipt will be emailed to this address, and is used for nothing else.">
					<input class="span12" type="text" placeholder="Email Address" />
				</div>
				<div class="poptip" title="Name &amp; Address" data-placement="left" data-content="The following information will be used when processing your credit card. Please make sure it matches the card being used.">
					<div class="controls controls-row">
						<?php echo $form->text('firstName', '', array('class'=>'span5','placeholder'=>'First Name')); ?>
						<?php echo $form->text('middleInitial', '', array('class'=>'span2','placeholder'=>'M.I.')); ?>
						<?php echo $form->text('lastName', '', array('class'=>'span5','placeholder'=>'Last Name')); ?>
					</div>
					<div class="controls">
						<?php echo $form->text('address1', '', array('class'=>'span12','placeholder'=>'Address 1')); ?>
					</div>
					<div class="controls">
						<?php echo $form->text('address2', '', array('class'=>'span12','placeholder'=>'Address 2')); ?>
					</div>
					<div class="controls controls-row">
						<?php echo $form->text('city', '', array('class'=>'span7','placeholder'=>'City')); ?>
						<select name="state" class="span3">
							<option>State</option>
						</select>
						<?php echo $form->text('zip', '', array('class'=>'span2','placeholder'=>'Zip')); ?>
					</div>
				</div>
				
				<h4>Credit Card <small>Card Number, Type, And Expiration Date</small></h4>
				<div class="controls controls-row poptip" data-placement="left" title="Credit Card Details" data-content="All transactions are securely processed immediately, and none of your information is saved.">
					<?php echo $form->text('card_number', '', array('class'=>'span5 showtooltip','placeholder'=>'Credit Card #','title'=>'All numeric, no spaces')); ?>
					<?php echo $form->select('card_type', ClinicaTransactionHelper::$cardTypes, '', array('class'=>'span3')); ?>
					<?php echo $form->select('exp_month', ClinicaTransactionHelper::expiryMonths(), '', array('class'=>'span2')); ?>
					<?php echo $form->select('exp_year', ClinicaTransactionHelper::expiryYears(), '', array('class'=>'span2')); ?>
				</div>
				
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
					<select class="span12">
						<option>Please Use This Donation For</option>
					</select>
					<?php echo $form->textarea('message', '', array('class'=>'input-block-level','placeholder'=>'Message')); ?>
				</div>
				
				<button class="btn btn-block btn-primary btn-large">Submit Donation!</button>
			</div>
		</form>
	</div>
</div>


