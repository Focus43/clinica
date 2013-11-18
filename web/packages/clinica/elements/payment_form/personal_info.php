<h4>Card Holder Information <small>Must match credit card entered below</small></h4>
<div class="controls controls-row poptip" title="Email Address" data-placement="left" data-content="Your receipt of payment will be emailed to this address, and is used for nothing else.">
	<?php if($phone == true){
		echo $form->text('email', '', array('class' => 'span6', 'placeholder' => 'Email address'));
		echo $form->text('phone', '', array('class' => 'span6', 'placeholder' => 'Phone: 123-123-1234'));
	}else{
		echo $form->text('email', '', array('class' => 'input-block-level', 'placeholder' => 'Email address'));
	} ?>
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
		<?php echo $form->select('state', (array('' => 'State') + Loader::helper('lists/states_provinces')->getStates()), '', array('class' => 'span3')); ?>
		<?php echo $form->text('zip', '', array('class'=>'span2','placeholder'=>'Zip')); ?>
	</div>
</div>