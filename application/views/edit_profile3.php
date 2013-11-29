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
      			
      		 	<h2>แก้ไขข้อมูลที่อยู่</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
      				$em_name=array(
      						"house_no"=>$this->lang->line("regis_in_house_no"),
							"village_no"=>$this->lang->line("regis_in_viilage_no"),
							"alley"=>$this->lang->line("regis_in_alley"),
							"road"=>$this->lang->line("regis_in_road"),
							"province"=>$this->lang->line("regis_se_province"),
							"district"=>$this->lang->line("regis_se_district"),
							"subdistrict"=>$this->lang->line("regis_se_subdistrict")
      				);
      				echo form_error($em_name["house_no"]);
      				echo form_error($em_name["village_no"]);
      				echo form_error($em_name["alley"]);
      				echo form_error($em_name["road"]);
      				echo form_error($em_name["province"]);
      				echo form_error($em_name["district"]);
      				echo form_error($em_name["subdistrict"]);
      			?>
      			</div>
      			<form role="form" action="?c=user_profile&m=edit_profile3" method="post">
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
		Show bootbox alert after edited profile2
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_profile3_message"))
		{
			if($this->session->flashdata("edit_profile3_status")==true)
			{?>
				bootbox.alert("<?php echo $this->session->flashdata("edit_profile3_message");?>"); 
			<?php
			}
			else if ($this->session->flashdata("edit_profile3_status")==false) {
			?>
				bootbox.alert("<?php echo $this->session->flashdata("edit_profile3_message");?>");
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
		active_tab();
	});
	
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
	$("#select_province").trigger("change");
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;