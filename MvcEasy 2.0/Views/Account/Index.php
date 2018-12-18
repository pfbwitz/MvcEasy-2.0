<script type="text/javascript">
	$(document).ready(function(){
		$(".password-button").click(function(e){
			e.preventDefault();
			window.location = "/Account/ChangePassword";
		});
	});
</script>
<div class="card">
	<div class="card-header">
	<?php echo $this->resources->LblMyAccount; ?>
	</div>
		<div class="card-body">
			<form action="/Account/Index" method="post">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><?php echo $this->resources->LblUsername; ?></span>
						</div>
						<input type="text" id="username3" name="username3" class="form-control" 
							value="<?php echo $this->gebruiker->username;?>" required />
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="fa fa-user"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><?php echo $this->resources->LblName; ?></span>
						</div>
						<input type="text" id="name3" name="name3" class="form-control" 
							value="<?php echo $this->gebruiker->name;?>" required />
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="fa fa-user"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><?php echo $this->resources->LblEmail; ?></span>
						</div>
						<input type="email" id="email3" name="email3" class="form-control" 
							value="<?php echo $this->gebruiker->email;?>" required />
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="fa fa-envelope"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><?php echo $this->resources->LblPassword; ?></span>
						</div>
						<input disabled type="password" id="password3" name="password3" class="form-control" value="placeholder" />
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="fa fa-asterisk"></i>
							</span>
							<button type="submit" class="btn btn-sm btn-warning password-button"><?php echo $this->resources->LblChange; ?></button>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><?php echo $this->resources->LblActive; ?></span>
						</div>
						<label class="switch switch-primary">
							<?php if($this->gebruiker->active == 1) : ?>
								<input name="active3" type="checkbox" class="switch-input" checked="">
							<?php else : ?>
							<input name="active3" type="checkbox" class="switch-input">
							<?php endif; ?>
							<span class="switch-slider"></span>
						</label>
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="fa fa-check-square"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group form-actions">
				<button type="submit" class="btn btn-sm btn-primary save-button"><?php echo $this->resources->LblSubmit; ?></button>
				<?php include_once("Views/Shared/Message.php"); ?>
				</div>
			</form>
		</div>
</div>
		
		
		