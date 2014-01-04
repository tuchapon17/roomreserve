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
		.fixed-table tr th:first-child, tr td:first-child, th:last-child, tr td:last-child{
		width:auto;
		text-align:left;
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
      			<?php echo $table_assign_list;?>
      			
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
		active_tab();
		$("#add").on("click",function(){
			window.location="?d=privilege&c=assign&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=privilege&c=assign&m=edit";
		});

		$(".label-assign").click(function(){
			//alert($(this).prev().val());
			var c;
			if($(this).prev().attr("class") == "allow_assign0")
			{
				c=$(this).prev().attr("class");
				$(this).prev().attr("class","allow-assign1");

				$.ajax({
					url:"?d=privilege&c=assign&m=allow_assign",
					data:{c:c,assign_id:$(this).prev().val()},
					type:"POST",
					dataType:"json",
					success:function(resp){
						bootbox.alert(resp.assign_status);
					},
					error:function(error){
						//alert("Error : "+error);
					}
				});
			}
			else return false;
			
			
		});
	});
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;