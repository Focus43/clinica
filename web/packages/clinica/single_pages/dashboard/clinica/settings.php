<?php Loader::packageElement('flash_message', 'clinica', array('flash' => $flash)); ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Clinica Settings'), t('Clinica site settings'), false, false ); ?>
    
    <div id="clinicaWrap">
        <div class="ccm-pane-body">
            <div class="row-fluid">
                <div class="span6">
                    <form method="POST" action="<?php echo $this->action('save_ecommerce_settings'); ?>">
                        <div class="clearfix page-header" style="margin-top:0;">
                            <h3 class="lead pull-left">E-Commerce Settings</h3>
                            <button type="submit" class="btn btn-info pull-right">Save</button>
                        </div>
                        <label>Minimum Transaction Amount</label>
                        <div class="input-prepend input-append">
                            <span class="add-on">$</span><?php echo $formHelper->text('CLINICA_TRXN_MINIMUM_AMOUNT', Config::get('CLINICA_TRXN_MINIMUM_AMOUNT'), array('class' => 'input-small')); ?><span class="add-on">.00</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="ccm-pane-footer"></div>
    </div>
    
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>