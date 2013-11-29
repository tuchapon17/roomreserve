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
    </style>
<?php
echo $bodyopen;
echo $navbar;
?>
<!-- Custom Content -->

    <div class="container">
      <div class="row">
      	<div class="col-lg-12">
      		<div class="col-lg-6 col-lg-offset-3" id="loginform">
      			
      		 	<h2>สมัครสมาชิก</h2>
      		 	<ul class="nav nav-tabs" id="steptab">
      		 	  <!-- data-toggle มี pill/tab -->
				  <li><a href="#" data-toggle="pill" id="step1">1</a></li>
				  <li><a href="#" data-toggle="pill" id="step2">2</a></li>
				  <li><a href="#" data-toggle="pill" id="step3">3</a></li>
				</ul>
      		 	<div class="alert-danger" id="login-alert">
      			<?php 
      				echo form_error("select_province");
      				echo form_error("select_district");
      				echo form_error("select_subdistrict");     				
      			?>
      			</div>    
	          	<form role="form" action="?c=register&m=step3" method="post">
				  <div class="form-group">
				    <label for="select_province">จังหวัด<span class="red-text"> *</span></label>
				    <select class="form-control" id="select_province" name="select_province">
				    	<option value="">เลือก</option>
				    	<option value="1">1</option>
				    </select>			    
				  </div>
				  <div class="form-group">
				    <label for="select_district">อำเภอ<span class="red-text"> *</span></label>
				    <select class="form-control" id="select_district" name="select_district">
				    	<option value="">เลือก</option>
				    	<option value="1">1</option>
				    </select>			    
				  </div>
				  <div class="form-group">
				    <label for="select_subdistrict">ตำบล<span class="red-text"> *</span></label>
				    <select class="form-control" id="select_subdistrict" name="select_subdistrict">
				    	<option value="">เลือก</option>
				    	<option value="1">1</option>
				    </select>			    
				  </div>
				  
				  
				  <button type="submit" class="btn btn-default">เสร็จสิ้น</button>
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
	<script type="text/javascript">
	<!--
	$(function(){
		//alert(getURLParameter("m"));
		/*if(getURLParameter("m")=="step1")
		{
			$("#"+getURLParameter("m")).attr("data-toggle","tab");
		}*/
		//$("#step1").removeAttr('data-toggle');
		/*ค้นหา element ภายใน #steptab ที่ id ขึ้นต้นด้วย step */
		$("#steptab").find('[id^="step"]').filter(function(index){
			/*ลบ data-toggle ของแต่ละ id=step.. */
			//$("#"+this.id).removeAttr('data-toggle');
			
			//$("#"+getURLParameter("m")).attr("data-toggle","tab");
			
			/*actived tab*/
			$("#"+getURLParameter("m")).tab('show');
			if(getURLParameter("m")!=this.id)
			{
				/*ไม่สามารถคลิกstepอื่นที่ไม่ใช่หน้านี้ได้ */
				$("#"+this.id).click(function(){return false;});
			}
		});
		$("#"+getURLParameter("m"))
	});
	function getURLParameter(name) {
	    return decodeURI(
	        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
	    );
	}
	//-->
	</script>
<?php 
echo $bodyclose;
echo $htmlclose;