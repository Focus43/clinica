<script type="text/javascript">
	Modernizr.load([
		{
			test: Modernizr.mq('only all'),
			nope: '<?php echo Loader::helper('html')->javascript('shims/respond.min.js', 'clinica')->file; ?>'
		}
	]);
</script>