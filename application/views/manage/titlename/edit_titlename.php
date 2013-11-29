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
		#search_titlename_div{
			padding:0px;
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
      		<div class="col-lg-12" id="loginform">
      		 	<h2>แก้ไขคำนำหน้าชื่อ</h2>
      		 	<form role="form" class="form-inline" action="?d=manage&c=titlename&m=search" method="post">
      		 		<?php echo $manage_search_box;?>
      		 	</form>
      		 	<!--<form role="form" class="form-inline" action="?d=manage&c=titlename&m=search" method="post">
				<div class="input-group col-lg-6 col-lg-offset-6 search-box" id="search_titlename_div">
					<span class="input-group-btn">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						แสดงข้อมูล<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" onclick="set_per_page(3)">3แถว</a></li>
							<li><a href="#" onclick="set_per_page(5)">5 แถว</a></li>
							<li><a href="#" onclick="set_per_page(10)">10 แถว</a></li>
							<li><a href="#" onclick="set_per_page(15)">15 แถว</a></li>
							<li><a href="#" onclick="set_per_page(20)">20 แถว</a></li>
							<li><a href="#" onclick="set_per_page(50)">50 แถว</a></li>
						</ul>
					</span>
					<input type="text" maxlength="30" value="<?php echo $session_search_titlename;?>" placeholder="ค้นหา" id="input_titlename_search" name="input_titlename_search" class="form-control ">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary"><img src="<?php echo base_url()?>images/glyphicons_free/glyphicons/png/glyphicons_027_search.png" width="15"></span></button>
						<button type="button" class="btn btn-warning" id="clearSearch"><img src="<?php echo base_url()?>images/glyphicons_free/glyphicons/png/glyphicons_197_remove.png" width="15"></span>
					</span>
				</div>
      		 	</form>-->
      		 	<?php echo $table_edit;?>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php 
	      		 	$em_name=array(
	      		 			"in_titlename"=>"input_titlename"
	      		 	);
      		 		echo form_error($em_name["in_titlename"]);
      		 	?>
      			</div>
      			
      			<form role="form" action="?d=manage&c=titlename&m=edit" method="post">
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
						<?php
						echo $in_titlename;
						echo "<span id='".$em_name["in_titlename"]."_error' class='hidden'>".form_error($em_name["in_titlename"])."</span>";
						
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
		$("#del_all_titlename").click(function(e){
			if(this.checked)
			{
				$(".del_titlename").prop("checked",true);
			}
			else $(".del_titlename").prop("checked",false);		
		});
		
		/*#################################################
		add num_rows to pagination 
		###################################################*/
		$("#pagination_num_rows").html("<a>ทั้งหมด <?php echo $pagination_num_rows;?> แถว</a>");
		
		/*#################################################
		Reset search result
		###################################################*/
		$("#clearSearch").click(function(){
			$.post("<?php echo base_url()?>?d=manage&c=titlename&m=search",{clear:"clear"},function(data,status){
				window.location="<?php echo base_url();?>?d=manage&c=titlename&m=edit";
			});
		}); 
		/*#################################################
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_titlename_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("edit_titlename_message");?>"); 
		<?php
		}?>
		
		active_tab();

		/*#################################################
		Tab menu link
		###################################################*/
		$("#add").on("click",function(){
			window.location="?d=manage&c=titlename&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=titlename&m=edit";
		});
		$("#delete").on("click",function(){
			window.location="?d=manage&c=titlename&m=delete";
		});
	});
	
	function load_titlename(tid)
	{
		//show data in input
		$.ajax({
			url:"?d=manage&c=titlename&m=load_titlename",
			data:"tid="+tid,
			type:"POST",
			dataType:"json",
			success:function(resp){
				$("#input_titlename").val(resp.titlename);
			},
			error:function(error){
				alert("Error : "+error);
			}
		});
		$("#input_titlename").focus();
	}
	function set_per_page(num)
	{
		$.post("<?php echo base_url()?>?d=manage&c=titlename&m=set_per_page",{num:num},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=titlename&m=edit";
		});
	}
	function show_del_list()
	{
		//show delete list in bootbox confirm
		var checked_num = $(".del_titlename:checked").length;
		var text = "ลบทั้งหมด "+checked_num+" รายการ?<br/>";
		text+="<ul>";
		$(".del_titlename").each(function(){
			if(this.checked)
			text+="<li>"+$(this).val()+" "+$("#titlename"+$(this).val()).text()+"</li>";
		});
		text+="</ul>";
		bootbox.confirm(text,function(result){
			if(result==true && checked_num>0)$("#form_del_titlename").submit();
		});
	}
	function set_orderby(field)
	{
		<?php 
		if($this->session->userdata("orderby_titlename")["type"]=="ASC") $type="DESC";
		else if($this->session->userdata("orderby_titlename")["type"]=="DESC") $type="ASC"
		?>
		$.post("<?php echo base_url()?>?d=manage&c=titlename&m=set_orderby",{field:field,type:"<?php echo $type;?>"},function(data,status){
			window.location="<?php echo base_url();?>?d=manage&c=titlename&m=edit";
		});
	}
	function select_orderby()
	{
		var select_field='<select id="orderby" class="form-control">';
		select_field+='<option value="titlename_id">รหัสคำนำหน้าชื่อ</option>';
		select_field+='<option value="titlename">คำนำหน้าชื่อ</option>';
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
						$.post("<?php echo base_url()?>?d=manage&c=titlename&m=set_orderby",{field:$("#orderby").val(),type:$("#ordertype").val()},function(data,status){
							window.location="<?php echo base_url();?>?d=manage&c=titlename&m=edit";
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
		$("#orderby").val("<?php echo $this->session->userdata("orderby_titlename")["field"];?>");
		$("#ordertype").val("<?php echo $this->session->userdata("orderby_titlename")["type"];?>");
	}
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;