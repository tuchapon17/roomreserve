<?php 

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
    </style>
<?php
echo $bodyopen;
echo $navbar;
?>
<!-- Custom Content -->

    <div class="container">
      <div class="row">
      	<div class="col-lg-12">
      		<div class="col-lg-6 col-lg-offset-3" id="loginform">
      			
      		 	<h2>ลงชื่อเข้าใช้</h2>
      		 	<div class="alert-danger" id="login-alert">
      			<?php 
      				echo form_error("input_username");
      				echo form_error("input_password");
      				if($this->session->flashdata("login_message")) echo $this->session->flashdata("login_message");
      			?>
      			</div>    
	          	<form role="form" action="?c=login&m=auth" method="post" autocomplete="off">
	          	<?php 
	          		echo $in_username;
	          		echo $in_password;
	          	?>
				  <!-- <div class="form-group">
				    <label for="input_username">ชื่อผู้เข้าใช้<span class="red-text"> *</span></label>
				    <input type="text" class="form-control" name="input_username" id="input_username" placeholder="" value="<?php echo set_value("input_username");?>">
				  </div>
				  <div class="form-group">
				    <label for="input_password">รหัสผ่าน<span class="red-text"> *</span></label>
				    <input type="password" class="form-control" name="input_password" id="input_password" placeholder="">
				  </div> -->
				  <button type="submit" class="btn btn-default">เข้าสู่ระบบ</button>
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
	<script type="text/javascript">
	<!--
	$(function(){
		$("#input_username").focus();
	});
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;