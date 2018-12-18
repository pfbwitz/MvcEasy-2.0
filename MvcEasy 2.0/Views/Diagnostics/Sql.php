
<div class="card">
	<div class="card-header">
	<?php echo $this->resources->LblDiagnostics; ?>
	</div>
	<div class="card-body">
		<form action="/Diagnostics/Sql" method="POST">
			<div class="form-group row">
				<label class="col-md-1 col-form-label" for="textarea-input"><?php echo $this->resources->LblSelect; ?></label>
				<div class="col-md-11">
					<textarea id="textarea-input" name="statement" rows="9" 
						class="form-control" placeholder="<?php echo $this->resources->LblSqlTxt; ?>"><?php echo $this->statement; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-block btn-outline-primary col-md-2" style="float: right;"><?php echo $this->resources->LblSubmit; ?></button>
				</div>
			</div>
		</form>
	</div>
	<?php if($this->queryResult != null) : ?>
		<div class="card-body">
			<div class="form-group row">
			<?php if ($this->queryResult != null && sizeof($this->queryResult) > 0) : ?>
				<?php 
					$array = get_object_vars($this->queryResult[0]);
					
					$keys = array_keys($array);
				?>
				<table class="table table-responsive-sm table-bordered grid-table">
					<tr>
						<?php foreach($keys as $key) : ?>
							<th><?php echo $key; ?></th>
						<?php endforeach; ?>
					<tr>
					<?php foreach($this->queryResult as $r) : ?>
						<tr>
							<?php foreach($keys as $key) : ?>
								<td><?php echo(get_object_vars($r)[$key]); ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php endif; ?>
				
			</div>
		</div>
	<?php endif; ?>
	
</div>