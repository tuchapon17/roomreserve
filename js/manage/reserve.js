function approve_alert(r_id,base_url)
{
	var html='';
	html +='<form role="form" id="form_approve" action="'+base_url+'?d=manage&c=reserve&m=reserve_approve&id='+r_id+'" method="post" autocomplete="off">';
	html +='<select id="select_approve" name="select_approve" class="form-control">';
	html +='<option value="0">รออนุมัติ</option>';
	html +='<option value="1">อนุมัติ</option>';
	html +='<option value="2">ส่งให้ผู้บริหารอนุมัติ</option>';
	html +='<option value="3">ไม่อนุมัติ</option>';
	html += '</select>';
	html +='</form>';
	bootbox.dialog({
		message: html,
		title: "อนุมัติการจอง",
		buttons: {
			success: {
				label: "ตกลง",
				className: "btn-success",
				callback: function() {
					$("#form_approve").submit();
				}
			},
			danger: {
				label: "ยกเลิก",
				className: "btn-danger",
				callback: function() {
				
				}
			}
		}
	});
}