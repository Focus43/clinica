
	var ClinicaDash;
	
	$(function(){
		
		ClinicaDash = new function(){
			
			var self 		= this,
				$document 	= $(document);
			
			
			// tooltips and popover bindings
			$document.tooltip({
				animation: false,
				selector: '.helpTooltip',
				trigger: 'hover'
			}).popover({
				animation: false,
				selector: '.helpTip',
				placement: 'bottom'
			});
			
			
			// check all checkboxes
			$document.on('click', '#checkAllBoxes', function(){
				var $this  = $(this),
					checkd = $this.is(':checked');
				$(':checkbox', 'table#transactionList tbody').prop('checked', checkd).trigger('change');
			});
			
			
			// if any box is checked, enable the actions dropdown
			$('#ctManager').on('change', '#transactionList tbody :checkbox', function(){
				if( $(':checkbox', '#transactionList > tbody').filter(':checked').length ){
					$('#actionMenu').prop('disabled', false);
					return;
				}
				$('#actionMenu').attr('disabled', true);
			});
			
			
			$('#ctManager').on('change', '#actionMenu', function(){
				var $this	= $(this),
					tools  	= $('#clinicaToolsDir').attr('value'),
					$checkd = $('tbody', '#transactionList').find(':checkbox').filter(':checked'),
					data   	= $checkd.serializeArray();
				
				switch( $this.val() ){
					case 'delete':
						if( confirm('Delete the selected transactions? This cannot be undone.') ){
							$.post( tools + 'dashboard/transactions/delete', data, function(resp){
								if( resp.code == 1 ){
									$checkd.parents('tr').fadeOut(150);
								}else{
									alert('An error occurred. Try again later.');
								}
							}, 'json');
						}
						break;
				}
				
				// reset the menu
				$this.val('');
			});
		}
		
	});
