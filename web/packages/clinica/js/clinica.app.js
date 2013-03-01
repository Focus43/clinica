
	// clinica namespace
	var Clinica;
	
	// init when DOM is ready
	$(function(){
		
		Clinica = new function(){
			
			var _self 		= this,
				$document	= $(document),
				$body		= $('body'),
				$bgStretch	= $('[data-background]');
			
			
			/**
			 * Get a value from a meta tag. "Memoize" the call, so we'll never
			 * have to do lookups twice for the same value. Only looks in <head> tag.
			 * @param string _name Name value of the meta tag (eg. name="*")
			 * @return string
			 */
			this.getMetaValue = function( _name ){
				if( typeof(_self['_meta_'+_name]) == 'undefined' ){
					_self[ '_meta_'+_name ] = $('meta[name="'+_name+'"]', 'head').attr('content');
				}
				return _self[ '_meta_'+_name ];
			}
			
			
			/**
			 * Apply backstretch to any element that has data-background with
			 * a non-empty url.
			 * @return void
			 */
			if( $bgStretch.length && $.isFunction( $.backstretch ) ){
				$bgStretch.each(function(idx, element){
					var $el = $(element),
						img	= $el.attr('data-background');
					if( img.length ){ $el.backstretch( img ); }
				});
			}
			
		}
		
	});
