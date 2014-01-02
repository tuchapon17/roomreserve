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
      	<?php echo $user_tab;?>
      		<div class="col-lg-12" id="loginform">
      		 	<h2>จัดการผู้ใช้</h2>
      		 	<form role="form" class="form-inline" action="?d=manage&c=user&m=search" method="post" autocomplete="off">
      		 		<?php echo $manage_search_box;?>
      		 	</form>
      		 	<?php echo $table_edit;?>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
	      		 	/*$em_name=array(
	      		 			"in_username"=>"input_username"
	      		 	);
      		 		echo form_error($em_name["in_username"]);*/
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
			$(".allow_user0:not(:checked)").each(function(){
				$(this).prop("checked",true);
			});
			$(".allow_user1:not(:checked)").each(function(){
				$(this).prop("checked",true);
			});
		});
		/*#################################################
		green -> red
		check each checkbox if checked->unchecked
		###################################################*/
		$("#disallow-all").click(function(){
			$(".allow_user1:checked").each(function(){
				$(this).prop("checked",false);
			});
			$(".allow_user0:checked").each(function(){
				$(this).prop("checked",false);
			});
		});
		/*#################################################
		Highlight the <input> <select> 
		If span text length > 0 change input border color to red
		###################################################*/
		<?php 
		/*foreach ($em_name AS $key=>$value):
		?>
			if($("#<?php echo $em_name[$key];?>_error").text().length>0){
				$("#<?php echo $em_name[$key];?>").css("border","1px solid #bb0000");
			}
		<?php
		endforeach;*/
		?>
		/*#################################################
		Checked/Unchecked all checkbox
		###################################################*/
		$("#del_all_user").click(function(e){
			if(this.checked)
			{
				$(".del_user").prop("checked",true);
			}
			else $(".del_user").prop("checked",false);		
		});
		
		/*#################################################
		add num_rows to pagination 
		###################################################*/
		$("#pagination_num_rows").html("<a>ทั้งหมด <?php echo $pagination_num_rows;?> แถว</a>");
		
		/*#################################################
		Reset search result
		###################################################*/
		$("#clearSearch").click(function(){
			$.post("<?php echo base_url()?>?d=manage&c=user&m=search",{clear:"clear"},function(data,status){
				window.location="<?php echo base_url();?>?d=manage&c=user&m=edit";
			});
		}); 
		/*#################################################
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_user_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("edit_user_message");?>"); 
		<?php
		}?>
		
		active_tab();

		/*#################################################
		Tab menu link
		###################################################*/
		$("#add").on("click",function(){
			window.location="?d=manage&c=user&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=user&m=edit";
		});
	});

	function show_all_data(username)
	{
		$.ajax({
			url:"?d=manage&c=user&m=show_all_data",
			data:"username="+username,
			type:"POST",
			dataType:"json",
			success:function(r){
				var text='<dl class="dl-horizontal">';
				text+='<dt>ชื่อผู้ใช้</dt>';
					text+='<dd>'+r["username"]+'</dd>';
				text+='<dt>อีเมล</dt>';
					text+='<dd>'+r["email"]+'</dd>';
				text+='<dt>วัน/เวลาที่ลงทะเบียน</dt>';
					text+='<dd>'+r["regis_on"]+'</dd>';
				text+='<dt>IP ที่ลงทะเบียน</dt>';
					text+='<dd>'+r["regis_ip"]+'</dd>';
				text+='<dt>กลุ่มผู้ใช้</dt>';
					text+='<dd>'+r["group_name"]+'</dd>';
				text+='<dt>คำนำหน้าชื่อ</dt>';
					text+='<dd>'+r["titlename"]+'</dd>';
				text+='<dt>ชื่อ</dt>';
					text+='<dd>'+r["firstname"]+'</dd>';
				text+='<dt>นามสกุล</dt>';
					text+='<dd>'+r["lastname"]+'</dd>';
				text+='<dt>อาชีพ</dt>';
					text+='<dd>'+r["occupation_name"]+'</dd>';
				text+='<dt>เบอร์โทรศัพท์</dt>';
					text+='<dd>'+r["phone"]+'</dd>';
				text+='<dt>บ้านเลขที่</dt>';
					text+='<dd>'+r["house_no"]+'</dd>';
				text+='<dt>หมู่ที่</dt>';
					text+='<dd>'+r["village_no"]+'</dd>';
				text+='<dt>ตรอก/ซอย</dt>';
					text+='<dd>'+r["alley"]+'</dd>';
				text+='<dt>ถนน</dt>';
					text+='<dd>'+r["road"]+'</dd>';
				text+='<dt>ตำบล</dt>';
					text+='<dd>'+r["subdistrict_name"]+'</dd>';
				text+='<dt>อำเภอ</dt>';
					text+='<dd>'+r["district_name"]+'</dd>';
				text+='<dt>จังหวัด</dt>';
					text+='<dd>'+r["province_name"]+'</dd>';
				text+='</dl>';
				bootbox.alert(text);
			},
			error:function(error){
				alert("Error : "+error);
			}
		});
	}

	function set_per_page(num)
	{
		$.post("<?php echo base_url()?>?d=manage&c=titlename&m=set_per_page",{num:num},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=user&m=edit";
		});
	}
	function show_del_list()
	{
		//show delete list in bootbox confirm
		var checked_num = $(".del_user:checked").length;
		var text = "ลบทั้งหมด "+checked_num+" รายการ?<br/>";
		text+="<ul>";
		$(".del_user").each(function(){
			if(this.checked)
			text+="<li>"+$(this).val()+" "+$("#user"+$(this).val()).text()+"</li>";
		});
		text+="</ul>";
		bootbox.confirm(text,function(result){
			if(result==true && checked_num>0)$("#form_del_user").submit();
		});
	}
	
	function select_orderby()
	{
		var select_field='<select id="orderby" class="form-control">';
		select_field+='<option value="username">ชื่อผู้ใช้</option>';
		select_field+='<option value="group_name">กลุ่มผู้ใช้</option>';
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

						$.post("<?php echo base_url()?>?d=manage&c=user&m=set_orderby",{field:$("#orderby").val(),type:$("#ordertype").val()},function(data,status){
							window.location="<?php echo base_url();?>?d=manage&c=user&m=edit";
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
		$("#orderby").val("<?php echo $this->session->userdata("orderby_user")["field"];?>");
		$("#ordertype").val("<?php echo $this->session->userdata("orderby_user")["type"];?>");
	}
	function show_allow_list()
	{
		//show delete list in bootbox confirm
		var allow_list=new Array();
		var disallow_list=new Array();
		var allow_num = $(".allow_user0:checked").length;
		var disallow_num = $(".allow_user1:not(:checked)").length;

		//unchecked -> checked
		var text = "อนุมัติทั้งหมด "+allow_num+" รายการ?<br/>";
		text+="<ul>";
		$(".allow_user0:checked").each(function(){

				text+="<li>"+$(this).val()+" "+$("#user"+$(this).val()).text()+"</li>";
				allow_list.push($(this).val());

		});
		text+="</ul>";

		//checked -> unchecked
		var text2 = "ยกเลิกทั้งหมด "+disallow_num+" รายการ?<br/>";
		text2+="<ul>";
		$(".allow_user1:not(:checked)").each(function(){

				text2+="<li>"+$(this).val()+" "+$("#user"+$(this).val()).text()+"</li>";
				disallow_list.push($(this).val());

		});
		text2+="</ul>";
		bootbox.confirm(text+text2,function(result){
			if(result==true && (allow_num>0 || disallow_num>0))
			{
				$.post("<?php echo base_url()?>?d=manage&c=user&m=allow",{allow_list:allow_list,disallow_list:disallow_list},function(data,status){
					window.location="<?php echo base_url();?>?d=manage&c=user&m=edit";
				});
			}
		});
	}
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;