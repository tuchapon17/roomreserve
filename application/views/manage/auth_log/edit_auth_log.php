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
      	<?php echo $auth_log_tab;?>
      		<div class="col-lg-12" id="loginform">
      		 	<h2>จัดการบันทึกการเข้าสู่ระบบ</h2>
      		 	<form role="form" class="form-inline" action="?d=manage&c=auth_log&m=search" method="post" autocomplete="off">
      		 		<?php echo $manage_search_box;?>
      		 	</form>
      		 	<?php echo $table_edit;?>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
	      		 	$em_name=array(
	      		 			"in_auth_log_name"=>"input_auth_log_name"
	      		 	);
      		 		echo form_error($em_name["in_auth_log_name"]);
      		 	?>
      			</div>
      			
      			
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
		red -> green
		check each checkbox if uncheck->checked
		###################################################*/
		$("#allow-all").click(function(){
			$(".allow_auth_log0:not(:checked)").each(function(){
				$(this).prop("checked",true);
			});
			$(".allow_auth_log1:not(:checked)").each(function(){
				$(this).prop("checked",true);
			});
		});
		/*#################################################
		green -> red
		check each checkbox if checked->unchecked
		###################################################*/
		$("#disallow-all").click(function(){
			$(".allow_auth_log1:checked").each(function(){
				$(this).prop("checked",false);
			});
			$(".allow_auth_log0:checked").each(function(){
				$(this).prop("checked",false);
			});
		});
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
		$("#del_all_auth_log").click(function(e){
			if(this.checked)
			{
				$(".del_auth_log").prop("checked",true);
			}
			else $(".del_auth_log").prop("checked",false);		
		});
		
		/*#################################################
		add num_rows to pagination 
		###################################################*/
		$("#pagination_num_rows").html("<a>ทั้งหมด <?php echo $pagination_num_rows;?> แถว</a>");
		
		/*#################################################
		Reset search result
		###################################################*/
		$("#clearSearch").click(function(){
			$.post("<?php echo base_url()?>?d=manage&c=auth_log&m=search",{clear:"clear"},function(data,status){
				window.location="<?php echo base_url();?>?d=manage&c=auth_log&m=edit";
			});
		}); 
		/*#################################################
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_auth_log_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("edit_auth_log_message");?>"); 
		<?php
		}?>
		
		active_tab();

		/*#################################################
		Tab menu link
		###################################################*/
		$("#add").on("click",function(){
			window.location="?d=manage&c=auth_log&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=auth_log&m=edit";
		});
	});
	
	function load_auth_log(tid)
	{
		//show data in input
		$.ajax({
			url:"?d=manage&c=auth_log&m=load_auth_log",
			data:"tid="+tid,
			type:"POST",
			dataType:"json",
			success:function(resp){
				$("#input_auth_log_name").val(resp.auth_log_name);
			},
			error:function(error){
				alert("Error : "+error);
			}
		});
		$("#input_auth_log_name").focus();
	}
	function set_per_page(num)
	{
		$.post("<?php echo base_url()?>?d=manage&c=titlename&m=set_per_page",{num:num},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=auth_log&m=edit";
		});
	}
	function show_del_list()
	{
		//show delete list in bootbox confirm
		var checked_num = $(".del_auth_log:checked").length;
		var text = "ลบทั้งหมด "+checked_num+" รายการ?<br/>";
		text+="<ul>";
		$(".del_auth_log").each(function(){
			if(this.checked)
			text+="<li>"+$(this).val()+" "+$("#auth_log"+$(this).val()).text()+"</li>";
		});
		text+="</ul>";
		bootbox.confirm(text,function(result){
			if(result==true && checked_num>0)$("#form_del_auth_log").submit();
		});
	}
	
	function select_orderby()
	{
		var select_field='<select id="orderby" class="form-control">';
		select_field+='<option value="auth_log_id">รหัสบันทึกการเข้าสู่ระบบ</option>';
		select_field+='<option value="tb_user_username">ชื่อผู้ใช้</option>';
		select_field+='</select>';
		var select_type='<select id="ordertype" class="form-control">';
		select_type+='<option value="ASC">น้อยไปหามาก</option>';
		select_type+='<option value="DESC">มากไปหาน้อย</option>';
		select_type+='</select>';
		bootbox.dialog({
			message: select_field+"<br/>"+select_type,
			title: "เลือกลำดับข้อมูล",
			buttons: {
				success: {
					label: "ตกลง",
					className: "btn-success",
					callback: function() {
						$.post("<?php echo base_url()?>?d=manage&c=auth_log&m=set_orderby",{field:$("#orderby").val(),type:$("#ordertype").val()},function(data,status){
							window.location="<?php echo base_url();?>?d=manage&c=auth_log&m=edit";
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
		$("#orderby").val("<?php echo $this->session->userdata("orderby_auth_log")["field"];?>");
		$("#ordertype").val("<?php echo $this->session->userdata("orderby_auth_log")["type"];?>");
	}
	function select_searchfield()
	{
		var select_field='<select id="searchfield" class="form-control">';
		select_field+='<option value="auth_log_id">รหัสบันทึกการเข้าสู่ระบบ</option>';
		select_field+='<option value="tb_user_username">ชื่อผู้ใช้</option>';
		select_field+='<option value="ip_address">IPที่เข้าสู่ระบบ</option>';
		select_field+='</select>';

		bootbox.dialog({
			message: select_field+"<br/>",
			title: "เลือกประเภทการค้นหา",
			buttons: {
				success: {
					label: "ตกลง",
					className: "btn-success",
					callback: function() {
						$.post("<?php echo base_url()?>?d=manage&c=auth_log&m=set_searchfield",{searchfield:$("#searchfield").val()},function(data,status){
							window.location="<?php echo base_url();?>?d=manage&c=auth_log&m=edit";
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
		$("#searchfield").val("<?php echo $this->session->userdata("searchfield_auth_log");?>");
	}
	function show_allow_list()
	{
		//show delete list in bootbox confirm
		var allow_list=new Array();
		var disallow_list=new Array();
		var allow_num = $(".allow_auth_log0:checked").length;
		var disallow_num = $(".allow_auth_log1:not(:checked)").length;

		//unchecked -> checked
		var text = "อนุมัติทั้งหมด "+allow_num+" รายการ?<br/>";
		text+="<ul>";
		$(".allow_auth_log0:checked").each(function(){

				text+="<li>"+$(this).val()+" "+$("#auth_log"+$(this).val()).text()+"</li>";
				allow_list.push($(this).val());

		});
		text+="</ul>";

		//checked -> unchecked
		var text2 = "ยกเลิกทั้งหมด "+disallow_num+" รายการ?<br/>";
		text2+="<ul>";
		$(".allow_auth_log1:not(:checked)").each(function(){

				text2+="<li>"+$(this).val()+" "+$("#auth_log"+$(this).val()).text()+"</li>";
				disallow_list.push($(this).val());

		});
		text2+="</ul>";
		bootbox.confirm(text+text2,function(result){
			if(result==true && (allow_num>0 || disallow_num>0))
			{
				$.post("<?php echo base_url()?>?d=manage&c=auth_log&m=allow",{allow_list:allow_list,disallow_list:disallow_list},function(data,status){
					window.location="<?php echo base_url();?>?d=manage&c=auth_log&m=edit";
				});
			}
		});
	}
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;