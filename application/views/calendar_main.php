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
		/*
		.table-calendar{
			!width:100%;
			border:1px solid #ccc;
		}
		.table-calendar td,th{
			width:120px;
			border:1px solid #ccc;
		}
		.table-calendar th{
			text-align:center;
		}
		.table-calendar tr:nth-child(2){
			text-align:center;
			font-weight:bold;
		}
		.table-calendar tr td:first-child, tr td:last-child{
			width:120px;
		}
		.table-calendar tr:nth-child(3) td,tr:nth-child(4) td,tr:nth-child(5) td,tr:nth-child(6) td,tr:nth-child(7) td,tr:nth-child(8) td{
			height:100px;
			text-align:right;
			vertical-align:top;
		}*/
		.highlight{
			font-weight:bold;
			text-decoration:underline;
		}
		.table-calendar tr td:last-child{
			color:red;
		}
		.table-calendar tr:nth-child(2){
			font-weight:bold;
		}
		.table-calendar tr td:first-child, tr td:last-child{
			width:auto;
		}
		
		
		.table-calendar {
		overflow:hidden;
		border:1px solid #d3d3d3;
		background:#fefefe;
		width:100%;
		margin:0% auto 0;
		-moz-border-radius:5px; /* FF1+ */
		-webkit-border-radius:5px; /* Saf3-4 */
		border-radius:5px;
		!-moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
		!-webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
		}
	
		.table-calendar th, td {padding:0px; text-align:center; }
		
		.table-calendar th {padding-top:0px; !background:#e8eaeb;}
		
		.table-calendar td {border-top:1px solid #e0e0e0; border-right:1px solid #e0e0e0;}
		
		.table-calendar tr {}
		
		.table-calendar td.first, th.first {!text-align:left}
		
		.table-calendar td.last {border-right:none;}
		
		/*
		I know this is annoying, but we need additional styling so webkit will recognize rounded corners on background elements.
		Nice write up of this issue: http://www.onenaught.com/posts/266/css-inner-elements-breaking-border-radius
		
		And, since we've applied the background colors to td/th element because of IE, Gecko browsers also need it.
		*/
		
		.table-calendar tr:first-child th.first {
			-moz-border-radius-topleft:5px;
			-webkit-border-top-left-radius:5px; /* Saf3-4 */
		}
		
		.table-calendar tr:first-child th.last {
			-moz-border-radius-topright:5px;
			-webkit-border-top-right-radius:5px; /* Saf3-4 */
		}
		
		.table-calendar tr:last-child td.first {
			-moz-border-radius-bottomleft:5px;
			-webkit-border-bottom-left-radius:5px; /* Saf3-4 */
		}
		
		.table-calendar tr:last-child td.last {
			-moz-border-radius-bottomright:5px;
			-webkit-border-bottom-right-radius:5px; /* Saf3-4 */
		}
		.table-calendar tr:not(:nth-child(2)) td{
			vertical-align:top;
			text-align:left;
		}
		.reserve_detail{
			border:1px solid #ccc;
			padding:5px;
		}
		.time-small-begin{
			text-align:right;
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
				
      		 	<h2>ปฏิทิน</h2>
      		 	<div class="alert-danger" id="login-alert">
      		 	
      			</div>
      			<?php echo $calendar;?>
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

		/*$(".table-calendar td").on("mouseover",function(){
			$(this).css("background-color","red");
		},function(){
			$(this).css("background-color","green");
		});*/
		/*$(".table-calendar td").on("",function(){
			$(this).css("background-color","none");
		});*/
		$(".table-calendar tr:not(:nth-child(2)) td").css("height",$(".table-calendar").height()/3);
		$(".table-calendar td").css("width",$(".table-calendar").width()/7);
		$(".table-calendar tr:not(:nth-child(2)) td").hover(function(){
			$(this).css("background-color","#ACD7FC");
		},function(){
			$(this).css("background-color","");
		});
		$("span.date").parent().click(function(){
			var get_date=$(this).children("span.date").attr("id");
			var ym=get_date.substr(0,8);
			var d=get_date.substr(8,2);
			if(d.length==1) d="0"+d;
			$.ajax({
				url:"?c=calendar&m=get_date_detail",
				data:{ymd:ym+d},
				type:"POST",
				dataType:"json",
				success:function(resp){
					//alert(resp.reserve_datetime_begin);
					var datetimetext="";
					datetimetext+="";
					$.each(resp,function(i,item)
					{
						datetimetext+="<blockquote>";
						datetimetext+="โครงการ "+resp[i].project_name+"";
						datetimetext+="<small>ห้อง "+resp[i].room_name+"</small>";
						datetimetext+="<small>วัน/เวลา "+resp[i].reserve_datetime_begin+" ถึง "+resp[i].reserve_datetime_end+"</small>";
						datetimetext+="</blockquote>";
					});
					datetimetext+="";
					if(datetimetext!="")bootbox.alert(datetimetext);
				},
				error:function(error){
					alert("Error : "+error);
				}
			});
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