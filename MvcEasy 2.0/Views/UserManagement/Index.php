<script type="text/javascript">
	$(document).ready(function(){
		$(".user-form").submit(function(e){
			e.preventDefault();
			
			//Determine insert or update
			var id = "";
			if(editUser != null)
				id = editUser.id;
			
			//Determine selected userroles
			var roles = [];
			$(".role-checkbox").each(function(){
				if($(this).is(":checked"))
					roles.push({roleId : $(this).attr("id")});
			});
			
			$.ajax({
				method: "POST",
				url: "/Api/usersSave/",
				data: { 
					id : id,
					name : $("#modal-name").val(),
					username : $("#modal-username").val(),
					email : $("#modal-email").val(),
					password : $("#modal-password").val(),
					active : $("#modal-active").is(":checked"),
					roleIds: JSON.stringify(roles)
				},
				success: function(data) {	
					try{
						var returnedUser = JSON.parse(data);
					}
					//Catch server error
					catch {
						$(".alert-danger").html(data);
						$(".alert-danger").show();
						return;
					}
					
					//After insert
					if(editUser == null) {
						var r = "<tr class='grid-table-row-clickable selected' id='" + returnedUser.id + "' data-toggle='modal' data-target='#userModal'>" + 
						"<td>" + $("#modal-username").val() + "</td>" + 
						"<td>" + $("#modal-name").val() + "</td>" + 
						"<td>" + $("#modal-email").val() + "</td>" + 
						"<td>" + ($("#modal-active").is(":checked") ? "<?php echo $this->resources->LblYes; ?>" : 
							"<?php echo $this->resources->LblNo; ?>") + "</td>" + 
						"<td style='display:none;'>" + JSON.stringify(returnedUser) + "</td>" +
						"</tr>";
						//insert table row
						$('.grid-table tbody > tr').eq(0).before(r);
					//After update
					} else {
						var r = $(".grid-table tbody > tr.selected");
						//update table row
						r.html("<td>" + $("#modal-username").val() + "</td>" + 
						"<td>" + $("#modal-name").val() + "</td>" + 
						"<td>" + $("#modal-email").val() + "</td>" + 
						"<td>" + ($("#modal-active").is(":checked") ? "<?php echo $this->resources->LblYes; ?>" : 
							"<?php echo $this->resources->LblNo; ?>") + "</td>" + 
						"<td style='display:none;'>" + JSON.stringify(returnedUser) + "</td>");
					}
					
					//Invoke click to close modal window
					$('button.close-button')[0].click()
				},
				error: function(data) {
					console.log(data);
				}
			});
		});
		
		//Generate random password for new user
		$(".password-button").click(function(){
			generateRandomPassword();
		});
	});

	var editUser; //The JSON-formatted user being edited
	
	//Editing an existing user
	function onRowClicked(id, row){
		$(".row-modal-password").hide();
		
		$(".modal-title").html("<?php echo $this->resources->LblEdit; ?>");			
		clearModalFields();
		$(".grid-table-row-clickable").removeClass("selected");
		row.addClass("selected");
		
		editUser = JSON.parse(row.find("td:last-child").html());
		
		$("#modal-name").val(editUser.name);
		$("#modal-username").val(editUser.username);
		$("#modal-email").val(editUser.email);
		$("#modal-password").val("dummypassword");
		$("#modal-active").prop('checked', editUser.active == "1");
		
		$(".nav-item-roles").show();
		
		$(".role-checkbox").each(function(){
			var box = $(this);
			if(editUser.userroles != null) {
				for(var i = 0; i < editUser.userroles.length; i++) {
					if(box.attr("id") == editUser.userroles[i].roleId)
						box.prop('checked', true);
				}
			}
		});
	}
	
	//Adding a user
	function onNewClicked(){
		$(".row-modal-password").show();
		
		editUser = null;
		$(".modal-title").html("<?php echo $this->resources->LblAdd; ?>");	
		
		clearModalFields();
		
		$(".grid-table-row-clickable").removeClass("selected");
		
		$(".nav-item-roles").hide();
	}
	
	//Reset modal window
	function clearModalFields(){
		$(".alert-danger").html("");
		$(".alert-danger").hide();
						
		$(".nav-item-roles").find("a").removeClass("active");
		$(".nav-item-roles").find("a").removeClass("show");
		
		$(".nav-item-user").find("a").addClass("active");
		$(".nav-item-user").find("a").addClass("show");
		
		$(".tab-content").find("#user").addClass("active");
		$(".tab-content").find("#user").addClass("show");
		
		$(".tab-content").find("#roles").removeClass("active");
		$(".tab-content").find("#roles").removeClass("show");
		
		$("#modal-name").val("");
		$("#modal-username").val("");
		$("#modal-email").val("");
		$("#modal-password").val("");
		$("#modal-active").prop('checked', false);
		
		$(".role-checkbox").prop('checked', false);
	}
</script>

<div class="card">
	<div class="card-header">
	<h4><?php echo $this->resources->LblUserManagement; ?></h4>
	
	</div>
	<div class="card-body">
		<div class="col-md-4">
			<div class="card text-white bg-info">
				<div class="card-header">
					Search
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><?php echo $this->resources->LblUsername; ?></span>
							</div>
							<input type="text" id="username3" name="search-username" class="form-control" autocomplete="nope">
						</div>
						<br />
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><?php echo $this->resources->LblName; ?></span>
							</div>
							<input type="text" id="name3" name="search-name" class="form-control" autocomplete="nope">
						</div>
					</div>
					<div class="form-group form-actions" style="text-align: right;">
						<button type="submit" class="btn btn-sm btn-primary search-button"><?php echo $this->resources->LblSubmit; ?></button>
						<button type="submit" class="btn btn-sm btn-primary clear-button"><?php echo $this->resources->LblClear; ?></button>
					</div>
					<div class="form-group form-actions" style="text-align: right;">
						<button type="button" class="text-white btn btn-outline-primary add-button" style="float:left;" data-toggle="modal" data-target="#userModal">
							<i class="fa fa-user-plus"></i>&nbsp;<?php echo $this->resources->LblAdd; ?>
						</button>
						<table style="float:right;">
							<tr>
								<td><label class="col-form-label" for="pagesize" style="float:left;"><?php echo $this->resources->LblPagesize; ?></label></td>
								<td>
									<select id="pagesize" name="pagesize" class="form-control">
										<option value="5" selected>5</option>
										<option value="10">10</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php 
			//Load necessary Javascript-files for grid functionality
			loadScript("grid");
			loadScript("_usermanagement");
			
			$headers = array(
				$this->resources->LblUsername,
				$this->resources->LblName,
				$this->resources->LblEmail, 
				$this->resources->LblActive
			);
			include_once("Views/Shared/Grid.php");
		?>
	</div>
</div>

<div class="container-fluid">
	<div id="ui-view">
		<form action="/UserManagement/Save" method="POST" class="user-form">
			<div>
				<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><?php echo $this->resources->LblAdd; ?></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<p>
									<div>
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item nav-item-user">
												<a class="nav-link active show" data-toggle="tab" href="#user" role="tab" 
													aria-controls="home" aria-selected="true"><?php echo $this->resources->LblUser; ?></a>
											</li>
											<li class="nav-item nav-item-roles">
												<a class="nav-link" data-toggle="tab" href="#roles" role="tab" aria-controls="profile" 
													aria-selected="false"><?php echo $this->resources->LblRoles; ?></a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active show" id="user" role="tabpanel">
												<input type="hidden" id="modal-id" />
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><?php echo $this->resources->LblUsername; ?></span>
														</div>
														<input type="text" id="modal-username" name="modal-username" class="form-control" required>
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
														<input type="text" id="modal-name" name="modal-name" class="form-control" required>
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
														<input type="email" id="modal-email" name="modal-email" class="form-control" required>
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="fa fa-envelope"></i>
															</span>
														</div>
													</div>
												</div>

												<div class="row-modal-password">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text"><?php echo $this->resources->LblPassword; ?></span>
															<input type="text" id="modal-password" name="modal-password" class="form-control" required>
															</div>
															<div class="input-group-append">
																<span class="input-group-text">
																	<i class="fa fa-asterisk"></i>
																</span>
																<button type="submit" class="btn btn-sm btn-warning password-button">
																	<?php echo $this->resources->LblGenerate; ?></button>
															</div>
														</div>
													</div>
												</div>
												
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><?php echo $this->resources->LblActive; ?></span>
														</div>
														<div class="form-check checkbox">
															
															<input style="margin-left:1px;margin-top:10px;" class="form-check-input role-checkbox" 
																type="checkbox" value="" id="modal-active">
														</div>
														
													</div>
												</div>
											</div>
											<div class="tab-pane" id="roles" role="tabpanel">
												<div class="col-md-9 col-form-label role-container">
													<?php foreach($this->service->roles as $role) : ?>
														<div class="form-check checkbox">
															<input class="form-check-input role-checkbox" type="checkbox" value="" id="<?php echo $role->id; ?>">
															<label class="form-check-label" for="check1">
																<?php echo $role->naam; ?>
															</label>
														</div>
													<?php endforeach; ?>
												</div>
												
											</div>
										</div>
									</div>
								</p>
							</div>
							<div class="modal-footer">
								<div style="display:none;" class="alert alert-danger" role="alert">
					
								</div>
								<button type="button" class="btn btn-secondary close-button" data-dismiss="modal"><?php echo $this->resources->LblClose; ?></button>
								<button type="submit" class="btn btn-primary"><?php echo $this->resources->LblSaveChanges; ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>