<?php if( is_array($flash) && !empty($flash) ): ?>
	<div class="alert alert-<?php echo $flash['type']; ?>">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<?php echo $flash['msg']; ?>
	</div>
<?php endif; ?>