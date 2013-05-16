
	/**
	 * If pageChoozer isn't defined in the global scope, define it first
	 */
	if( typeof(pageChoozer) === 'undefined' ){
		
		var pageChoozer = new function(){
			
			var self	  = this,
				$document = $(document);
			
			
			// add a new page picker
			$document.on('click', '#pageChoozerAdd', function(){
				var $cloned = $('.ccm-summary-selected-item', '#clonableWrap').clone(true);
				$('#chosenPagesList').append( $cloned );
				self.initSortable();
			});
			
			
			// when trash icon is clicked, remove the page picker element
			$document.on('click', '#pageChoozer a.ccm-sitemap-clear-selected-page', function(){
				$(this).parents('.ccm-summary-selected-item').remove();
			});
			
			
			this.initSortable = function(){
				$('#chosenPagesList').sortable({
					items: '.ccm-summary-selected-item',
					containment: 'parent',
					tolerance: 'pointer'
				});
			}
			
		}

	}

	pageChoozer.initSortable();
