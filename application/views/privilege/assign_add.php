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
      		<?php echo $assign_tab;?>
      		<div class="col-lg-8 col-lg-offset-2">
      			<br/>
	      		<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">โอนสิทธิ์</h3>
						</div>
						<div class="panel-body">
							<form class="" action="<?php echo base_url();?>?d=privilege&c=assign&m=add" method="post" autocomplete="off">
			      				<div class="form-group">
			      					<label for="">สิทธิ์</label>
			      					<select class="form-control" name="privilege_list" id="privilege_list">
			      						<option value="">เลือก</option>
			      						<?php 
			      							foreach($privilege_list as $p)
			      							{
			      								echo "<option value='".$p['privilege_id']."'>".$p['privilege_name']."</option>";
			      							}
			      						?>
			      					</select>
			      				</div>
			      				<div class="form-group">
			      					<label for="">ผู้รับสิทธิ์</label>
			      					<select class="form-control" name="user_list" id="user_list">
			      						<option value="">เลือก</option>
			      					</select>
			      				</div>
			      				<br>
			      				<div class="form-group text-right">
			      					<?php echo $eml->btn('submit','');?>
			      				</div>
			      			</form>
						</div>
					</div>
      			
      		</div><!-- col-lg-12 (2) -->
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
		$("#privilege_list").on("keyup change",function(){
			if($(this).find("option:selected").val()!=""){
				$.ajax({
					url:"?d=privilege&c=assign&m=get_user_list",
					data:{privilege_id:$(this).find("option:selected").val()},
					type:"POST",
					dataType:"json",
					success:function(resp){
						$("#user_list").find("option:gt(0)").remove();
						if(resp.username!=null)	$("#user_list").append(resp.username);
					},
					error:function(error){
						alert("Error : "+error);
					}
				});
			}
			else
			{
				$("#user_list").find("option:gt(0)").remove();
			}
		});
		
		/*#################################################
		Show bootbox alert after added
		###################################################*/
		<?php 
		if($this->session->flashdata("add_p_a_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("add_p_a_message");?>"); 
		<?php
		}?>
		
		active_tab();
		$("#add").on("click",function(){
			window.location="?d=privilege&c=assign&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=privilege&c=assign&m=edit";
		});
	});
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;