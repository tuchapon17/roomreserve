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
      		<div class="col-lg-12" id="loginform">
      		 	<h2>แก้ไขครุภัณฑ์/อุปกรณ์สำหรับห้อง</h2>
      		 	<form role="form" class="form-inline" action="?d=manage&c=room_has_article&m=search" method="post" autocomplete="off">
      		 		<?php echo $manage_search_box;?>
      		 	</form>
      		 	<?php echo $table_edit;?>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
	      		 	$em_name=array(
	      		 			"input_article"=>"input_article",
							"input_room"=>"input_room",
							"select_fee_type"=>"select_fee_type",
							"input_unit_num"=>"input_unit_num",
							"input_lump_sum_base_unit"=>"input_lump_sum_base_unit"
	      		 	);
      		 		echo form_error($em_name["input_article"]);
      		 		echo form_error($em_name["input_room"]);
      		 		echo form_error($em_name["select_fee_type"]);
      		 		echo form_error($em_name["input_unit_num"]);
      		 		echo form_error($em_name["input_lump_sum_base_unit"]);
      		 	?>
      			</div>
      			
      			<form role="form" action="?d=manage&c=room_has_article&m=edit" method="post" autocomplete="off">
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
						<?php
						//echo $se_article;
						//echo $se_room;
						echo $in_article;
						echo "<span id='".$em_name["input_article"]."_error' class='hidden'>".form_error($em_name["input_article"])."</span>";
						echo $in_room;
						echo "<span id='".$em_name["input_room"]."_error' class='hidden'>".form_error($em_name["input_room"])."</span>";
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
		$("#del_all_room_has_article").click(function(e){
			if(this.checked)
			{
				$(".del_room_has_article").prop("checked",true);
			}
			else $(".del_room_has_article").prop("checked",false);		
		});
		
		/*#################################################
		add num_rows to pagination 
		###################################################*/
		$("#pagination_num_rows").html("<a>ทั้งหมด <?php echo $pagination_num_rows;?> แถว</a>");
		
		/*#################################################
		Reset search result
		###################################################*/
		$("#clearSearch").click(function(){
			$.post("<?php echo base_url()?>?d=manage&c=room_has_article&m=search",{clear:"clear"},function(data,status){
				window.location="<?php echo base_url();?>?d=manage&c=room_has_article&m=edit";
			});
		}); 
		/*#################################################
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_room_has_article_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("edit_room_has_article_message");?>"); 
		<?php
		}?>
		
		active_tab();

		/*#################################################
		Tab menu link
		###################################################*/
		$("#add").on("click",function(){
			window.location="?d=manage&c=room_has_article&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=room_has_article&m=edit";
		});
	});
	
	function load_room_has_article(tid)
	{
		//show data
		var ArrayData = tid.split(',').map(String);
		$.ajax({
			url:"?d=manage&c=room_has_article&m=load_room_has_article",
			data:{room_id:ArrayData[0],article_id:ArrayData[1]},
			type:"POST",
			dataType:"json",
			success:function(resp){
				//$("#select_room").val(resp.tb_room_id);
				//$("#select_article").val(resp.tb_article_id);
				$("#input_room").val($("#room"+resp.tb_room_id).text());
				$("#input_article").val($("#article"+resp.tb_article_id).text());
				$("#select_fee_type").val(resp.tb_fee_type_id);
				$("#input_unit_num").val(resp.unit_num);
				$("#input_lump_sum_base_unit").val(resp.lump_sum_base_unit);
			},
			error:function(error){
				alert("Error : "+error);
			}
		});
		$("#input_room_has_article").focus();
	}
	function set_per_page(num)
	{
		$.post("<?php echo base_url()?>?d=manage&c=titlename&m=set_per_page",{num:num},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=room_has_article&m=edit";
		});
	}
	function show_del_list()
	{
		//show delete list in bootbox confirm
		var checked_num = $(".del_room_has_article:checked").length;
		var text = "ลบทั้งหมด "+checked_num+" รายการ?<br/>";
		text+="<ul>";
		$(".del_room_has_article").each(function(){
			if(this.checked)
			var arrId=$(this).val().split(',').map(String);
			text+="<li>"+$("#room"+arrId[0]).text()+" "+$("#article"+arrId[1]).text()+"</li>";
		});
		text+="</ul>";
		bootbox.confirm(text,function(result){
			if(result==true && checked_num>0)$("#form_del_room_has_article").submit();
		});
	}
	function set_orderby(field)
	{
		<?php 
		if($this->session->userdata("orderby_room_has_article")["type"]=="ASC") $type="DESC";
		else if($this->session->userdata("orderby_room_has_article")["type"]=="DESC") $type="ASC"
		?>
		$.post("<?php echo base_url()?>?d=manage&c=room_has_article&m=set_orderby",{field:field,type:"<?php echo $type;?>"},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=room_has_article&m=edit";
		});
	}
	function select_orderby()
	{
		var select_field='<select id="orderby" class="form-control">';
		select_field+='<option value="room_name">ชื่อห้อง</option>';
		select_field+='<option value="article_name">ชื่อครุภัณฑ์/อุปกรณ์</option>';
		select_field+='<option value="fee_type_name">ประเภทค่าบริการ</option>';
		select_field+='<option value="unit_num">จำนวนครุภัณฑ์/อุปกรณ์</option>';
		select_field+='<option value="lump_sum_base_unit">ค่าบริการพื้นฐาน(เหมา)</option>';
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
						//window.location="?d=manage&c=room_has_article&m=edit&orderby="+$("#orderby").val()+"&ordertype="+$("#ordertype").val();
						$.post("<?php echo base_url()?>?d=manage&c=room_has_article&m=set_orderby",{field:$("#orderby").val(),type:$("#ordertype").val()},function(data,status){
							window.location="<?php echo base_url();?>?d=manage&c=room_has_article&m=edit";
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
		$("#orderby").val("<?php echo $this->session->userdata("orderby_room_has_article")["field"];?>");
		$("#ordertype").val("<?php echo $this->session->userdata("orderby_room_has_article")["type"];?>");
	}
	function select_searchfield()
	{
		var select_field='<select id="searchfield" class="form-control">';
		select_field+='<option value="room_name">ชื่อห้อง</option>';
		select_field+='<option value="article_name">ชื่อครุภัณฑ์/อุปกรณ์</option>';
		select_field+='<option value="fee_type_name">ประเภทค่าบริการ</option>';
		select_field+='<option value="unit_num">จำนวนครุภัณฑ์/อุปกรณ์</option>';
		select_field+='<option value="lump_sum_base_unit">ค่าบริการพื้นฐาน(เหมา)</option>';
		select_field+='</select>';

		bootbox.dialog({
			message: select_field+"<br/>",
			title: "เลือกประเภทการค้นหา",
			buttons: {
				success: {
					label: "ตกลง",
					className: "btn-success",
					callback: function() {
						$.post("<?php echo base_url()?>?d=manage&c=room_has_article&m=set_searchfield",{searchfield:$("#searchfield").val()},function(data,status){
							window.location="<?php echo base_url();?>?d=manage&c=room_has_article&m=edit";
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
		$("#searchfield").val("<?php echo $this->session->userdata("searchfield_room_has_article");?>");
	}
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;