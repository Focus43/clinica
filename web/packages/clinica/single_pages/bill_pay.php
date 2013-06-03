<div class="row-fluid">
	<div class="span5">
		<h3>On-line Bill Payment</h3>
		<?php $area = new Area('Bill Pay Page Content'); $area->display($c); ?>
	</div>
	
	<div class="span7">
		<h3>Bill Pay Form</h3>
		<div class="well">
			<form id="frmBillPay" method="post" data-method="ajax" action="<?php echo $this->controller->secureAction('process'); ?>">
				<?php Loader::packageElement('flash_message', 'clinica', array('flash' => $flash)); ?>
				
				<div class="form-content">
				    <h4>Patient Information <small>Account Details For Clinica Patient</small></h4>
                    <div class="poptip" title="Clinica Account Info" data-placement="left" data-content="Clinica account information can be found on the billing statement.">
                        <div class="controls">
                            <?php echo $accountAttrKey->render('paymentForm'); ?>
                        </div>
                        <div class="controls controls-row">
                            <?php foreach($attrKeysList AS $akObj){ /** @var $akObj AttributeKey */ ?>
                                <div class="span4">
                                    <?php echo $akObj->render('paymentForm'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <h4>Payment Amount <small>Pay some or all of amount due</small></h4>
                    <div class="controls controls-row poptip" data-placement="left" title="Donation Amount" data-content="On behalf of everyone at Clinica, and all the people we serve - thank you!">
                        <div class="input-prepend">
                            <span class="add-on">$</span>
                            <?php echo $form->text('amount'); ?>
                        </div>
                    </div>
                    
                    <?php Loader::packageElement('payment_form/personal_info', 'clinica', array('form' => $form, 'phone' => true)); ?>
                    
                    <?php Loader::packageElement('payment_form/credit_card', 'clinica', array('form' => $form)); ?>
                    
                    <h4>Other</h4>
                    <div class="controls">
                        <?php echo $form->textarea('message', '', array('class'=>'input-block-level','placeholder'=>'Message')); ?>
                    </div>
                    
                    <button class="btn btn-block btn-primary btn-large">Submit Bill Payment</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(function(){
        $('#frmBillPay').on('ajaxify_complete', function( _formEvent, respData ){
            if( respData.code === 1 ){
                var $receipt = $('<div class="receipt" />');
                $receipt.append('<h4>Payment Receipt (<span class="label label-important">DO NOT CLOSE/REFRESH BEFORE PRINTING</span>)</h4>');
                $receipt.append('<table class="table table-bordered"></table>');
                $('table', $receipt).append('<tr><td>Name</td><td>'+respData.payload.name+'</td></tr>');
                $('table', $receipt).append('<tr><td>Paid</td><td>$'+respData.payload.amount+'</td></tr>');
                $('table', $receipt).append('<tr><td>Date</td><td>'+respData.payload.date+'</td></tr>');
                $('table', $receipt).append('<tr><td>Transaction #</td><td>'+respData.payload.trxnID+'</td></tr>');
                $receipt.insertBefore( $('.form-content', '#frmBillPay') );
            }
        });
    });
</script>
