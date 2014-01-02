<?php 
$ci=&get_instance();
$ci->load->library("element_lib");
$eml=$ci->element_lib;
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
.hidden{
display:none;
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
      			
      		 	<h2>ลงทะเบียน</h2>
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
      				$em_name=array(
      						"username"=>$this->lang->line("regis_in_username"),
							"password"=>$this->lang->line("regis_in_password"),
							"password2"=>$this->lang->line("regis_in_password2"),
							"email"=>$this->lang->line("regis_in_email"),
							"titlename"=>$this->lang->line("regis_se_titlename"),
							"firstname"=>$this->lang->line("regis_in_firstname"),
							"lastname"=>$this->lang->line("regis_in_lastname"),
							"phone"=>$this->lang->line("regis_in_phone"),
							"occupation1"=>$this->lang->line("regis_se_occupation"),
							"occupation2"=>$this->lang->line("regis_in_occupation"),
							"house_no"=>$this->lang->line("regis_in_house_no"),
							"village_no"=>$this->lang->line("regis_in_village_no"),
							"alley"=>$this->lang->line("regis_in_alley"),
							"road"=>$this->lang->line("regis_in_road"),
							"province"=>$this->lang->line("regis_se_province"),
      						"district"=>$this->lang->line("regis_se_district"),
      						"subdistrict"=>$this->lang->line("regis_se_subdistrict")
      				);
      				echo form_error($em_name["username"]);
      				echo form_error($em_name["password"]);
      				echo form_error($em_name["password2"]);
      				echo form_error($em_name["email"]);
      				echo form_error($em_name["titlename"]);
      				echo form_error($em_name["firstname"]);
      				echo form_error($em_name["lastname"]);
      				echo form_error($em_name["phone"]);
      				echo form_error($em_name["occupation1"]);
      				echo form_error($em_name["occupation2"]);
      				echo form_error($em_name["house_no"]);
      				echo form_error($em_name["village_no"]);
      				echo form_error($em_name["alley"]);
      				echo form_error($em_name["road"]);
      				echo form_error($em_name["province"]);
      				echo form_error($em_name["district"]);
      				echo form_error($em_name["subdistrict"]);
      			?>
      			</div>    
	          	<form role="form" action="?c=register&m=step1" method="post" autocomplete="off">
					<fieldset class="scheduler-border">
					<legend class="scheduler-border">ข้อมูลการเข้าใช้ระบบ</legend>
					<?php 
					echo $in_username;
						echo "<span id='".$em_name["username"]."_error' class='hidden'>".form_error($em_name["username"])."</span>";
					echo $in_password;
						echo "<span id='".$em_name["password"]."_error' class='hidden'>".form_error($em_name["password"])."</span>";
					echo $in_password2;
						echo "<span id='".$em_name["password2"]."_error' class='hidden'>".form_error($em_name["password2"])."</span>";
					echo $in_email;
						echo "<span id='".$em_name["email"]."_error' class='hidden'>".form_error($em_name["email"])."</span>";
					?>
					</fieldset>
					<fieldset class="scheduler-border">
					<legend class="scheduler-border">ข้อมูลส่วนตัว</legend>
					<?php
					echo $se_titlename;
						echo "<span id='".$em_name["titlename"]."_error' class='hidden'>".form_error($em_name["titlename"])."</span>";
					echo $in_firstname;
						echo "<span id='".$em_name["firstname"]."_error' class='hidden'>".form_error($em_name["firstname"])."</span>";
					echo $in_lastname;
						echo "<span id='".$em_name["lastname"]."_error' class='hidden'>".form_error($em_name["lastname"])."</span>";
					echo $in_phone;
						echo "<span id='".$em_name["phone"]."_error' class='hidden'>".form_error($em_name["phone"])."</span>";
					echo $se_occupation;
						echo "<span id='".$em_name["occupation1"]."_error' class='hidden'>".form_error($em_name["occupation1"])."</span>";
					echo $in_occupation;
						echo "<span id='".$em_name["occupation2"]."_error' class='hidden'>".form_error($em_name["occupation2"])."</span>";
					?>
					</fieldset>
					<fieldset class="scheduler-border">
					<legend class="scheduler-border">ข้อมูลที่อยู่</legend>
					<?php 
					echo $in_house_no;
						echo "<span id='".$em_name["house_no"]."_error' class='hidden'>".form_error($em_name["house_no"])."</span>";
					echo $in_village_no;
						echo "<span id='".$em_name["village_no"]."_error' class='hidden'>".form_error($em_name["village_no"])."</span>";
					echo $in_alley;
						echo "<span id='".$em_name["alley"]."_error' class='hidden'>".form_error($em_name["alley"])."</span>";
					echo $in_road;
						echo "<span id='".$em_name["road"]."_error' class='hidden'>".form_error($em_name["road"])."</span>";
					echo $se_province;
						echo "<span id='".$em_name["province"]."_error' class='hidden'>".form_error($em_name["province"])."</span>";
					echo $se_district;
						echo "<span id='".$em_name["district"]."_error' class='hidden'>".form_error($em_name["district"])."</span>";
					echo $se_subdistrict;
						echo "<span id='".$em_name["subdistrict"]."_error' class='hidden'>".form_error($em_name["subdistrict"])."</span>";
					?>
					</fieldset>
				  <?php echo $eml->btn('submit','');?>
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
		$("select ,input").on("mouseover focus",function(){
			$(this).focus();
		});
		/*#################################################
		Highlight the <input> ID=input_occupation
		###################################################*/
		//$("#input_occupation").css("border","1px solid #bb0000");
		
		/*#################################################
		Show bootbox alert(confirm) after passed form validation
		###################################################*/
		<?php 
		if($this->session->flashdata("register_message"))
		{
			if($this->session->flashdata("register_status")==true)
			{?>
				bootbox.confirm("<?php echo $this->session->flashdata("register_message");?><br/>คุณต้องการไปยังหน้าเข้าสู่ระบบหรือไม่? ", function(result) {
					if(result == true)window.location="?c=login&m=auth";
				}); 
			<?php
			}
			else if ($this->session->flashdata("register_status")==false) {
			?>
				bootbox.alert("<?php echo $this->session->flashdata("register_message");?> ");
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
			}
		<?php
		endforeach;
		?>
		
		/*#################################################
		Get district list
		###################################################*/
		$("#select_province").on("keyup change",function(){
			if($(this).find("option:selected").val()!=""){
				$.ajax({
					url:"?c=register&m=select_district",
					data:{province_id:$(this).find("option:selected").val()},
					type:"POST",
					dataType:"json",
					success:function(resp){
						$("#select_district").find("option:gt(0)").remove();
						if(resp.district_list!=null)$("#select_district").append(resp.district_list);
						
					},
					error:function(error){
						alert("Error : "+error);
					}
				});
			}
			else
			{
				$("#select_district").find("option:gt(0)").remove();
			}
		});

		/*#################################################
		Get subdistrict list
		###################################################*/
		$("#select_district").on("keyup change",function(){
			if($(this).find("option:selected").val()!=""){
				$.ajax({
					url:"?c=register&m=select_subdistrict",
					data:{district_id:$(this).find("option:selected").val()},
					type:"POST",
					dataType:"json",
					success:function(resp){
						$("#select_subdistrict").find("option:gt(0)").remove();
						if(resp.subdistrict_list!=null)$("#select_subdistrict").append(resp.subdistrict_list);
						
					},
					error:function(error){
						alert("Error : "+error);
					}
				});
			}
			else
			{
				$("#select_district").find("option:gt(0)").remove();
			}
		});
		
		/*#################################################
		Get district list on startup if province is selected
		###################################################*/
		if($("#select_province").find("option:selected").val()!=""){
			setTimeout(function(){
				$("#select_province").trigger("change");
			});
		}

		/*#################################################
		find 'step' prefix of element in the #steptab 
		###################################################*/
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
		
		/*#################################################
		Add select option
		value = otherOccupation
		###################################################*/
		/*var o = new Option("option text", "otherOccupation");
		/// jquerify the DOM object 'o' so we can use the html method
		$(o).html("อาชีพอื่นๆ");
		$("#select_occupation").append(o);*/

		/*#################################################
		- find div parent of #input_occupation and add ID(otherOccupation) to this div
		- if selected otherOccupation #input_occupation has been visible
		###################################################*/
		$("#input_occupation").parent().attr('id','otherOccupation');
		$("#otherOccupation").hide();
		$("#select_occupation").on("keyup change",function(){
			if($(this).find('option:selected').val()=="00")
			{
				$("#otherOccupation").show();
			}
			else
			{
				$("#input_occupation").val('');
				$("#otherOccupation").hide();
			}
		});
		if($("#select_occupation").find("option:selected").val()=="00")
		{
			$("#select_occupation").trigger("change");
		}
	});
	/*#################################################
	GetURLParameter such as ?c=aaa&m=bbb
	this method can get aaa or bbb from URL
	###################################################*/
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