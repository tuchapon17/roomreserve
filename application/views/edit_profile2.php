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
      	<?php echo $profile_tab;?>
      		<div class="col-lg-6 col-lg-offset-3" id="loginform">
      			
      		 	<h2>แก้ไขข้อมูลส่วนตัว</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
      				$em_name=array(
      						"titlename"=>"select_titlename",
							"firstname"=>"input_firstname",
							"lastname"=>"input_lastname",
							"occupation1"=>"select_occupation",
							"occupation2"=>"input_occupation"
      				);
      				echo form_error($em_name["titlename"]);
      				echo form_error($em_name["firstname"]);
      				echo form_error($em_name["lastname"]);
      				echo form_error($em_name["occupation1"]);
      				echo form_error($em_name["occupation2"]);
      			?>
      			</div>
      			<form role="form" action="?c=user_profile&m=edit_profile2" method="post">
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border">ข้อมูลส่วนตัว</legend>
						<?php 
						echo $se_titlename; 
						echo "<span id='".$em_name["titlename"]."_error' class='hidden'>".form_error($em_name["titlename"])."</span>";
						echo $in_firstname;
						echo "<span id='".$em_name["firstname"]."_error' class='hidden'>".form_error($em_name["firstname"])."</span>";
						echo $in_lastname;
						echo "<span id='".$em_name["lastname"]."_error' class='hidden'>".form_error($em_name["lastname"])."</span>";
						echo $se_occupation;
						echo "<span id='".$em_name["occupation1"]."_error' class='hidden'>".form_error($em_name["occupation1"])."</span>";
						echo $in_occupation;
						echo "<span id='".$em_name["occupation2"]."_error' class='hidden'>".form_error($em_name["occupation2"])."</span>";
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
		if($this->session->flashdata("edit_profile2_message"))
		{
			if($this->session->flashdata("edit_profile2_status")==true)
			{?>
				bootbox.alert("<?php echo $this->session->flashdata("edit_profile2_message");?>"); 
			<?php
			}
			else if ($this->session->flashdata("edit_profile2_status")==false) {
			?>
				bootbox.alert("<?php echo $this->session->flashdata("edit_profile2_message");?>");
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
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;