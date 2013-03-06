<?php
 	/*
	 * Implement modernizr for backwards compatability with IE
	 * 
	 * http://stackoverflow.com/questions/9298802/using-selector-in-jquery-to-apply-css3pie-with-modernizr
	 */
?>

<script type="text/javascript">
	Modernizr.load([
		{
			test: Modernizr.mq('only all'),
			nope: '<?php echo Loader::helper('html')->javascript('shims/respond.min.js', 'clinica')->file; ?>'
		},
		{
    		test: Modernizr.borderradius && Modernizr.boxshadow,
    		nope: '<?php echo CLINICA_TOOLS_URL; ?>ie-shim.css'
		}
	])
</script>