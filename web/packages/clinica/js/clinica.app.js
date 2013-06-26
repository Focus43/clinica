
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
			
			
			/**
			 * Ajaxify forms
			 */
			if( $.fn.ajaxifyForm ){
				var formHandler = $('form[data-method="ajax"]').ajaxifyForm({
					beforeSend: function( $form ){
						$('.message', $form).remove();
						$form.animate({height:80}, 150, 'easeInSine').addClass('ajaxProcessing');
					}
				}).on('ajaxify_complete', function(event, respData){
					var $form = $(event.target);
					if( respData.code === 1 ){
						$form.addClass('ajaxSuccess');
					}
					$form.stop(true, true).height('').removeClass('ajaxProcessing');
				});
			}
			
			
			/**
			 * Popovers and tooltips
			 */
			$document.popover({
				animation: false,
				selector: '.poptip',
				trigger: 'hover',
				placement: function(){
					return this.$element.attr('data-placement') || 'top';
				}
			}).tooltip({
				animation: false,
				selector: '.showtooltip',
				trigger: 'hover focus',
				placement: 'top',
				container: 'body'
			});
			
			
			/**
			 * Smooth page scrolling
			 */
			$document.on('click', 'a[href^="#"]', function( _event ){
				_event.preventDefault();
				var $this	= $(this),
					$target = $( $this.attr('href') );
				if( !$this.hasClass('carousel-control') ){
					if( $target.length ){
						var fromTop = $target.offset().top;
						$('html,body').stop().animate({scrollTop: fromTop}, 850, 'easeOutExpo');
					}
				}
			});
			
			
			
			$('#cFooter').on('click', '.footer-gray', function(_event){
			    if( $body.width() <= 767){
                    $(this).siblings().slideToggle(250, 'easeOutExpo');
                }
            });

		}
		
		
		/**
		 * jQuery Easing Methods
		 */
		jQuery.extend( jQuery.easing, {
			easeInSine: function (x, t, b, c, d) {
				return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
			},
			easeInExpo: function (x, t, b, c, d) {
				return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
			},
			easeOutExpo: function (x, t, b, c, d) {
				return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
			}
		});
		
	});
