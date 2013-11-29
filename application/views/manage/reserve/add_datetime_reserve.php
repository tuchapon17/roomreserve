<?php 

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
    </style>
<?php
	echo $bodyopen;
	echo $navbar;
?>
<!-- Custom Content -->

    <div class="container">
      <div class="row">
      	<div class="col-lg-12">
      		<div class="col-lg-8 col-lg-offset-2" id="loginform">
				
      		 	<h2>กำหนดระยะเวลาการจอง</h2>
      		 	<div class="alert-danger" id="login-alert">
      			</div>
      			<form name="datetimeform" role="form" action="?d=manage&c=reserve&m=add_datetime" method="post">
					<fieldset class="scheduler-border">
						<legend class="scheduler-border"></legend>
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
					<button type="submit" class="btn btn-default">เพิ่ม</button>
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
	
	<script type="text/javascript">
	<!--
	
	$(function(){
		$("#span-time1").hide();
		$("#span-time2").hide();
		$("#reserve_time1").click(function(){
			if($("#reserve_time1").is(":checked"))$("#span-time1").show();$("#span-time2").hide();
		});
		$("#reserve_time2").click(function(){
			if($("#reserve_time2").is(":checked"))$("#span-time2").show();$("#span-time1").hide();
		});
		$("form[name='datetimeform']").submit(function(e){
			if($("#reserve_time1").is(":checked"))
			{
				$("#span-time1").show();
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
						if(compare_date(begindate[i],enddate[i]))
						{
							if(begindate[i]==enddate[i])
							{
								if(begintime[i]==endtime[i])
								{
									alertmessage+="<li>กรุณาตรวจสอบ เวลา</li>";
								}
							}
						}
						else alertmessage+="<li>กรุณากำหนดวันเริ่มต้น และวันสิ้นสุดให้ถูกต้อง</li>";
					}
				}
				bootbox.alert("<ul>"+alertmessage+"</ul>");
				//e.preventDefault();
			}
			else if($("#reserve_time2").is(":checked"))
			{
				$("#span-time2").show();
				var alertmessage='';
				var begindate=match_date($("input[name='input-begin-time2']").val());
				var enddate=match_date($("input[name='input-end-time2']").val());
				var begintime=match_time($("input[name='input-begin-time2']").val());
				var endtime=match_time($("input[name='input-end-time2']").val());
				var datestat=0;
				var timestat=0;
				if(compare_date(begindate,enddate))
				{
					if(begindate==enddate)
					{
						if(begintime==endtime)
						{
							alertmessage+="<li>กรุณาตรวจสอบ เวลา</li>";
						}
					}
					
				}
				else alertmessage+="<li>กรุณากำหนดวันเริ่มต้น และวันสิ้นสุดให้ถูกต้อง</li>";
				var daystat=0;
				$.each($("input[name='day-time2[]']"),function(){
					if($(this).is(':checked'))daystat++	
				});
				if(daystat==0)
				{
					alertmessage+="<li>กรุณาเลือกวัน</li>";
				}
				bootbox.alert("<ul>"+alertmessage+"</ul>");
				//e.preventDefault();
			}
			else
			{
				bootbox.alert("กรุณาเลือก ประเภทกำหนดการ");
				e.preventDefault();
			}
				
			
			
			
		});
		//alert(d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear());
		
		
		//validate date
		/*
		var startDate = new Date($('#startDate').val());
		var endDate = new Date($('#endDate').val());

		if (startDate < endDate){
		// Do something
		}
		*/
		
		$(document.body).on('click', '#del-time1' ,function(){
			$(this).parent().parent().remove();
		});
		$('#add-time1').click(function(){
			var num=parseInt($('fieldset .fieldset-time1').last().find('legend').text())+1;
			//$('fieldset .fieldset-time1:first').clone().appendTo('#span-time1');
			$('fieldset .fieldset-time1').last().after($('fieldset .fieldset-time1:first').clone());
			$('fieldset .fieldset-time1').last().find('div input[class="form-control"]').val('');	
			$('fieldset .fieldset-time1').last().find('legend').text(num);
			$('<br><div class="text-right"><i class="fa fa-minus-square fa-lg" id="del-time1"></i> ลบ</div>').appendTo('fieldset .fieldset-time1:last');
			init_datetimepicker();
		});
		init_datetimepicker();

		$('input[name="input-end"]').on("click",function(){
			alert($('#input-end').datetimepicker('getDate'));
		});
        

	
		
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

		
		
	});
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
		if(in_time.match(/(0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0])/))
			timeval=in_time.match(/(0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0])/)[0];
		//else timeval='';
		return timeval;
	}
	function compare_date(begindate,enddate)
	{
		if(begindate<=enddate)return true;
		else return false;
	}
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;