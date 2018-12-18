<style type="text/css">
.container-fluid {
  position: relative;
  margin-top: 3%;
}
</style>

<div class="move-down">
	<div class="container">
	<form action="/Account/ForgotPassword" method="post">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
			 <a href="/Account/Login"><?php echo $this->resources->LblBack; ?></a>
              <h1><?php echo $this->resources->TtlForgotPassword; ?></h1>
              <p class="text-muted"><?php echo $this->resources->LblForgotPasswordTxt; ?></p>
			  
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-user"></i>
                  </span>
                </div>
                <input type="text" class="form-control" value="<?php echo $this->service->username; ?>" name="username" 
					placeholder="<?php echo $this->resources->LblUsername; ?>" required>
              </div>
			  
              <button type="submit" class="btn btn-block btn-success create-button"><?php echo $this->resources->BtnCreateAccount; ?></button>
			  <?php include_once("Views/Shared/Message.php"); ?>
            </div>
            
          </div>
        </div>
      </div>
	  </form>
    </div>
</div>
