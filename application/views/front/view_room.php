
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
		#search-arrow{
			float:right;
			cursor:pointer;
		}
		.room-pic{
			cursor:pointer;
		}
    </style>
<?php
	echo $bodyopen;
	echo $navbar;
	$rl=$get_room_list[0];
?>
<!-- Custom Content -->
    <div class="container">
      <div class="row">
      	
      	<div class="col-lg-12">
      		<h2>ข้อมูลห้อง</h2>
      		<div class="panel panel-default">
				<div class="panel-heading" id="search-heading">
					<h3 class="panel-title">เลือกห้อง<div id="search-arrow"><i class="fa fa-caret-square-o-down"></i></div></h3>
				</div>
				<div class="panel-body" id="search-body">
					<?php echo $form_select_room;?>
				</div>
			</div>
      	</div>
      	<!--
      	<div class="col-lg-12">
			<div style="float:left;"><button id="room-prev" class="btn btn-default" type="button"><i class="fa fa-angle-double-left"></i></button></div>
			<div style="float:right;"><button id="room-next" class="btn btn-default" type="button"><i class="fa fa-angle-double-right"></i></button></div>
		</div>
		-->
      	<div class="col-lg-6">
      		<dl class="dl-horizontal">			
	      		<dt>ชื่อห้อง</dt>
	      		<dd><?php echo $rl['room_name'];?></dd>
	      		<dt>ประเภทห้อง</dt>
	      		<dd><?php echo $rl['room_type_name'];?></dd>
	      		<dt>สถานะ</dt>
	      		<dd><?php 
	      			if($rl['room_status']==0)echo "<span class='text-danger'>ปิดให้บริการ</span>";
	      			else echo "<span class='text-success'>เปิดให้บริการ</span>";
	      		?></dd>
	      		<dt>ส่วนลด (%)</dt>
	      		<dd><?php echo $rl['discount_percent'];?>%</dd>
	      		<dt>ค่าบริการ</dt>
	      		<dd><?php
	      			if($rl['fee_type_id']=="01") echo $rl['room_fee_lump_sum']." บาท/วัน";
	      			else if($rl['fee_type_id']=="02") echo $rl['room_fee_hour']." บาท/ชั่วโมง";
	      		?></dd>
	      		<dt></dt>
	      		<dd><?php ?></dd>
	      	</dl>

        </div>
        <div class="col-lg-6">
        <?php 
        foreach($get_pic_list as $g)
        {
        	$src=base_url().'upload/pic/'.$g['pic_name'];
        	echo '<img class="img-thumbnail room-pic" style="width:33%;height:auto;" src="'.$src.'" onclick=large_pic("'.$src.'");>'; 
        }
        ?>
        </div>
        <div class="col-lg-12">
	      	<div class="panel panel-default">
				<div class="panel-heading">
					<strong>รายละเอียดห้อง</strong>
				</div>
				<div id="room_detail" class="panel-body"><?php echo $rl['room_detail'];?></div>
			</div>
        </div>
        <!--
        <div class="col-lg-12">
        <?php echo $pagination;?>
        </div>
        -->
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

		//search room btn disable
		if($("#select_room").find("option:selected").val()=="")
			$("#view-btn").addClass("disabled");
		$("#select_room").on("change",function(){
			if($("#select_room").find("option:selected").val()!="")
				$("#view-btn").removeClass("disabled");
		});
		
		//replace room_detail content
		var room_detail = $("#room_detail").text();
		$("#room_detail").html(room_detail);
		
		$("#search-body").hide();
		$("#search-heading").click(function(){
			if($("#search-body").is(":hidden"))
			{
				$("#search-body").slideDown();
				$("#search-arrow").children().attr("class","fa fa-caret-square-o-up");
			}
			else
			{	
				$("#search-body").slideUp();
				$("#search-arrow").children().attr("class","fa fa-caret-square-o-down");
			}
		});

		/*
		*แสดงข้อมูลห้องใน dropdown (Get room list)
		*/
		$("#select_room_type").on("change",function(){
			if($(this).find("option:selected").val()!=""){
				$.ajax({
					url:"?d=front&c=room&m=select_room_list",
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
		if($("#select_room_type").find("option:selected").val()!="") $("#select_room_type").change();

		
	});
	function large_pic(src)
	{
		bootbox.alert('<img class="img-thumbnail" src='+src+' style="width:100%;height:auto;">');
	}
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;