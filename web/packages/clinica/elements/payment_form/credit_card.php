<h4>Credit Card <small>Card Number, Type, And Expiration Date</small></h4>
<div class="controls controls-row poptip" data-placement="left" title="Credit Card Details" data-content="All transactions are securely processed immediately, and none of your information is saved.">
	<?php echo $form->text('card_number', '', array('class'=>'span5 showtooltip','placeholder'=>'Credit Card #','title'=>'All numeric, no spaces')); ?>
	<?php echo $form->select('card_type', ClinicaTransactionHelper::$cardTypes, '', array('class'=>'span3')); ?>
	<?php echo $form->select('exp_month', ClinicaTransactionHelper::expiryMonths(), '', array('class'=>'span2')); ?>
	<?php echo $form->select('exp_year', ClinicaTransactionHelper::expiryYears(), '', array('class'=>'span2')); ?>
</div>