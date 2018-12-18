<?php if ($this->hasMessage) : ?>
	<p>
		<div class="alert alert-primary" role="alert">
			<?php echo $this->message; ?>
		</div>
	</p>
<?php endif; ?>
<?php if($this->hasError) : ?>
	<p>
		<div style="margin-top: 5px;" class="alert alert-danger" role="alert">
			<?php echo $this->error; ?>
		</div>
	</p>
<?php endif; ?>