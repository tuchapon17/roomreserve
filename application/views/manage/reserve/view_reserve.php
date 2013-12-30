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
      	<?php //echo $reserve_tab;?>
      		<div class="col-lg-12" id="loginform">
      		 	
				
				<?php 
				/*$ad=$article_data;
				$dd=$datetime_data;
				$fd=$file_data;
				
				*/
				$rd=$reserve_data;
				if($rd['approve']==0)$approve="<span class='text-danger'>ยังไม่อนุมัติ</span>";
				else if($rd['approve']==1)$approve="<span class='text-success'>อนุมัติแล้ว</span>";
				
				?>
      		 	<div class="container">
      		 		<div class="row">
      		 			<div class="col-lg-4 wordw">
      		 			<h3 class="text-center">รายละเอียดการจอง</h3>
	      		 			<dl class="dl-horizontal">
	      		 				<dt>รหัสการจอง</dt>
	      		 				<dd><?php echo $rd['reserve_id'];?></dd>
	      		 				<dt>ชื่อโครงการ</dt>
	      		 				<dd><?php echo $rd['project_name'];?></dd>
	      		 				<dt>ห้องที่จอง</dt>
	      		 				<dd><?php echo $rd['room_name'];?></dd>
	      		 				<dt>จำนวนคนที่เข้าใช้</dt>
	      		 				<dd><?php echo $rd['num_of_people'];?></dd>
	      		 				<dt>วันที่จอง</dt>
	      		 				<dd><?php echo $rd['reserve_on'];?></dd>
	      		 				<dt>วัตถุประสงค์การใช้</dt>
	      		 				<dd ><?php echo $rd['for_use'];?></dd>
	      		 				<dt>ผู้จอง</dt>
	      		 				<dd><a href="<?php echo base_url();?>?c=user_profile&m=view_profile&vuser=<?php echo $rd['tb_user_username'];?>" target="_blank"><?php echo $rd['tb_user_username'];?></a></dd>
	      		 				<dt>ส่วนลด</dt>
	      		 				<dd><?php echo $rd['discount'];?> %</dd>
	      		 				<dt>การอนุมัติ</dt>
	      		 				<dd><?php echo $approve;?></dd>
	      		 				<dt>วันที่อนุมัติ</dt>
	      		 				<dd><?php echo $rd['approve_on'];?></dd>
	      		 				<dt>ผู้อนุมัติ</dt>
	      		 				<dd><a href="<?php echo base_url();?>?c=user_profile&m=view_profile&vuser=<?php echo $rd['approve_by'];?>" target="_blank"><?php echo $rd['approve_by'];?></a></dd>
	      		 			</dl>
      		 			</div>
      		 			<div class="col-lg-4 wordw">
      		 			<h3 class="text-center">วัน/เวลาการจอง</h3>
      		 				<dl>
	      		 				<?php 
	      		 				foreach($datetime_data as $index=>$val)
	      		 				{
	      		 					//echo "<dt>".($index+1)."</dt>";
	      		 					//echo "<dd>".$val['reserve_datetime_begin']."</dd>";
	      		 					//echo "<dt>".$val['reserve_datetime_begin']."</dt>";
	      		 					//echo "<dd>- ".$val['reserve_datetime_end']."</dd>";
	      		 					echo "<dd>".($index+1).". <a href='".base_url()."?c=calendar&m=bydate&cdate=".substr($val['reserve_datetime_begin'],0,10)."' target='_blank'>".$val['reserve_datetime_begin']." - ".$val['reserve_datetime_end']."</a></dd>";
	      		 				}
	      		 				?>
	      		 			</dl>
      		 			</div>
      		 			<div class="col-lg-4 wordw">
      		 			<h3 class="text-center">ครุภัณฑ์/อุปกรณ์ที่ใช้</h3>
	      		 			<dl class="dl-horizontal">
		      		 			<?php 
		      		 			foreach($article_data as $index=>$val)
		      		 			{
		      		 				echo "<dt>".$val['article_name']."</dt>";
		      		 				echo "<dd>จำนวน ".$val['unit_num']."</dd>";
		      		 			}
		      		 			?>
		      		 			<dt>ครุภัณฑ์/อุปกรณ์อื่นๆ</dt>
		      		 			<dd><?php echo $rd['other_article'];?></dd>
	      		 			</dl>
      		 			</div>
      		 		</div><!-- row -->
      		 		<div class="row">
      		 			<div class="col-lg-4 wordw">
							<h3 class="text-center">ข้อมูลบุคคล</h3>
							<dl class="dl-horizontal">
								<dt>บุคคล</dt>
	      		 				<dd><?php echo $rd['person_type'];?></dd>
	      		 				<dt>ประเภทบุคคล</dt>
	      		 				<dd><?php echo $rd['person'];?></dd>
	      		 				<dt>เบอร์โทรศัพท์</dt>
	      		 				<dd><?php echo $rd['phone'];?></dd>
	      		 				<dt>หน่วยงาน</dt>
	      		 				<dd><?php echo $rd['office_name'];?></dd>
	      		 				<dt>ตำแหน่งงาน</dt>
	      		 				<dd><?php echo $rd['job_position_name'];?></dd>
	      		 				<dt>คณะ</dt>
	      		 				<dd><?php echo $rd['faculty_name'];?></dd>
	      		 				<dt>สาขา/งาน</dt>
	      		 				<dd><?php echo $rd['department_name'];?></dd>
	      		 				<dt>รหัสนักศึกษา</dt>
	      		 				<dd><?php echo $rd['std_id'];?></dd>
	      		 			</dl>		 			
      		 			</div>
      		 			<div class="col-lg-4 wordw">
      		 			<h3 class="text-center">ไฟล์โครงการ</h3>
      		 				<dl>
		      		 			<?php 
		      		 			foreach($file_data as $index=>$val)
		      		 			{
		      		 				//echo "<dt>".$val['old_file_name']."</dt>";
		      		 				echo "<dd>".($index+1).". <a href='".base_url()."upload/".$val['file_name']."' target='_blank'>".$val['old_file_name']."</a></dd>";
		      		 			}
		      		 			?>
		      		 		</dl>
      		 			</div>
      		 		</div>
      		 	</div>
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
		Show bootbox alert after edited profile1
		###################################################*/
		<?php 
		if($this->session->flashdata("edit_reserve_message"))
		{?>
			bootbox.alert("<?php echo $this->session->flashdata("edit_reserve_message");?>"); 
		<?php
		}?>
	});
	//-->
	
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;