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
      	<?php echo $condition_tab;?>
      		<div class="col-lg-12" id="loginform">
      		 	<h2>แก้ไขระเบียบการใช้งานระบบ</h2>

      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
	      		 	$em_name=array(
	      		 			"te_condition"=>"textarea_condition"
	      		 	);
      		 		echo form_error($em_name["te_condition"]);
      		 	?>
      			</div>
      			
      			<form role="form" action="?d=manage&c=condition&m=edit" method="post" autocomplete="off">
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
						<?php
						echo $te_condition;
						echo "<span id='".$em_name["te_condition"]."_error' class='hidden'>".form_error($em_name["te_condition"])."</span>";
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
	<script type="text/javascript" src="<?php echo base_url();?>plugins/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	<!--
	tinymce.init({
		selector:'#textarea_condition',
		encoding:'xml',
		entity_encoding: "raw"
	});
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
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_condition_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("edit_condition_message");?>"); 
		<?php
		}?>
		
		active_tab();

		/*#################################################
		Tab menu link
		###################################################*/
		$("#add").on("click",function(){
			window.location="?d=manage&c=condition&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=condition&m=edit";
		});


		load_condition("1");
	});
	/*#################################################
	Unescape string
	&lt;p&gt; => <p>
	###################################################*/
	function htmlUnescape(value){
	    return String(value)
	        .replace(/&quot;/g, '"')
	        .replace(/&#39;/g, "'")
	        .replace(/&lt;/g, '<')
	        .replace(/&gt;/g, '>')
	        .replace(/&amp;/g, '&');
	}
	function load_condition(tid)
	{
		//show data in input
		$.ajax({
			url:"?d=manage&c=condition&m=load_condition",
			data:"tid="+tid,
			type:"POST",
			dataType:"json",
			success:function(resp){
				tinymce.get('textarea_condition').setContent(htmlUnescape(resp.condition));
			},
			error:function(error){
				alert("Error : "+error);
			}
		});
	}
	
	

	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;