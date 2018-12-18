<style type="text/css">
.move-down {
  position: relative;
  margin-top: 3%;
}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$(".login-button").on("click", function(){
			$(".login-form").submit();
		});
		
		$(".forgot-button").on("click", function(){
			window.location = "/Account/ForgotPassword";
		});
		
		$(".register-button").on("click", function(){
			window.location = "/Account/Register";
		});
	});
</script>
<div class="move-down">
	<form action='/Account/Login<?php echo $this->parameter; ?>/' method='post' class="login-form">
		<div class="container">
		  <div class="row justify-content-center">
			<div class="col-md-8">
			  <div class="card-group">
				<div class="card p-4">
				  <div class="card-body">
					<h1><?php echo $this->resources->LblLogin; ?></h1>
					<p class="text-muted"><?php echo $this->resources->LblLoginTxt; ?></p>
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
						<span class="input-group-text">
						  <i class="icon-user"></i>
						</span>
					  </div>
					  <input type="text" class="form-control" placeholder="<?php echo $this->resources->LblUsername; ?>" name="username">
					</div>
					<div class="input-group mb-4">
					  <div class="input-group-prepend">
						<span class="input-group-text">
						  <i class="icon-lock"></i>
						</span>
					  </div>
					  <input name="password" type="password" class="form-control" placeholder="<?php echo $this->resources->LblPassword; ?>">
					   <?php if($this->hasError) : ?>
							<div style="margin-top: 5px;" class="alert alert-danger" role="alert">
								<?php echo $this->error; ?>
							</div>
					   <?php endif; ?>
					</div>
					<div class="row">
					  <div class="col-6">
						<button type="button" class="btn btn-primary px-4 login-button"><?php echo $this->resources->LblLogin; ?></button>
					  </div>
					  <div class="col-6 text-right">
						<button type="button" class="btn btn-link px-0 forgot-button" data-toggle="modal" data-target="#primaryModal">
							<?php echo $this->resources->LblForgotPassword; ?>
						</button>
					  </div>
					</div>
				  </div>
				</div>
				<div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
				  <div class="card-body text-center">
					<div>
					  <h2><?php echo $this->resources->LblRegisterTitle; ?></h2>
					  <p><?php echo $this->resources->LblRegisterTxt; ?></p>
					  <button type="button" class="btn btn-primary active mt-3 register-button"><?php echo $this->resources->BtnRegisterNow; ?></button>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>	
	</form>
</div>

