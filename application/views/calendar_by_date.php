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
		.table_bydate th, tr, td{
			border:1px solid #ccc;
			padding:0;
		}
		.table_bydate tr{
			height:60px;
		}
		.table_bydate td.content{
			width:100%;
		}
		.divcontent{
			position:absolute;
			z-index:99;
			top:0;
			border:1px solid red;
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
      		<div class="col-lg-10 col-lg-offset-1" id="loginform">
				
      		 	<h2>ปฏิทิน วันที่...</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	
      			</div>
				<table class="table_bydate">
					<tr id="00">
						<td>00.00</td>
						<td class="content"></td>
					</tr>
					<tr id="01">
						<td>01.00</td>
						<td class="content"></td>
					</tr>
					<tr id="02">
						<td>02.00</td>
						<td class="content"></td>
					</tr>
					<tr id="03">
						<td>03.00</td>
						<td class="content"></td>
					</tr>
					<tr id="04">
						<td>04.00</td>
						<td class="content"></td>
					</tr>
					<tr id="05">
						<td>05.00</td>
						<td class="content"></td>
					</tr>
					<tr id="06">
						<td>06.00</td>
						<td class="content"></td>
					</tr>
					<tr id="07">
						<td>07.00</td>
						<td class="content"></td>
					</tr>
					<tr id="08">
						<td>08.00</td>
						<td class="content"></td>
					</tr>
					<tr id="09">
						<td>09.00</td>
						<td class="content"></td>
					</tr>
					<tr id="10">
						<td>10.00</td>
						<td class="content"></td>
					</tr>
					<tr id="11">
						<td>11.00</td>
						<td class="content"></td>
					</tr>
					<tr id="12">
						<td>12.00</td>
						<td class="content"></td>
					</tr>
					<tr id="13">
						<td>13.00</td>
						<td class="content"></td>
					</tr>
					<tr id="14">
						<td>14.00</td>
						<td class="content"></td>
					</tr>
					<tr id="15">
						<td>15.00</td>
						<td class="content"></td>
					</tr>
					<tr id="16">
						<td>16.00</td>
						<td class="content"></td>
					</tr>
					<tr id="17">
						<td>17.00</td>
						<td class="content"></td>
					</tr>
					<tr id="18">
						<td>18.00</td>
						<td class="content"></td>
					</tr>
					<tr id="19">
						<td>19.00</td>
						<td class="content"></td>
					</tr>
					<tr id="20">
						<td>20.00</td>
						<td class="content"></td>
					</tr>
					<tr id="21">
						<td>21.00</td>
						<td class="content"></td>
					</tr>
					<tr id="22">
						<td>22.00</td>
						<td class="content"></td>
					</tr>
					<tr id="23">
						<td>23.00</td>
						<td class="content"></td>
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
	<!--
	$(function(){
		var likedate="2013-12-10";
		$.ajax({
			url:"?c=calendar&m=testdate",
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
						var min_start=parseInt(sBegin.substr(14,2));
						var min_end=parseInt(sEnd.substr(14,2));

					var startDate = new Date(date_start+"/"+month_start+"/"+year_start+" "+hour_start+":"+min_start);
					var endDate = new Date(date_end+"/"+month_end+"/"+year_end+" "+hour_end+":"+min_end);

					var diff=endDate-startDate; //diff in milliseconds
					s=diff;
					var ms = s % 1000;
					s = (s - ms) / 1000;
					var secs = s % 60;
					s = (s - secs) / 60;
					$("body").append("<div id='divcontent"+i+"'>"+sBegin+sEnd+"</div>");
					//ต่อไปก็ find last div และจับวางต่อๆกัน
					$("#divcontent"+i).css({position:"absolute",border:"1px solid red"});
					$("#divcontent"+i).offset({left:($("tr#"+hour_start).offset().left+$("tr td:first").width()),top:$("tr#"+hour_start).offset().top+min_start});
					//$("#testdiv2").offset({left:($("#testdiv").offset().left+$("#testdiv").width()),top:$("tr#"+hour_start).offset().top});
					$("#divcontent"+i).height(s-2);
				});
				
			},
			error:function(error){
				alert("Error : "+error);
			}
		});
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
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;