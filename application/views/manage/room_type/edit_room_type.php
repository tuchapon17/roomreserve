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
      	<?php echo $room_type_tab;?>
      		<div class="col-lg-12" id="loginform">
      		 	<h2>แก้ไขประเภทห้อง</h2>
      		 	<form role="form" class="form-inline" action="?d=manage&c=room_type&m=search" method="post">
      		 		<?php echo $manage_search_box;?>
      		 	</form>
      		 	<?php echo $table_edit;?>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
	      		 	$em_name=array(
	      		 			"in_room_type"=>"input_room_type"
	      		 	);
      		 		echo form_error($em_name["in_room_type"]);
      		 	?>
      			</div>
      			
      			<form role="form" action="?d=manage&c=room_type&m=edit" method="post">
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
						<?php
						echo $in_room_type;
						echo "<span id='".$em_name["in_room_type"]."_error' class='hidden'>".form_error($em_name["in_room_type"])."</span>";
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
		Checked/Unchecked all checkbox
		###################################################*/
		$("#del_all_room_type").click(function(e){
			if(this.checked)
			{
				$(".del_room_type").prop("checked",true);
			}
			else $(".del_room_type").prop("checked",false);		
		});
		
		/*#################################################
		add num_rows to pagination 
		###################################################*/
		$("#pagination_num_rows").html("<a>ทั้งหมด <?php echo $pagination_num_rows;?> แถว</a>");
		
		/*#################################################
		Reset search result
		###################################################*/
		$("#clearSearch").click(function(){
			$.post("<?php echo base_url()?>?d=manage&c=room_type&m=search",{clear:"clear"},function(data,status){
				window.location="<?php echo base_url();?>?d=manage&c=room_type&m=edit";
			});
		}); 
		/*#################################################
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_room_type_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("edit_room_type_message");?>"); 
		<?php
		}?>
		
		active_tab();

		/*#################################################
		Tab menu link
		###################################################*/
		$("#add").on("click",function(){
			window.location="?d=manage&c=room_type&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=room_type&m=edit";
		});
	});
	
	function load_room_type(tid)
	{
		//show data in input
		$.ajax({
			url:"?d=manage&c=room_type&m=load_room_type",
			data:"tid="+tid,
			type:"POST",
			dataType:"json",
			success:function(resp){
				$("#input_room_type").val(resp.room_type_name);
			},
			error:function(error){
				alert("Error : "+error);
			}
		});
		$("#input_room_type").focus();
	}
	function set_per_page(num)
	{
		$.post("<?php echo base_url()?>?d=manage&c=titlename&m=set_per_page",{num:num},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=room_type&m=edit";
		});
	}
	function show_del_list()
	{
		//show delete list in bootbox confirm
		var checked_num = $(".del_room_type:checked").length;
		var text = "ลบทั้งหมด "+checked_num+" รายการ?<br/>";
		text+="<ul>";
		$(".del_room_type").each(function(){
			if(this.checked)
			text+="<li>"+$(this).val()+" "+$("#room_type"+$(this).val()).text()+"</li>";
		});
		text+="</ul>";
		bootbox.confirm(text,function(result){
			if(result==true && checked_num>0)$("#form_del_room_type").submit();
		});
	}
	function set_orderby(field)
	{
		<?php 
		if($this->session->userdata("orderby_room_type")["type"]=="ASC") $type="DESC";
		else if($this->session->userdata("orderby_room_type")["type"]=="DESC") $type="ASC"
		?>
		$.post("<?php echo base_url()?>?d=manage&c=room_type&m=set_orderby",{field:field,type:"<?php echo $type;?>"},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=room_type&m=edit";
		});
	}
	function select_orderby()
	{
		var select_field='<select id="orderby" class="form-control">';
		select_field+='<option value="room_type_id">รหัสประเภทห้อง</option>';
		select_field+='<option value="room_type_name">ประเภทห้อง</option>';
		select_field+='</select>';
		var select_type='<select id="ordertype" class="form-control">';
		select_type+='<option value="ASC">น้อยไปหามาก</option>';
		select_type+='<option value="DESC">มากไปหาน้อย</option>';
		select_type+='</select>';
		bootbox.dialog({
			message: select_field+select_type,
			title: "เรียงลำดับข้อมูล",
			buttons: {
				success: {
					label: "ตกลง",
					className: "btn-success",
					callback: function() {
						//window.location="?d=manage&c=article&m=edit&orderby="+$("#orderby").val()+"&ordertype="+$("#ordertype").val();
						$.post("<?php echo base_url()?>?d=manage&c=room_type&m=set_orderby",{field:$("#orderby").val(),type:$("#ordertype").val()},function(data,status){
							window.location="<?php echo base_url();?>?d=manage&c=room_type&m=edit";
						});
					}
				},
				danger: {
					label: "ยกเลิก",
					className: "btn-danger",
					callback: function() {
					
					}
				}
			}
		});
		$("#orderby").val("<?php echo $this->session->userdata("orderby_room_type")["field"];?>");
		$("#ordertype").val("<?php echo $this->session->userdata("orderby_room_type")["type"];?>");
	}
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;