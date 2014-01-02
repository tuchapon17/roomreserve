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
    </style>
<?php
	echo $bodyopen;
	echo $navbar;
?>
<!-- Custom Content -->

    <div class="container">
      <div class="row">
      	<div class="col-lg-12">
      	<?php echo $room_has_article_tab;?>
      		<div class="col-lg-8 col-lg-offset-2" id="loginform">
				
      		 	<h2>เพิ่มครุภัณฑ์/อุปกรณ์สำหรับห้อง</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php
	      		 	$em_name=array(
	      		 			"select_article"=>"select_article",
							"select_room"=>"select_room",
							"select_fee_type"=>"select_fee_type",
							"input_unit_num"=>"input_unit_num",
							"input_lump_sum_base_unit"=>"input_lump_sum_base_unit"
	      		 	);
      		 		echo form_error($em_name["select_article"]);
      		 		echo form_error($em_name["select_room"]);
      		 		echo form_error($em_name["select_fee_type"]);
      		 		echo form_error($em_name["input_unit_num"]);
      		 		echo form_error($em_name["input_lump_sum_base_unit"]);
      		 	?>
      			</div>
      			<form role="form" action="?d=manage&c=room_has_article&m=add" method="post" autocomplete="off">
      			
      				<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
						
						<?php 
						echo $se_article;
						echo "<span id='".$em_name["select_article"]."_error' class='hidden'>".form_error($em_name["select_article"])."</span>";
						echo $se_room;
						echo "<span id='".$em_name["select_room"]."_error' class='hidden'>".form_error($em_name["select_room"])."</span>";
						echo $in_unit_num;
						echo "<span id='".$em_name["input_unit_num"]."_error' class='hidden'>".form_error($em_name["input_unit_num"])."</span>";
						echo $se_fee_type;
						echo "<span id='".$em_name["select_fee_type"]."_error' class='hidden'>".form_error($em_name["select_fee_type"])."</span>";
						echo $in_lump_sum_base_unit;
						echo "<span id='".$em_name["input_lump_sum_base_unit"]."_error' class='hidden'>".form_error($em_name["input_lump_sum_base_unit"])."</span>";
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
	<script type="text/javascript" src="<?php echo base_url();?>js/user_profile_script.js"></script>
	<script type="text/javascript">
	<!--
	$(function(){
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
		Show bootbox alert after 
		###################################################*/
		<?php 
		if($this->session->flashdata("room_has_article_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("room_has_article_message");?>"); 
		<?php
		}?>
		
		active_tab();
		$("#add").on("click",function(){
			window.location="?d=manage&c=room_has_article&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=room_has_article&m=edit";
		});

		/*#################################################
		Get room list
		###################################################*/
		$("#select_article").on("keyup change",function(){
			if($(this).find("option:selected").val()!=""){
				$.ajax({
					url:"?d=manage&c=room_has_article&m=select_room_list",
					data:{article_id:$(this).find("option:selected").val()},
					type:"POST",
					dataType:"json",
					success:function(resp){
						$("#select_room").find("option:gt(0)").remove();
						if(resp.room_list!=null)$("#select_room").append(resp.room_list);
					},
					error:function(error){
						alert("Error : "+error);
					}
				});
			}
			else
			{
				$("#select_room").find("option:gt(0)").remove();
			}
		});
	});
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;