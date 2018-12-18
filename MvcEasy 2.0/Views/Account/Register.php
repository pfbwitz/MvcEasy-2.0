<style type="text/css">
.container-fluid {
  position: relative;
  margin-top: 20%;
  transform: translateY(-50%);
}
</style>

<div class="move-down">
	<div class="container">
	<form action="/Account/Register" method="post">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
			 <a href="/Account/Login"><?php echo $this->resources->LblBack; ?></a>
              <h1><?php echo $this->resources->LblRegister; ?></h1>
              <p class="text-muted"><?php echo $this->resources->LblCreateYourAccount; ?></p>
			  <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-user"></i>
                  </span>
                </div>
                <input type="text" class="form-control" value="<?php echo $this->service->name; ?>" name="name" placeholder="<?php echo $this->resources->LblName; ?>" required>
              </div>
			  
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-user"></i>
                  </span>
                </div>
                <input type="text" class="form-control" value="<?php echo $this->service->username; ?>" name="username" placeholder="<?php echo $this->resources->LblUsername; ?>" required>
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" value="<?php echo $this->service->email; ?>" name="email" placeholder="<?php echo $this->resources->LblEmail; ?>" required>
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input type="password" class="form-control" value="<?php echo $this->service->new; ?>" name ="password" placeholder="<?php echo $this->resources->LblPassword; ?>" required>
              </div>

              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input type="password" class="form-control" value="<?php echo $this->service->retype; ?>" name="passwordrepeat" placeholder="<?php echo $this->resources->LblRepeatPassword; ?>" required>
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
