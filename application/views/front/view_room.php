
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
	$rl=$get_room_list[0];
?>
<!-- Custom Content -->
    <div class="container">
      <div class="row">
      	
      	<div class="col-lg-12">
      		<h2>ข้อมูลห้อง</h2>
      	</div>
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
        	echo '<img class="img-thumbnail" style="width:33%;height:auto;" src="'.$src.'" onclick=large_pic("'.$src.'");>'; 
        }
        ?>
        </div>
        <div class="col-lg-12">
        <?php echo $pagination;?>
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
		
	});
	function large_pic(src)
	{
		bootbox.alert('<img class="img-thumbnail" src='+src+' style="width:100%;height:auto;">');
	}
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;