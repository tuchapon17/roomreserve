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
      	<?php echo $room_tab;?>
      		<div class="col-lg-12" id="loginform">
      		 	<h2>แก้ไข ห้อง</h2>
      		 	<form role="form" class="form-inline" action="?d=manage&c=room&m=search" method="post">
      		 		<?php echo $manage_search_box;?>
      		 	</form>
      		 	<?php echo $table_edit;?>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
	      		 	$em_name=array(
	      		 			"in_room_name"=>"input_room_name",
							"se_room_type"=>"select_room_type",
							"te_room_detail"=>"textarea_room_detail",
							"in_discount_percent"=>"input_discount_percent"
	      		 	);
      		 		echo form_error($em_name["in_room_name"]);
      		 		echo form_error($em_name["se_room_type"]);
      		 		echo form_error($em_name["te_room_detail"]);
      		 		echo form_error($em_name["in_discount_percent"]);
      		 	?>
      			</div>
      			
      			<form role="form" action="?d=manage&c=room&m=edit" method="post">
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
						<?php
						echo $in_room_name;
						echo "<span id='".$em_name["in_room_name"]."_error' class='hidden'>".form_error($em_name["in_room_name"])."</span>";
						echo $se_room_type;
						echo "<span id='".$em_name["se_room_type"]."_error' class='hidden'>".form_error($em_name["se_room_type"])."</span>";
						echo $te_room_detail;
						echo $in_discount_percent;
						echo "<span id='".$em_name["in_discount_percent"]."_error' class='hidden'>".form_error($em_name["in_discount_percent"])."</span>";
						?>	
					</fieldset>
					<button type="submit" class="btn btn-default">แก้ไข</button>
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
		selector:'#textarea_room_detail',
		encoding:'xml',
		entity_encoding: "raw"
	});
	$(function(){
		//tinymce initialize 
		
		
		/*#################################################
		red -> green
		check each checkbox if uncheck->checked
		###################################################*/
		$("#allow-all").click(function(){
			$(".allow_room0:not(:checked)").each(function(){
				$(this).prop("checked",true);
			});
			$(".allow_room1:not(:checked)").each(function(){
				$(this).prop("checked",true);
			});
		});
		/*#################################################
		green -> red
		check each checkbox if checked->unchecked
		###################################################*/
		$("#disallow-all").click(function(){
			$(".allow_room1:checked").each(function(){
				$(this).prop("checked",false);
			});
			$(".allow_room0:checked").each(function(){
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
		$("#del_all_room").click(function(e){
			if(this.checked)
			{
				$(".del_room").prop("checked",true);
			}
			else $(".del_room").prop("checked",false);		
		});
		
		/*#################################################
		add num_rows to pagination 
		###################################################*/
		$("#pagination_num_rows").html("<a>ทั้งหมด <?php echo $pagination_num_rows;?> แถว</a>");
		
		/*#################################################
		Reset search result
		###################################################*/
		$("#clearSearch").click(function(){
			$.post("<?php echo base_url()?>?d=manage&c=room&m=search",{clear:"clear"},function(data,status){
				window.location="<?php echo base_url();?>?d=manage&c=room&m=edit";
			});
		}); 
		/*#################################################
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_room_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("edit_room_message");?>"); 
		<?php
		}?>
		
		active_tab();

		/*#################################################
		Tab menu link
		###################################################*/
		$("#add").on("click",function(){
			window.location="?d=manage&c=room&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=room&m=edit";
		});
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
	/*#################################################
	load data from controller
	###################################################*/
	function load_room(tid)
	{
		//show data in input
		$.ajax({
			url:"?d=manage&c=room&m=load_room",
			data:"tid="+tid,
			type:"POST",
			dataType:"json",
			success:function(resp){
				$("#input_room_name").val(resp.room_name);
				$("#select_room_type").val(resp.tb_room_type_id);
				tinymce.get('textarea_room_detail').setContent(htmlUnescape(resp.room_detail));
				$("#input_discount_percent").val(resp.discount_percent);
			},
			error:function(error){
				alert("Error : "+error);
			}
		});
		$("#input_room_name").focus();
	}
	function set_per_page(num)
	{
		$.post("<?php echo base_url()?>?d=manage&c=titlename&m=set_per_page",{num:num},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=room&m=edit";
		});
	}
	function show_del_list()
	{
		//show delete list in bootbox confirm
		var checked_num = $(".del_room:checked").length;
		var text = "ลบทั้งหมด "+checked_num+" รายการ?<br/>";
		text+="<ul>";
		$(".del_room").each(function(){
			if(this.checked)
			text+="<li>"+$(this).val()+" "+$("#room"+$(this).val()).text()+"</li>";
		});
		text+="</ul>";
		bootbox.confirm(text,function(result){
			if(result==true && checked_num>0)$("#form_del_room").submit();
		});
	}
	
	function select_orderby()
	{
		var select_field='<select id="orderby" class="form-control">';
		select_field+='<option value="room_id">รหัส ห้อง</option>';
		select_field+='<option value="room_name">ห้อง</option>';
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

						$.post("<?php echo base_url()?>?d=manage&c=room&m=set_orderby",{field:$("#orderby").val(),type:$("#ordertype").val()},function(data,status){
							window.location="<?php echo base_url();?>?d=manage&c=room&m=edit";
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
		$("#orderby").val("<?php echo $this->session->userdata("orderby_room")["field"];?>");
		$("#ordertype").val("<?php echo $this->session->userdata("orderby_room")["type"];?>");
	}
	function show_allow_list()
	{
		//show delete list in bootbox confirm
		var allow_list=new Array();
		var disallow_list=new Array();
		var allow_num = $(".allow_room0:checked").length;
		var disallow_num = $(".allow_room1:not(:checked)").length;

		//unchecked -> checked
		var text = "อนุมัติทั้งหมด "+allow_num+" รายการ?<br/>";
		text+="<ul>";
		$(".allow_room0:checked").each(function(){

				text+="<li>"+$(this).val()+" "+$("#room"+$(this).val()).text()+"</li>";
				allow_list.push($(this).val());

		});
		text+="</ul>";

		//checked -> unchecked
		var text2 = "ยกเลิกทั้งหมด "+disallow_num+" รายการ?<br/>";
		text2+="<ul>";
		$(".allow_room1:not(:checked)").each(function(){

				text2+="<li>"+$(this).val()+" "+$("#room"+$(this).val()).text()+"</li>";
				disallow_list.push($(this).val());

		});
		text2+="</ul>";
		bootbox.confirm(text+text2,function(result){
			if(result==true && (allow_num>0 || disallow_num>0))
			{
				$.post("<?php echo base_url()?>?d=manage&c=room&m=allow",{allow_list:allow_list,disallow_list:disallow_list},function(data,status){
					window.location="<?php echo base_url();?>?d=manage&c=room&m=edit";
				});
			}
		});
	}
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;