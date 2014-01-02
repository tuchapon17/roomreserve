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
      	<?php echo $titlename_tab;?>
      		<div class="col-lg-6 col-lg-offset-3" id="loginform">
				
      		 	<h2>เพิ่มคำนำหน้าชื่อ</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php
	      		 	$em_name=array(
	      		 			"in_titlename"=>"input_titlename"
	      		 	);
      		 		echo form_error($em_name["in_titlename"]);
      		 	?>
      			</div>
      			<form role="form" action="?d=manage&c=titlename&m=add" method="post" autocomplete="off">
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
						<?php 
						echo $in_titlename;
						echo "<span id='".$em_name["in_titlename"]."_error' class='hidden'>".form_error($em_name["in_titlename"])."</span>";
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
		Show bootbox alert
		###################################################*/
		<?php 
		if($this->session->flashdata("titlename_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("titlename_message");?>");
		<?php
		}?>
		
		active_tab();
		$("#add").on("click",function(){
			window.location="?d=manage&c=titlename&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=titlename&m=edit";
		});
	});
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;