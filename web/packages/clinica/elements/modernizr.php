<script type="text/javascript">
	Modernizr.load([
		{
			test: Modernizr.mq('only all'),
			nope: '<?php echo Loader::helper('html')->javascript('libs/shims/respond.min.js', 'clinica')->file; ?>'
		},
		{
			test: Modernizr.placeholder,
			nope: '<?php echo Loader::helper('html')->javascript('libs/shims/placeholder.min.js', 'clinica')->file; ?>',
			complete: function(){
				if( typeof(Placeholders) != 'undefined' ){
					Placeholders.init();
				}
			}
		}
	]);
</script>