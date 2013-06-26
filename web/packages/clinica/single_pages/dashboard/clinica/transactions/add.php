<?php /** @var $transactionObj ClinicaTransaction */ ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Add Transaction'), t('Manually add transaction.'), false, false ); ?>
    
    <div id="clinicaWrap" class="addTrxn">
        <div class="ccm-pane-body">
            <form data-method="ajax" action="<?php echo $this->action('create'); ?>">
                <!-- ajax response feedback -->
                <?php Loader::packageElement('flash_message', 'clinica'); ?>
                
                <div class="well">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <h4>Transaction Type <small>Affects available input fields</small></h4>
                            <div class="controls controls-row">
                                <?php echo $form->select('typeHandle', ClinicaTransactionHelper::typeHandles()); ?>
                            </div>
                            
                            <div class="typeOptions" data-toggle-on="<?php echo ClinicaTransaction::TYPE_DONATION; ?>">
                                <?php
                                    $attrs = AttributeSet::getByHandle(ClinicaTransaction::TYPE_DONATION)->getAttributeKeys();
                                    foreach($attrs AS $akObj){ /** @var $akObj AttributeKey */
                                        echo '<label>'.$akObj->getAttributeKeyName().'</label>';
                                        echo $akObj->render('form');
                                    }
                                ?>
                            </div>
                            
                            <div class="typeOptions" data-toggle-on="<?php echo ClinicaTransaction::TYPE_BILL_PAY; ?>">
                                <?php
                                    $attrs = AttributeSet::getByHandle(ClinicaTransaction::TYPE_BILL_PAY)->getAttributeKeys();
                                    foreach($attrs AS $akObj){ /** @var $akObj AttributeKey */
                                        //echo '<label>'.$akObj->getAttributeKeyName().'</label>';
                                        echo '<div class="controls">';
                                        echo $akObj->render('paymentForm');
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <?php Loader::packageElement('payment_form/personal_info', 'clinica', array('form' => $form)); ?>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <?php Loader::packageElement('payment_form/credit_card', 'clinica', array('form' => $form)); ?>
                            <div class="controls controls-row">
                                <?php echo $form->text('amount', '', array('class' => 'input-medium', 'placeholder' => '$ Amount')); ?> <span style="position:relative;top:7px;">.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <h4>Message <small>Not required</small></h4>
                            <div class="controls controls-row">
                                <?php echo $form->textarea('message', '', array('class' => 'input-block-level', 'placeholder' => 'Message')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn">Save</button>
            </form>
        </div>
        <div class="ccm-pane-footer"></div>
    </div>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>