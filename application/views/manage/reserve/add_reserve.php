<?php 
$ci=&get_instance();
$ci->load->library("element_lib");
$eml=$ci->element_lib;
echo $htmlopen;
echo $head;
?>
    <!-- Custom styles -->
    <link href="<?php echo base_url();?>plugins/bootstrap3_datetime/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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
		.my-error-class {
		    color:#BB0000;  /* red */
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
      	<?php echo $reserve_tab;?>
      		<div class="col-lg-8 col-lg-offset-2" id="loginform">
				
      		 	<h2>จองห้อง</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	<?php
	      		 	$em_name=array(
	      		 			"input_std_id"=>"input_std_id",
							"input_phone"=>"input_phone",
							"input_num_of_people"=>"input_num_of_people",
							"input_project_name"=>"input_project_name",
							"textarea_for_use"=>"textarea_for_use",
							"select_faculty"=>"select_faculty",
							"select_department"=>"select_department",
							"select_job_position"=>"select_job_position",
							"select_room_type"=>"select_room_type",
							"select_room"=>"select_room",
							"select_office"=>"select_office"
	      		 	);
      		 		/*echo form_error($em_name["in_article"]);
      		 		echo form_error($em_name["se_article_type"]);
      		 		echo form_error($em_name["in_fee_unit_hour"]);
      		 		echo form_error($em_name["in_fee_unit_lump_sum"]);
      		 		echo form_error($em_name["in_fee_over_unit_lump_sum"]);*/
      		 	?>
      			</div>
      			<form role="form" action="?d=manage&c=reserve&m=add" method="post" id="reserve_add" enctype="multipart/form-data" autocomplete="off">  
      			<!--<form role="form" action="?c=test" method="post" id="reserve_add" enctype="multipart/form-data" autocomplete="off">-->
      			
      				<fieldset class="scheduler-border">
						<legend class="scheduler-border">ข้อมูลผู้จอง</legend>
						
						<?php 
						echo $se_person_type;
						echo $se_person;
						echo $se_faculty;
							echo "<fieldset class='scheduler-border'>".$in_faculty."</fieldset>";
						echo $se_department;
							echo "<fieldset class='scheduler-border'>".$in_department."</fieldset>";
						echo $se_job_position;
							echo "<fieldset class='scheduler-border'>".$in_job_position."</fieldset>";
						echo $se_office;
							echo "<fieldset class='scheduler-border'>".$in_office."</fieldset>";
						echo $in_std_id;
						echo $in_phone;
						?>
					</fieldset>
					<fieldset class="scheduler-border">
						<legend class="scheduler-border">มีความประสงค์ขอใช้</legend>
						<?php 
						echo $se_room_type;
						echo $se_room;
						echo $in_num_of_people;
						echo $te_for_use;
						?>
						
		               
		                
					</fieldset>
					<fieldset class="scheduler-border" id="used_article">
						<legend class="scheduler-border">ครุภัณฑ์/อุปกรณ์ที่ใช้</legend>
						<div class="checkbox">
						<label>
							<input type="checkbox" name="other_article_checkbox" value="">ครุภัณฑ์/อุปกรณ์ อื่นๆ
						</label>
						<span>
							<br/>
							<textarea name="other_article" class="form-control "></textarea>
						</span>
						</div>

					</fieldset>
	      			<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
						<?php 
						echo $in_project_name;
						//echo "<span id='".$em_name["in_article"]."_error' class='hidden'>".form_error($em_name["in_article"])."</span>";
						?>	
					</fieldset>
					
					
					<fieldset class="scheduler-border">
						<legend class="scheduler-border">กำหนดเวลา</legend>
						<div class="radio" id="div_time1">
							<label>
								<input type="radio" name="reserve_time" id="reserve_time1" value="reserve_time1">
								กำหนดระยะเวลา ระยะสั้น
							</label>
						</div>
						<span id="span-time1">
		                <fieldset class="scheduler-border fieldset-time1" >
		                	<legend class="scheduler-border">1</legend>
			                <label for="input-begin">วัน/เวลาเริ่ม <span class="red-text">*</span></label>
							<div class='input-group date datetimepickerBegin-time1'>
			                    <input type='text' class="form-control" name="input-begin-time1[]" readonly/>
			                    <span class="input-group-addon"><span class=""></span>
			                    </span>
			                </div>
			                <label for="input-begin">วัน/เวลาสิ้นสุด <span class="red-text">*</span></label>
							<div class='input-group date datetimepickerEnd-time1'>
			                    <input type='text' class="form-control" name="input-end-time1[]" readonly/>
			                    <span class="input-group-addon"><span class=""></span>
			                    </span>
			                </div>
			                
		                </fieldset>
		                <div class="text-right"><i class="fa fa-plus-square fa-lg" id="add-time1"></i> กำหนดระยะเวลาเพิ่มเติม</div>
		                </span>
		                
						<div class="radio" id="div_time2">
							<label>
								<input type="radio" name="reserve_time" id="reserve_time2" value="reserve_time2">
								กำหนดระยะเวลา ระยะยาว
							</label>
						</div>
						<span id="span-time2">
		                <fieldset class="scheduler-border fieldset-time2" >
			                <label for="input-begin">วัน/เวลาเริ่ม <span class="red-text">*</span></label>
							<div class='input-group date datetimepickerBegin-time2'>
			                    <input type='text' class="form-control" name="input-begin-time2" readonly/>
			                    <span class="input-group-addon"><span class=""></span>
			                    </span>
			                </div>
			                <label for="input-begin">วัน/เวลาสิ้นสุด <span class="red-text">*</span></label>
							<div class='input-group date datetimepickerEnd-time2'>
			                    <input type='text' class="form-control" name="input-end-time2" readonly/>
			                    <span class="input-group-addon"><span class=""></span>
			                    </span>
			                </div>
			            <span id="span-day-time2">
		                	<div class="checkbox">
								<label>
							    	<input type="checkbox" name="day-time2[]" value="0">อาทิตย์
								</label>
							</div>
							<div class="checkbox">
								<label>
							    	<input type="checkbox" name="day-time2[]" value="1">จันทร์
								</label>
							</div>
							<div class="checkbox">
								<label>
							    	<input type="checkbox" name="day-time2[]" value="2">อังคาร
								</label>
							</div>
							<div class="checkbox">
								<label>
							    	<input type="checkbox" name="day-time2[]" value="3">พุธ
								</label>
							</div>
							<div class="checkbox">
								<label>
							    	<input type="checkbox" name="day-time2[]" value="4">พฤหัสบดี
								</label>
							</div>
							<div class="checkbox">
								<label>
							    	<input type="checkbox" name="day-time2[]" value="5">ศุกร์
								</label>
							</div>
							<div class="checkbox">
								<label>
							    	<input type="checkbox" name="day-time2[]" value="6">เสาร์
								</label>
							</div>
		                </span>
		                </fieldset>
		                </span>
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
	<script type="text/javascript" src="<?php echo base_url();?>plugins/bootstrap3_datetime/js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>plugins/bootstrap3_datetime/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>plugins/bootstrap3_datetime/js/locales/bootstrap-datetimepicker.th.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.numeric.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>plugins/jquery-validation-1.11.1/localization/messages_th.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>plugins/jquery-validation-1.11.1/dist/additional-methods.min.js"></script>
	
	<script type="text/javascript">
	<!--

	$(function(){
		$.validator.addMethod("phone", function(value, element){
			return this.optional(element) || /^[0]{1}([0-9]{8}|[0-9]{9})+$/.test(value);
		}, "Please enter a valid phone number.");
		$.validator.addMethod("std_id", function(value, element){
			if($("#select_person").val()=='02')//นักศึกษา
			{
				if($("#select_person").val()=='02')//นักศึกษา
				{
					if(value.length<11)return false;
					else return true;
				}
			}
		}, "รหัสนักศึกษาไม่ถูกต้อง");
		$.validator.addMethod("faculty", function(value, element){
			if($("#select_person").val()=='02' || $("#select_person").val()=='01')//02นักศึกษา || 01อาจารย์
			{
				if($("#select_faculty").val()=='') return false;
				else return true;
			}
		}, "โปรดระบุ");
		$.validator.addMethod("otherfaculty", function(value, element){
			if($("#select_faculty").val()=='00')
			{
				if($("#input_faculty").val().length<1) return false;
				else return true;
			}
		}, "โปรดระบุคณะอื่นๆ");
		$.validator.addMethod("department", function(value, element){
			if($("#select_person").val()=='02' || $("#select_person").val()=='01')//02นักศึกษา || 01อาจารย์
			{
				if($("#select_department").val()=='') return false;
				else return true;
			}
		}, "โปรดระบุ");
		$.validator.addMethod("otherdepartment", function(value, element){
			if($("#select_department").val()=='00')
			{
				if($("#input_department").val().length<1) return false;
				else return true;
			}
		}, "โปรดระบุสาขา/งานอื่นๆ");
		$.validator.addMethod("job_position", function(value, element){
			if($("#select_person").val()=='03' || $("#select_person").val()=='01')//03ทั่วไป || 01อาจารย์
			{
				if($("#select_job_position").val()=='') return false;
				else return true;
			}
		}, "โปรดระบุ");
		$.validator.addMethod("otherjob_position", function(value, element){
			if($("#select_job_position").val()=='00')
			{
				if($("#input_job_position").val().length<1) return false;
				else return true;
			}
		}, "โปรดระบุตำแหน่งอื่นๆ");
		$.validator.addMethod("office", function(value, element){
			if($("#select_person").val()=='03')//03ทั่วไป
			{
				if($("#select_office").val()=='') return false;
				else return true;
			}
		}, "โปรดระบุ");
		$.validator.addMethod("otheroffice", function(value, element){
			if($("#select_office").val()=='00')
			{
				if($("#input_office").val().length<1) return false;
				else return true;
			}
		}, "โปรดระบุหน่วยงานอื่นๆ");
		$.validator.addMethod('filesize', function(value, element, param) {
		    // param = size (en bytes) 
		    // element = element to validate (<input>)
		    // value = value of the element (file name)
		    return this.optional(element) || (element.files[0].size <= param) 
		});

		
		$("#reserve_add").validate({
			lang:'th',
			errorClass: "my-error-class",
			rules: {
				"select_person_type": {
					required:true
				},
				"select_person":{
					required:true
				},
				"input_phone": {
					required:true,
					phone:true
				},
				"select_room_type":{
					required:true
				},
				"select_room":{
					required:true
				},
				"input_num_of_people":{
					required:true,
					digits:true
				},
				"textarea_for_use":{
					required:true
				},
				"input_project_name":{
					required:true
				},
				"input_std_id":{
					digits:true,
					std_id:true
				},
				"select_faculty":{
					required:true,
					faculty:true
				},
				"input_faculty":{
					otherfaculty:true
				},
				"select_department":{
					required:true,
					department:true
				},
				"input_department":{
					otherdepartment:true
				},
				"select_job_position":{
					job_position:true
				},
				"input_job_position":{
					otherjob_position:true
				},
				"select_office":{
					office:true
				},
				"input_office":{
					otheroffice:true
				},
				"project_file[]":{
					required:true,
					filesize:2097152,
					extension:"docx|doc|pdf"
				}
			},
			messages:{
				"select_person_type": {
					//required:"กรอกๆ"
				}
			}
		});




		/*#################################################
		* จำนวนครุภัณฑ์อุปกรณ์ : เฉพาะตัวเลข 
		###################################################*/
		$(document.body).on('focus', 'input[name="article_num[]"]' ,function(){
			$("input[name='article_num[]']").numeric({ decimal: false, negative: false });
		});

		/*#################################################
		* เมื่อ submit form การจอง
		###################################################*/
		$("#reserve_add").submit(function(e){
			
			var checked=0;
			$("input[name='article[]']").each(function(){
				if($(this).is(":checked"))
				{
					checked++;
					if($(this).parents().next().children('input').val().length<1)
					{
						$(this).parents().next().children('input').after("<label class='articlenum-error my-error-class'>โปรดระบุจำนวน</label>");
						e.preventDefault();
					}
				}
			});
			if(checked==0)
			{
				//alert("please check");
				if($("input[name='article[]']").length>0)
				{
					$("#used_article").prepend("<label class='article-error my-error-class'>โปรดเลือก</label>");
					e.preventDefault();
				}
			}
			
			//file upload
			$("input[name='project_file[]']").each(function(){
				var maxfilesize=2*1024*1024;//2MB
				var pdf="application/pdf";
				var docx="application/vnd.openxmlformats-officedocument.wordprocessingml.document";
				var doc="application/msword";
				var showtype=0;
				for(var i=0; i<this.files.length; i++)
				{
					if(this.files[i].type==doc){}
					else if(this.files[i].type==docx){}
					else if(this.files[i].type==pdf){}
					else
					{
						//$("label.file-error").remove();
						showtype=1;
						$(this).after("<div><label class='file-error my-error-class'>ตรวจสอบประเภทไฟล์</label></div>");
						e.preventDefault();
					}
					if(this.files[i].size>maxfilesize )//&& showtype==0
					{
						//$("label.file-error").remove();
						$(this).after("<div><label class='file-error my-error-class'>ตรวจสอบขนาดไฟล์</label></div>");
						e.preventDefault();
					}
				}
			});
			//check each file for multiple selected files
			/*$(document.body).on('change', '#project_file' ,function(){
				for(var i=0; i<this.files.length; i++)
				{
					alert(this.files[i].type);
				}
			});*/
			
			/*
			* for datetime
			*/
			if($("#reserve_time1").is(":checked"))
			{
				$("#span-time1").show();
				var message=new Array();
				var alertmessage='';
				var begindate=new Array();
				var enddate=new Array();
				var begintime=new Array();
				var endtime=new Array();
				$.each($("input[name='input-begin-time1[]']"),function(i,value){
					//alert($(this).val().match(/(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}/)[0]+"----"+i);
					begindate[i]=match_date($(this).val());
					begintime[i]=match_time($(this).val());
				});
				$.each($("input[name='input-end-time1[]']"),function(i,value){
					//alert($(this).val().match(/(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}/)[0]+"----"+i);
					enddate[i]=match_date($(this).val());
					endtime[i]=match_time($(this).val());
				});
				
				if(begindate.length==enddate.length)
				{
					var datestat=0;
					for(var i=0;i<begindate.length;i++)
					{
						//วันเริ่มเท่ากับวันสิ้นสุด มากว่าหรือน้อยกว่าไม่ได้
						if(begindate[i]==enddate[i])
						//if(compare_date(begindate[i],enddate[i]))
						{
							if(begindate[i]==enddate[i])
							{
								if(begintime[i]==endtime[i])
								{
									message[i]="โปรดตรวจสอบ เวลาเริ่มต้น และเวลาสิ้นสุด";
								}
							}
						}
						else 
						{
							message[i]="โปรดตรวจสอบวันเริ่มต้น และวันสิ้นสุด";
						}
					}
				}
				//error message
				$.each(message,function(index,val){
					if(val)
					{
						$(".fieldset-time1").each(function(){
							if($(this).find('legend').text()==(index+1))
							{
								$(this).find('.datetimepickerEnd-time1').after("<label class='my-error-class'>"+val+"</label>");
							}
						});
						e.preventDefault();
					}
				});
			}
			else if($("#reserve_time2").is(":checked"))
			{
				$("#span-time2").show();
				var alertmessage='';
				var begindate=match_date($("input[name='input-begin-time2']").val());
				var enddate=match_date($("input[name='input-end-time2']").val());
				var begintime=match_time($("input[name='input-begin-time2']").val()).toString();
				var endtime=match_time($("input[name='input-end-time2']").val()).toString();
				var datestat=0;
				var timestat=0;
				if(begindate<=enddate)
				{
					if(begindate==enddate)
					{
						if(begintime==endtime)
						{
							//alertmessage+="<li>กรุณาตรวจสอบ เวลา</li>";
							$(".datetimepickerEnd-time2").after("<label class='my-error-class'>โปรดตรวจสอบ เวลาเริ่มต้น และเวลาสิ้นสุด</label>");
							e.preventDefault();
						}
					}
					else
					{
						if(begintime>endtime)
						{
							$(".datetimepickerEnd-time2").after("<label class='my-error-class'>โปรดตรวจสอบ เวลาเริ่มต้น และเวลาสิ้นสุด</label>");
							e.preventDefault();
						}
					}
				}
				else
				{
					$(".datetimepickerEnd-time2").after("<label class='my-error-class'>โปรดตรวจสอบวันเริ่มต้น และวันสิ้นสุด</label>");
					//alertmessage+="<li>กรุณากำหนดวันเริ่มต้น และวันสิ้นสุดให้ถูกต้อง</li>";
					e.preventDefault();
				}
				var daystat=0;
				$.each($("input[name='day-time2[]']"),function(){
					if($(this).is(':checked'))daystat++	
				});
				if(daystat==0)
				{
					//alertmessage+="<li>กรุณาเลือกวัน</li>";
					$("#span-day-time2").find(".checkbox").last().after("<label class='my-error-class'>โปรดเลือกอย่างน้อยหนึ่งวัน</label>");
					e.preventDefault();
				}
				//bootbox.alert("<ul>"+alertmessage+"</ul>");
				//e.preventDefault();
			}
			else
			{
				$("#span-time2").after("<label class='my-error-class'>โปรดเลือก</label>");
				//bootbox.alert("กรุณาเลือก ประเภทกำหนดการ");
				e.preventDefault();
			}
			
			//------------------------------------------------------
		});//end on submit event

		

		
		
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
		Show bootbox alert after 
		###################################################*/
		<?php 
		if($this->session->flashdata("article_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("article_message");?>"); 
		<?php
		}?>
		
		active_tab();
		$("#add").on("click",function(){
			window.location="?d=manage&c=article&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=article&m=edit";
		});

		
		
		

		
		
		
		

		
		/*----------------------------------- 
		* ข้อมูลผู้จอง
		-----------------------------------*/
		
		/*
		*แสดงข้อมูลบุคคลใน dropdown (Get person list)
		*/
		$("#select_person_type").on("keyup change",function(){
			if($(this).find("option:selected").val()!=""){
				$.ajax({
					url:"?d=manage&c=reserve&m=select_person_list",
					data:{person_type_id:$(this).find("option:selected").val()},
					type:"POST",
					dataType:"json",
					success:function(resp){
						$("#select_person").find("option:gt(0)").remove();
						if(resp.person_list!=null)$("#select_person").append(resp.person_list);
					},
					error:function(error){
						alert("Error : "+error);
					}
				});
			}
			else
			{
				$("#select_person").find("option:gt(0)").remove();
			}
		});
		//ถ้ามีการเลือกอยู่แล้วตอนเปิดหน้า ให้ทำการเรียกใช้ event
		if($("#select_person_type").find("option:selected").val()!="")
		{
			$("#select_person_type").trigger("change");
		}

		/*
		*แสดง/ซ่อน คณะ (faculty)
		*/
		//add id to fieldset
		$("#input_faculty").parent('div').parent('fieldset').attr('id','otherfaculty');
		//แสดง/ซ่อน input อื่นๆ
		$("#select_faculty").on("keyup change",function(){
			if($(this).find('option:selected').val()=="00")
			{
				$("#otherfaculty").show();
			}
			else
			{
				$("#input_faculty").val('');
				$("#otherfaculty").hide();
			}
		});

		/*
		*แสดง/ซ่อน สาขา/งาน (department)
		*/
		//add id to fieldset
		$("#input_department").parent('div').parent('fieldset').attr('id','otherdepartment');
		//แสดง/ซ่อน input อื่นๆ
		$("#select_department").on("keyup change",function(){
			if($(this).find('option:selected').val()=="00")
			{$("#otherdepartment").show();}
			else
			{
				$("#input_department").val('');
				$("#otherdepartment").hide();
			}
		});

		/*
		*แสดง/ซ่อน ตำแหน่งงาน (job_position)
		*/
		//add id to fieldset
		$("#input_job_position").parent('div').parent('fieldset').attr('id','otherjob_position');
		//แสดง/ซ่อน input อื่นๆ
		$("#select_job_position").on("keyup change",function(){
			if($(this).find('option:selected').val()=="00")
			{$("#otherjob_position").show();}
			else
			{
				$("#input_job_position").val('');
				$("#otherjob_position").hide();
			}
		});

		/*
		*แสดง/ซ่อน หน่วยงาน (office)
		*/
		//add id to fieldset
		$("#input_office").parent('div').parent('fieldset').attr('id','otheroffice');
		//แสดง/ซ่อน input อื่นๆ
		$("#select_office").on("keyup change",function(){
			if($(this).find('option:selected').val()=="00")
			{$("#otheroffice").show();}
			else
			{
				$("#input_office").val('');
				$("#otheroffice").hide();
			}
		});

		//reset dropdown
		$("#select_person").on("keyup change",function(){
			$("#select_faculty").val('');
			$("#select_department").val('');
			$("#select_job_position").val('');
			$("#select_office").val('');
		});

		hide_in_ex();
		$("#select_person_type").on("keyup change",function(){ hide_in_ex(); });
		$("#select_person").on("keyup change",function(){
			hide_in_ex();
			//อาจารย์
			if($(this).find("option:selected").val()=="01")person_in_staff();
			//student
			else if($(this).find("option:selected").val()=="02")person_in_std();
			//บุคคลภายนอก
			else if($(this).find("option:selected").val()=="03")person_ex();
		});

		/*----------------------------------- 
		* มีความประสงค์ขอใช้
		-----------------------------------*/
		/*
		*แสดงข้อมูลห้องใน dropdown (Get room list)
		*/
		$("#select_room_type").on("keyup change",function(){
			if($(this).find("option:selected").val()!=""){
				$.ajax({
					url:"?d=manage&c=reserve&m=select_room_list",
					data:{room_type_id:$(this).find("option:selected").val()},
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
		//ถ้ามีการเลือกอยู่แล้วตอนเปิดหน้า ให้ทำการเรียกใช้ event
		if($("#select_room_type").find("option:selected").val()!="")
		{
			$("#select_room_type").trigger('change');
		}

		/*----------------------------------- 
		* ครุภัณฑ์/อุปกรณ์ที่ใช้
		-----------------------------------*/
		/*
		*แสดงรายชื่ออุปกรณ์ของห้องที่เลือก (Get room_has_article)
		*/
		$("#select_room").on("keyup change",function(){
			if($(this).find("option:selected").val()!=""){
				$.ajax({
					url:"?d=manage&c=reserve&m=get_room_has_article",
					data:{room_id:$(this).find("option:selected").val()},
					type:"POST",
					dataType:"json",
					success:function(resp){
						$.each(resp,function(index,value){
							$("#used_article").prepend(value);
						});
					},
					error:function(error){
						alert("Error : "+error);
					}
				});
			}
			else{}
		});

		/*
		เมื่อมีการเลือกห้องอื่น ให้ลบ checkbox เดิมออก (Remove all checkbox in #used_article)
		*/
		$("#select_room_type , #select_room").on("keyup change",function(){
			$("#used_article").children(".del-checkbox").each(function(){
				$(this).remove();
			});
		});

		/*
		เมื่อคลิกเลือกอุปกรณ์ ถ้ายังไม่มีเลือกอุปกรณ์ใดๆ ให้แสดงข้อความเตือน
		เมื่อมีการเลือกหลังแสดงข้อความเตือนให้ลบข้อความเตือนออก
		*/
		$(document.body).on('click', 'input[name="article[]"]' ,function(){
			var checked=0;
			$("input[name='article[]']").each(function(){
				if($(this).is(":checked"))
				{
					$("label.article-error").remove();
					checked++;
				}
			});
			if(checked==0)
			{
				$("#used_article").prepend("<label class='myerror my-error-class'>โปรดเลือก</label>");
				//e.preventDefault();
			}
		});

		/*
		เมื่อมีการเลือกอุปกรณ์ ให้ทำการเพิ่ม input สำหรับระบุจำนวนอุปกรณ์
		*/
		$(document.body).on('change', '#used_article input[type="checkbox"][name="article[]"]' ,function(){
			if(this.checked)
			{	
				var oldtext=$(this).parent().text();
				var html='<span class="input_num"><br/>ระบุจำนวน';
				html+='<input type="text" name="article_num[]" class="form-control" maxlength="4"></span>';
				$(this).parent().after(html);
			}
			else
			{
				$(this).parent().parent().find('span[class="input_num"]').remove();
			}
		});

		/*----------------------------------- 
		* ข้อมูลเกี่ยวกับโครงการ
		-----------------------------------*/
		//add upload file
		$('#select_person_type').on('change keyup',function(){
			if($(this).find("option:selected").val()=="01")
			{
				if(!$("div").hasClass("div_project_file"))
				{
					var html='<div class="form-group div_project_file">';
					html+='<label for="project_file">ไฟล์เอกสารโครงการ</label>';
					html+='<input type="file" id="project_file" multiple name="project_file[]">';
					html+='</div>';
					//html+='<div class="div_project_file"><i class="fa fa-plus-square fa-lg" id="plusfile"></i></div>';
					$("input#input_project_name").parent().after(html);
				}
			}
			else $(".div_project_file").remove();
		});
		if($('#select_person_type').find("option:selected").val()=="01")
		{
			$('#select_person_type').trigger("change");
		}
		$(document.body).on('click', '#plusfile' ,function(){
			var html='<div class="form-group div_project_file">';
			//html+='<label for="project_file">ไฟล์เอกสารโครงการ</label><i class="fa fa-minus-square fa-lg" id="minusfile"></i>';
			html+='<label for="project_file">ไฟล์เอกสารโครงการ</label>';
			html+='<input type="file" id="project_file" name="project_file[]">';
			html+='</div>';
			$(this).before(html);
		});
		//เพิ่ม input file upload
		$(document.body).on('click', '#minusfile' ,function(){
			$(this).parent().remove();
		});
		
		/*----------------------------------- 
		* กำหนดเวลา
		-----------------------------------*/
		//for datetime
		$("#span-time1").hide();
		$("#span-time2").hide();
		$("#reserve_time1").click(function(){
			if($("#reserve_time1").is(":checked"))$("#span-time1").show();$("#span-time2").hide();
		});
		$("#reserve_time2").click(function(){
			if($("#reserve_time2").is(":checked"))$("#span-time2").show();$("#span-time1").hide();
		});

		$(document.body).on('click', '#del-time1' ,function(){
			$(this).parent().parent().remove();
		});
		$('#add-time1').click(function(){
			
			var num=parseInt($('fieldset .fieldset-time1').last().find('legend').text())+1;
			//$('fieldset .fieldset-time1:first').clone().appendTo('#span-time1');
			$('fieldset .fieldset-time1').last().after($('fieldset .fieldset-time1:first').clone());
			$('fieldset .fieldset-time1').last().find('div input[class="form-control"]').val('');	
			$('fieldset .fieldset-time1').last().find('legend').text(num);
			$('fieldset .fieldset-time1').last().find('label.my-error-class').remove();
			$('<br><div class="text-right"><i class="fa fa-minus-square fa-lg" id="del-time1"></i> ลบ</div>').appendTo('fieldset .fieldset-time1:last');
			init_datetimepicker();
		});
		init_datetimepicker();

		$('input[name="input-end"]').on("click",function(){
			alert($('#input-end').datetimepicker('getDate'));
		});

		//------------------------------------------------------


		//test zone
		
	});
	function hide_in_ex()
	{
		$("#select_faculty").parent().hide();
		$("#select_department").parent().hide();
		$("#select_job_position").parent().hide();
		$("#input_std_id").parent().hide();
		$("#select_office").parent().hide();
		$("#otherfaculty").hide();
		$("#otherdepartment").hide();
		$("#otherjob_position").hide();
		$("#otheroffice").hide();
	}
	function person_in_staff()
	{
		$("#select_faculty").parent().show();
		$("#select_department").parent().show();
		$("#select_job_position").parent().show();
	}
	function person_in_std()
	{
		$("#select_faculty").parent().show();
		$("#select_department").parent().show();
		$("#input_std_id").parent().show();
	}
	function person_ex()
	{
		$("#select_job_position").parent().show();
		$("#select_office").parent().show();
	}

	/*#################################################
	* for datetime
	###################################################*/
	function init_datetimepicker()
	{
		$('.datetimepickerBegin-time1').datetimepicker({
			pick12HourFormat: false,
            language: 'th',
            icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			format:"LLLL"
        });
		$('.datetimepickerEnd-time1').datetimepicker({
			pick12HourFormat: false,
            language: 'th',
            icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			format:"LLLL"
        });
		$('.datetimepickerBegin-time2').datetimepicker({
			pick12HourFormat: false,
            language: 'th',
            icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			format:"LLLL"
        });
		$('.datetimepickerEnd-time2').datetimepicker({
			pick12HourFormat: false,
            language: 'th',
            icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			format:"LLLL"
        });
	}
	function match_date(in_date)
	{
		var dateval;
		if(in_date.match(/(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}/))
			dateval=in_date.match(/(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}/)[0];
		//else dateval='';
		return dateval;
	}
	function match_time(in_time)
	{
		var timeval;
		var regex=/(0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0])/;
		if(in_time.match(regex))
			timeval=in_time.match(regex)[0];
		//else timeval='';
		return timeval;
	}
	function compare_date(begindate,enddate)
	{
		if(begindate<=enddate)return true;
		else return false;
	}

	//------------------------------------------------------
	
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;