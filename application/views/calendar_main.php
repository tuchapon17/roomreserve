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
		.table-bordered2{
			!width:100%;
			border:1px solid #ccc;
		}
		.table-bordered2 td,th{
			width:120px;
			border:1px solid #ccc;
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
      	<?php //echo $titlename_tab;?>
      		<div class="col-lg-10 col-lg-offset-1" id="loginform">
				
      		 	<h2>ปฏิฑิน</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	
      			</div>
      			<?php echo $calendar;?>
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