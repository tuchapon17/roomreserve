<?php 

echo $htmlopen;
echo $head;
?>
    <!-- Custom styles -->
    <style type="text/css">
		
    </style>
<?php
	echo $bodyopen;
	echo $navbar;
?>
<!-- Custom Content -->
    <div class="container">
      <div class="row">
      	<div class="col-lg-12">
      		<h2>ประเภทรายงาน</h2>
      		<div class="panel panel-default">
      			<div class="panel-heading">
      			เลือกประเภทรายงาน
      			</div>
      			<div class="panel-body">
	      			<form role="form" action="<?php echo base_url();?>?d=report&c=report&m=report_type_process" method="post" autocomplete="off">
		      			<div class="form-group">
		      				<label for="report_type" >ประเภทรายงาน</label>
		      				<select class="form-control" name="se_report_type" id="se_report_type">
		      					<option value="report_reserve">รายงานการจอง</option>
		      					<option value="report_room_use">รายงานการใช้ห้อง</option>
		      				</select>
		      			</div>
		      			<div class="form-group">
		      				<label for="">ระยะเวลา</label>
	      					<select class="form-control" name="se_time_length" id="se_time_length">
	      						<option value="tl_month">รายเดือน</option>
	      						<option value="tl_quarter">รายไตรมาส</option>
	      						<option value="tl_term">รายเทอม</option>
	      						<option value="tl_year">รายปี</option>
	      					</select>
		      			</div>
		      			<div class="form-group">
		      				<label for="">เลือกปี</label>
	      					<select class="form-control" name="se_year" id="se_year">
	      						<option value="2013">2013</option>
	      						<option value="2014" selected>2014</option>
	      					</select>
		      			</div>
		      			<div class="form-group">
		      				<label for="">เลือกเดือน</label>
	      					<select class="form-control" name="se_month" id="se_month">
	      						<option value="01">01</option>
	      						<option value="02">02</option>
	      						<option value="03">03</option>
	      						<option value="04">04</option>
	      						<option value="05">05</option>
	      					</select>
		      			</div>
		      			<div class="form-group">
		      				<label for="">เลือกไตรมาส</label>
	      					<select class="form-control" name="se_quarter" id="se_quarter">
	      						<option value="quarter1">ไตรมาส1 (ธ.ค.-ก.พ.)</option>
	      						<option value="quarter2">ไตรมาส2 (มี.ค.-พ.ค.)</option>
	      						<option value="quarter3">ไตรมาส3 (มิ.ย.-ส.ค.)</option>
	      						<option value="quarter4">ไตรมาส4 (ก.ย.-พ.ย.)</option>
	      					</select>
		      			</div>
		      			<div class="form-group">
		      				<label for="">เลือกเทอม</label>
	      					<select class="form-control" name="se_term" id="se_term">
	      						<option value="term1">เทอม1</option>
	      						<option value="term2">เทอม2</option>
	      						<option value="term3">เทอม3</option>
	      					</select>
		      			</div>
		      			
		      			<div class="form-group">
		      				<button type="submit" class="btn btn-primary">submit</button>
		      			</div>
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
		
	});
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;