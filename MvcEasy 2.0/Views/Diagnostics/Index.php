
<div class="card">
	<div class="card-header">
	<?php echo $this->resources->LblDiagnostics; ?>
	</div>
	<div class="card-body">
		<div class="col-6 col-sm-4 col-md-2">
			<a href="/Diagnostics/Sql">
				<button type="button" class="btn btn-block btn-outline-primary"><?php echo $this->resources->LblSql; ?></button>
			</a>
			<br />
			<a href="/Diagnostics/Errorlog">
				<button type="button" class="btn btn-block btn-outline-primary"><?php echo $this->resources->LblErrorlog; ?></button>
			</a>
		</div>
	</div>
</div>