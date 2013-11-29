<?php 
$this->lang->load("label_name","thailand");
echo $htmlopen;
echo $head;
?>
    <!-- Custom styles -->
    <style type="text/css">
		#login-alert{
			border-radius: 4px 4px 4px 4px;
			margin-bottom: 20px;
    		padding:0px 15px 0px 15px;
		}
		fieldset.scheduler-border {
	    border: 1px solid #105B63 !important;
	    border-radius:5px;
	    padding: 0 1.4em 1.4em 1.4em !important;
	    margin: 0 0 1.5em 0 !important;    
		}
		legend.scheduler-border {
			
		    font-size: 14px !important;
		    font-weight: bold !important;
		    text-align: left !important;
		    width:auto; /* Or auto */
		    !padding:0 10px; /* To give a bit of padding on the left and right */
			border:none;
		}
    </style>
<?php
	echo $bodyopen;
	echo $navbar;
?>
<!-- Custom Content -->

    <div class="container">
      <div class="row">
      	<div class="col-lg-12">
      	<?php echo $profile_tab;?>
      		<div class="col-lg-6 col-lg-offset-3" id="loginform">
      			
      		 	<h2>แก้ไขข้อมูลการเข้าใช้ระบบ</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
      				$em_name=array(
      						"password0"=>$this->lang->line("in_password0"),
							"password"=>$this->lang->line("regis_in_password"),
							"password2"=>$this->lang->line("regis_in_password2"),
							"email"=>$this->lang->line("regis_in_email")
      				);
      				echo form_error($em_name["password0"]);
      				echo form_error($em_name["password"]);
      				echo form_error($em_name["password2"]);
      				echo form_error($em_name["email"]);
      			?>
      			</div>
      			<form role="form" action="?c=user_profile&m=edit_profile1" method="post">
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border">ข้อมูลการเข้าใช้ระบบ</legend>
						<?php 
						echo $in_username;
						?>
						<div class="form-group">
							<label for="change_password">แก้ไขรหัสผ่าน<span class="red-text"> *</span></label>
							<input type="checkbox" value="checked_pwd" name="change_password" id="change_password">			    
						</div>
						<?php 
						echo $in_password0;
						echo "<span id='".$em_name["password0"]."_error' class='hidden'>".form_error($em_name["password0"])."</span>";
						echo $in_password;
						echo "<span id='".$em_name["password"]."_error' class='hidden'>".form_error($em_name["password"])."</span>";
						echo $in_password2;
						echo "<span id='".$em_name["password2"]."_error' class='hidden'>".form_error($em_name["password2"])."</span>";
						echo $in_email;
						echo "<span id='".$em_name["email"]."_error' class='hidden'>".form_error($em_name["email"])."</span>";
						?>
					</fieldset>
					<button type="submit" class="btn btn-default">ยืนยัน</button>
				</form>
      		</div>
        </div>
      </div>
      

      <hr>

      <?php echo $footer; ?>
    </div>



<?php 
echo $js;
?>
<!-- Custom Javascript -->
	<script type="text/javascript" src="<?php echo base_url();?>js/user_profile_script.js"></script>
	<script type="text/javascript">
	<!--

	$(function(){
		nav_bar_link();
		
		/*#################################################
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_profile1_message"))
		{
			if($this->session->flashdata("edit_profile1_status")==true)
			{?>
				bootbox.alert("<?php echo $this->session->flashdata("edit_profile1_message");?>"); 
			<?php
			}
			else if ($this->session->flashdata("edit_profile1_status")==false) {
			?>
				bootbox.alert("<?php echo $this->session->flashdata("edit_profile1_message");?>");
			<?php	
			}
		}?>
		
		/*#################################################
		Highlight the <input> <select> 
		If span text length > 0 change input border color to red
		###################################################*/
		<?php 
		foreach ($em_name AS $key=>$value):
		?>
			if($("#<?php echo $em_name[$key];?>_error").text().length>0){
				$("#<?php echo $em_name[$key];?>").css("border","1px solid #bb0000");
				//checked the checkbox
				$("#change_password").attr("checked","checked");
			}
		<?php
		endforeach;
		?>
		active_tab();

		/*#################################################
		Show/Hide password form
		###################################################*/
		//add class 'pwdgroup' to #input_password0,#input_password,#input_password2
		$("#input_password0,#input_password,#input_password2").parent().attr('class','pwdgroup');
		$(".pwdgroup").hide();
		//click and checked '#change_password' to show '.pwdgroup'
		$("#change_password").click(function(){
			if($(this).is(":checked"))
			{
				$(".pwdgroup").show();
			}
			else $(".pwdgroup").hide();
		});
		if($("#change_password").is(":checked")) $(".pwdgroup").show();
		
		
	});
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;