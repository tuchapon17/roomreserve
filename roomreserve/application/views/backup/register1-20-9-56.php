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
      		<div class="col-lg-6 col-lg-offset-3" id="loginform">
      			
      		 	<h2>สมัครสมาชิก</h2>
      		 	<?php /*
      		 	<ul class="nav nav-tabs" id="steptab">
      		 	  <!-- data-toggle มี pill/tab -->
				  <li><a href="#" data-toggle="pill" id="step1">1</a></li>
				  <li><a href="#" data-toggle="pill" id="step2">2</a></li>
				  <li><a href="#" data-toggle="pill" id="step3">3</a></li>
				</ul>
				*/?>
      		 	<div class="alert-danger" id="login-alert">
      			<?php 
      				echo form_error("input_username");
      				echo form_error("input_password");
      				echo form_error("input_password2");
      				echo form_error("input_email");
      				echo form_error("select_titlename");
      				echo form_error("input_firstname");
      				echo form_error("input_lastname");
      				
      			?>
      			</div>    
	          	<form role="form" action="?c=register&m=step1" method="post">
<fieldset class="scheduler-border">
<legend class="scheduler-border">ข้อมูลการเข้าใช้ระบบ</legend>
				  <div class="form-group">
				    <label for="input_username">ชื่อผู้เข้าใช้<span class="red-text"> *</span></label>
				    <input type="text" class="form-control" name="input_username" id="input_username" placeholder="" value="<?php echo set_value("input_username");?>" maxlength="15">
				    <span class="help-block">5-15 ตัวอักษร และขึ้นต้นด้วยตัวอักษรภาษาอังกฤษ</span>
				  </div>
				  <div class="form-group">
				    <label for="input_password">รหัสผ่าน<span class="red-text"> *</span></label>
				    <input type="password" class="form-control" name="input_password" id="input_password" placeholder="" maxlength="15">
				    <span class="help-block"></span>
				  </div>
				  <div class="form-group">
				    <label for="input_password2">ยืนยันรหัสผ่าน<span class="red-text"> *</span></label>
				    <input type="password" class="form-control" name="input_password2" id="input_password2" placeholder="" maxlength="15">
				  </div>
				  <div class="form-group">
				    <label for="input_email">อีเมล<span class="red-text"> *</span></label>
				    <input type="text" class="form-control" name="input_email" id="input_email" placeholder="" value="<?php echo set_value("input_email");?>" maxlength="128">
				  </div>
</fieldset>
<fieldset class="scheduler-border">
<legend class="scheduler-border">ข้อมูลส่วนตัว</legend>
				  <div class="form-group">
				    <label for="select_titlename">คำนำหน้าชื่อ<span class="red-text"> *</span></label>
				    <select class="form-control" id="select_titlename" name="select_titlename">
				    	<option value="">เลือก</option>
				    	<option value="1">1</option>
				    </select>			
				        
				  </div>
				  <div class="form-group">
				    <label for="input_firstname">ชื่อ<span class="red-text"> *</span></label>
				    <input type="text" class="form-control" name="input_firstname" id="input_firstname" placeholder="" value="<?php echo set_value("input_firstname");?>" maxlength="40">
				  </div>
				  <div class="form-group">
				    <label for="input_lastname">นามสกุล<span class="red-text"> *</span></label>
				    <input type="text" class="form-control" name="input_lastname" id="input_lastname" placeholder="" value="<?php echo set_value("input_lastname");?>" maxlength="40">
				  </div>
				  				  <div class="form-group">
				    <label for="select_occupation">อาชีพ<span class="red-text"> *</span></label>
				    <select class="form-control" id="select_occupation" name="select_occupation">
				    	<option value="">เลือก</option>
				    	<option value="1">1</option>
				    	<option value="another">อื่นๆ โปรดระบุ</option>
				    </select>
	    			<label for="input_occupation">ระบุอาชีพ<span class="red-text"> *</span></label>
				    <input type="text" class="form-control" name="input_occupation" id="input_occupation" placeholder="" value="<?php echo set_value("input_occupation");?>" maxlength="30">    
				  </div>
				  <div class="form-group">
				    <label for="input_phone">เบอร์โทรศัพท์<span class="red-text"> *</span></label>
				    <input type="text" class="form-control" name="input_phone" id="input_phone" placeholder="" value="<?php echo set_value("input_phone");?>" maxlength="10">
				  </div>
</fieldset>
<fieldset class="scheduler-border">
<legend class="scheduler-border">ข้อมูลที่อยู่</legend>
<?php 
echo $in_house_no;
echo $in_village_no;
echo $in_alley;
echo $in_road;
?>
				  <div class="form-group">
				    <label for="input_house_no">บ้านเลขที่<span class="red-text"> *</span></label>
				    <input type="text" class="form-control" name="input_house_no" id="input_house_no" placeholder="" value="<?php echo set_value("input_house_no");?>" maxlength="10">
				  </div>
				  <div class="form-group">
				    <label for="input_village_no">หมู่ที่</label>
				    <input type="text" class="form-control" name="input_village_no" id="input_village_no" placeholder="" value="<?php echo set_value("input_village_no");?>" maxlength="2"> 
				  </div>
				  <div class="form-group">
				    <label for="input_alley">ตรอก/ซอย</label>
				    <input type="text" class="form-control" name="input_alley" id="input_alley" placeholder="" value="<?php echo set_value("input_alley");?>" maxlength="30">
				  </div>
				  <div class="form-group">
				    <label for="input_road">ถนน</label>
				    <input type="text" class="form-control" name="input_road" id="input_road" placeholder="" value="<?php echo set_value("input_road");?>" maxlength="25">
				  </div>
				  <div class="form-group">
				    <label for="select_province">จังหวัด<span class="red-text"> *</span></label>
				    <select class="form-control" id="select_province" name="select_province">
				    	<option value="">เลือก</option>
				    	<option value="1">1</option>
				    </select>			    
				  </div>
				  <div class="form-group">
				    <label for="select_district">อำเภอ<span class="red-text"> *</span></label>
				    <select class="form-control" id="select_district" name="select_district">
				    	<option value="">เลือก</option>
				    	<option value="1">1</option>
				    </select>			    
				  </div>
				  <div class="form-group">
				    <label for="select_subdistrict">ตำบล<span class="red-text"> *</span></label>
				    <select class="form-control" id="select_subdistrict" name="select_subdistrict">
				    	<option value="">เลือก</option>
				    	<option value="1">1</option>
				    </select>
				  </div>
</fieldset>
<?php echo $in_username;?>
				  
				  
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
	<script type="text/javascript">
	<!--
	$(function(){
		//alert(getURLParameter("m"));
		/*if(getURLParameter("m")=="step1")
		{
			$("#"+getURLParameter("m")).attr("data-toggle","tab");
		}*/
		//$("#step1").removeAttr('data-toggle');
		/*ค้นหา element ภายใน #steptab ที่ id ขึ้นต้นด้วย step */
		$("#steptab").find('[id^="step"]').filter(function(index){
			/*ลบ data-toggle ของแต่ละ id=step.. */
			//$("#"+this.id).removeAttr('data-toggle');
			
			//$("#"+getURLParameter("m")).attr("data-toggle","tab");
			
			/*actived tab*/
			$("#"+getURLParameter("m")).tab('show');
			if(getURLParameter("m")!=this.id)
			{
				/*ไม่สามารถคลิกstepอื่นที่ไม่ใช่หน้านี้ได้ */
				$("#"+this.id).click(function(){return false;});
			}
		});
		$("#"+getURLParameter("m"))
	});
	function getURLParameter(name) {
	    return decodeURI(
	        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
	    );
	}
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;