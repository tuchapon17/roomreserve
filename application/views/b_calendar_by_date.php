
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
		
		.fixed-table tr th:first-child, tr td:first-child, th:last-child, tr td:last-child{
			width:auto;
			text-align:left;
		}
		#table_bydate2{
			border:1px solid #ccc;
		}
		#table_bydate2 th, tr, td{
			border:1px solid #ccc;
			padding:0;
		}
		#table_bydate2 tr:nth-child(1) td{
			width:45px;
			overflow: hidden;
			text-align:center;
		}
		div[id^="divcontent2-"]:hover,div[id*=" divcontent2-"]:hover{
			background-color:#fff;
			cursor:pointer;
		}
		div[id^="divcontent2-"],div[id*=" divcontent2-"]{
			text-align:center;
			white-space: nowrap;
			overflow:hidden;
			position:absolute;
			border:1px solid #E4EFF8;
			background-color:#E4EFF8;
			box-shadow:inset 1px 1px 0 rgba(0,0,0,.1),inset -1px -1px 0 rgba(0,0,0,.07);
			!border-width:0 0 0 7px;
			text-overflow: ellipsis;
			line-height:2em;
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
      	<?php //echo $titlename_tab;?>				
      		 	<h2>วันที่<span id="cdate"></span></h2>
      			<div>
					<table id="table_bydate2">
						<tr>
							<td id="00">00.00</td><td id="01">01.00</td><td id="02">02.00</td><td id="03">03.00</td><td id="04">04.00</td><td id="05">05.00</td><td id="06">06.00</td><td id="07">07.00</td><td id="08">08.00</td><td id="09">09.00</td><td id="10">10.00</td><td id="11">11.00</td><td id="12">12.00</td><td id="13">13.00</td><td id="14">14.00</td><td id="15">15.00</td><td id="16">16.00</td><td id="17">17.00</td><td id="18">18.00</td><td id="19">19.00</td><td id="20">20.00</td><td id="21">21.00</td><td id="22">22.00</td><td id="23">23.00</td>
						</tr>
						<tr>
							<td colspan="24" class="content2"></td>
						</tr>
					</table>
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
	
	$(function(){
		
		//reverse Date from Y-m-d to d-m-Y
		var date1=getParameterByName("cdate").split('-');
		date1.reverse();
		var date_reversed=date1.join('-');
		$("#cdate").text(date_reversed);
		
		var likedate=getParameterByName("cdate");
		var dateRegex = /[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])/;
		if(dateRegex.test(likedate)==true)
		{
			var content2_height=0;
			$.ajax({
				url:"?c=b_calendar&m=getdatetime",
				data:{likedate:likedate},
				type:"POST",
				dataType:"json",
				success:function(resp){
					$.each(resp,function(i,item)
					{
						var	sBegin=resp[i].reserve_datetime_begin;
						var sEnd=resp[i].reserve_datetime_end;
						var year_start=sBegin.substr(0,4);
						var year_end=sEnd.substr(0,4);
							var month_start=sBegin.substr(5,2);
							var month_end=sEnd.substr(5,2);
								var date_start=sBegin.substr(8,2);
								var date_end=sEnd.substr(8,2);
						var hour_start=sBegin.substr(11,2);
						var hour_end=sEnd.substr(11,2);
							var min_start_string=sBegin.substr(14,2);
							var min_start=parseInt(sBegin.substr(14,2));
							var min_end_string=sEnd.substr(14,2);
							var min_end=parseInt(sEnd.substr(14,2));
	
						//var startDate = new Date(date_start+"/"+month_start+"/"+year_start+" "+hour_start+":"+min_start+":0");
						//var endDate = new Date(date_end+"/"+month_end+"/"+year_end+" "+hour_end+":"+min_end+":0");
						var startDate = new Date(year_start,month_start,date_start,hour_start,min_start);
						var endDate = new Date(year_end,month_end,date_end,hour_end,min_end);
	
						var diff=endDate-startDate; //diff in milliseconds
						s=diff;
						var ms = s % 1000;
						s = (s - ms) / 1000;
						var secs = s % 60;
						s = (s - secs) / 60;

						var a = $("#table_bydate2").parent().width();
						$("#table_bydate2 tr:nth-child(1) td").width(a/24);
						var w_td = $("#table_bydate2").width()/24;
						var ratio = w_td/60;//เดิมสูง 60px =60 min
	
						$(".content2").append("<div id='divcontent2-"+i+"' class='divbydate-"+resp[i].datetime_id+"'>"+hour_start+":"+min_start_string+" - "+hour_end+":"+min_end_string+"</div>");
						$("#divcontent2-"+i).offset({left:($("td#"+hour_start).offset().left+(min_start*ratio)),top:($("tr:nth-child(1)").offset().top+$("tr:nth-child(1)").height())});
						
						if($("#divcontent2-"+(i-1)).length > 0)
						{
							var prev_pos=$("#divcontent2-"+(i-1)).offset().top+$("#divcontent2-"+(i-1)).height();
							$("#divcontent2-"+i).offset({left:($("td#"+hour_start).offset().left+(min_start*ratio)),top:prev_pos});
						}
						//width each td = 47px (47/60=0.78333333)
						$("#divcontent2-"+i).css({width:(s*ratio)});
						content2_height+=$("#divcontent2-"+i).height();
						//show reserve detail
						$("#divcontent2-"+i).bind("click",function(){
							$.ajax({
								url:"?c=b_calendar&m=get_datetime_detail",
								data:{datetime_id:resp[i].datetime_id},
								type:"POST",
								dataType:"json",
								success:function(rs){
									var text='\
										<dl class="dl-horizontal">\
											<dt>รหัส</dt>\
											<dd>'+rs.reserve_id+'</dd>\
											<dt>ชื่อห้อง</dt>\
											<dd>'+rs.room_name+'</dd>\
											<dt>เริ่ม</dt>\
											<dd>'+rs.reserve_datetime_begin+'</dd>\
											<dt>สิ้นสุด</dt>\
											<dd>'+rs.reserve_datetime_end+'</dd>\
											<dt>ชื่อโครงการ</dt>\
											<dd>'+rs.project_name+'</dd>\
											<dt>จำนวนคน</dt>\
											<dd>'+rs.num_of_people+'</dd>\
											<dt></dt>\
											<dd></dd>\
											<dt></dt>\
											<dd></dd>\
											<dt></dt>\
											<dd></dd>\
											<dt></dt>\
											<dd></dd>\
											<dt></dt>\
											<dd></dd>\
											<dt></dt>\
											<dd></dd>\
											<dt></dt>\
											<dd></dd>\
										</dl>\
									';
									//bootbox.alert(text);
									bootbox.dialog({
										message: text,
										title: "",
										buttons: {
											success: {
												label: "ตกลง",
												className: "btn-primary",
												callback: function() {

												}
											},
											danger: {
												label: "รายละเอียดเพิ่มเติม",
												className: "btn-primary",
												callback: function() {
													window.open("<?php echo base_url();?>?d=manage&c=reserve&m=view&id="+rs.reserve_id,"_blank");
												}
											}
										}
									});
								},
								error:function(error){

								}
							});//ajax
						});//on click
					});//each
					$("td.content2").height(content2_height+2);
				},
				error:function(error){
					alert("Error : "+error);
				}
			});
			
		}//end if test regex
		
		/*#################################################
		Show bootbox alert
		###################################################*/
		<?php 
		if($this->session->flashdata("titlename_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("titlename_message");?>");
		<?php
		}?>
		
		active_tab();
		$("#add").on("click",function(){
			window.location="?d=manage&c=titlename&m=add";
		});
		$("#edit").on("click",function(){
			window.location="?d=manage&c=titlename&m=edit";
		});
	});
	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;