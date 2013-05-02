
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
			
			
			// ajaxif'ied form
			if( $.fn.ajaxifyForm ){
			    $('form[data-method="ajax"]').ajaxifyForm({
			        
			    }).on('ajaxify_complete', function(event, respData){
			        console.log(respData)
			    });
			}
			
			
			// check all checkboxes
			$document.on('click', '#checkAllBoxes', function(){
				var $this  = $(this),
					checkd = $this.is(':checked');
				$(':checkbox', 'table#clinicaSearchTable tbody').prop('checked', checkd).trigger('change');
			});
			
			
			// if any box is checked, enable the actions dropdown
			$('#clinicaWrap').on('change', '#clinicaSearchTable tbody :checkbox', function(){
				if( $(':checkbox', '#clinicaSearchTable > tbody').filter(':checked').length ){
					$('#actionMenu').prop('disabled', false);
					return;
				}
				$('#actionMenu').attr('disabled', true);
			});
			
			
			$('#clinicaWrap').on('change', '#actionMenu', function(){
				var $this	= $(this),
					tools  	= $('#clinicaToolsDir').attr('value'),
					$checkd = $('tbody', '#clinicaSearchTable').find(':checkbox').filter(':checked'),
					data   	= $checkd.serializeArray();
				
				switch( $this.val() ){
					case 'delete':
						if( confirm('Delete these records? This cannot be undone!') ){
							var deleteURL = tools + $('#actionMenu').attr('data-action-delete');
							$.post( deleteURL, data, function(resp){
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
			
			
			// used w/ the manually add transactions page
			$('#typeHandle').on('change', {groups: $('.typeOptions', '#clinicaWrap')}, function( _event ){
                var $this = $(this),
                    _chzn = $this.val();
                _event.data.groups.hide().filter('[data-toggle-on="'+_chzn+'"]').show();
			});
		}
		
	});
