<div class="card">
	<div class="card-header">
	<?php echo $this->resources->LblPassword; ?>
	</div>
	<div class="card-body">
		<form action="/Account/ChangePassword" method="post">
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><?php echo $this->resources->LblOldPassword; ?></span>
					</div>
					<input type="password" id="password1" name="password1" class="form-control" value="<?php echo $this->service->old; ?>" required>
					<div class="input-group-append">
						<span class="input-group-text">
							<i class="fa fa-asterisk"></i>
						</span>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><?php echo $this->resources->LblNewPassword; ?></span>
					</div>
					<input type="password" id="password2" name="password2" class="form-control" value="<?php echo $this->service->new; ?>" required>
					<div class="input-group-append">
						<span class="input-group-text">
							<i class="fa fa-asterisk"></i>
						</span>
					</div>
				</div>
			</div>
	
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><?php echo $this->resources->LblRepeatPassword; ?></span>
					</div>
					<input type="password" id="password3" name="password3" class="form-control" value="<?php echo $this->service->retype; ?>" required>
					<div class="input-group-append">
						<span class="input-group-text">
							<i class="fa fa-asterisk"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group form-actions">
				<button type="submit" class="btn btn-sm btn-primary"><?php echo $this->resources->LblSubmit; ?></button>
				<?php include_once("Views/Shared/Message.php"); ?>
			</div>
		</form>
	</div>
</div>	
		