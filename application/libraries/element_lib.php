<?php
class Element_lib
{
	function __construct()
	{
	
	}
	function form_input($ar)
	{
		$html='
		<div class="form-group">
		<label for="'.$ar['IN_name'].'">'.$ar['LB_text'].' '.$ar['LB_attr'].'</label>
		<input type="'.$ar['IN_type'].'" class="form-control '.$ar['IN_class'].'" name="'.$ar['IN_name'].'" id="'.$ar['IN_id'].'" placeholder="'.$ar['IN_PH'].'" value="'.$ar['IN_value'].'" '.$ar['IN_attr'].'>
		<span class="help-block">'.$ar['help_text'].'</span>
		</div>
		';
		return $html;
	}
	function form_textarea($ar)
	{
		$html='
		<div class="form-group">
		<label for="'.$ar['IN_name'].'">'.$ar['LB_text'].' '.$ar['LB_attr'].'</label>
		<textarea class="form-control '.$ar['IN_class'].'" name="'.$ar['IN_name'].'" id="'.$ar['IN_id'].'" '.$ar['IN_attr'].'></textarea>
		<span class="help-block">'.$ar['help_text'].'</span>
		</div>
		';
		return $html;
	}
	function form_select($ar)
	{
		$html='
		<div class="form-group">
		<label for="'.$ar['S_name'].'">'.$ar['LB_text'].' '.$ar['LB_attr'].'</label>
		<select class="form-control '.$ar['S_class'].'" id="'.$ar['S_id'].'" name="'.$ar['S_name'].'">
		<option value="">เลือก</option>';
		if($ar['S_data']>0):
			foreach($ar['S_data'] as $ar2):
				if($ar['S_old_value']==$ar2[$ar['S_id_field']]) $selected="selected='selected'";
				else $selected='';
				$html.="<option value='".$ar2[$ar['S_id_field']]."' ".$selected.">".$ar2[$ar['S_name_field']]."</option>";
			endforeach;
		endif;
		$html.='
		</select>
		<span class="help-block">'.$ar['help_text'].'</span>
		</div>';
		return $html;
	}
	function form_select2($ar)
	{
		$html='
		<div class="form-group">
		<label for="'.$ar['S_name'].'">'.$ar['LB_text'].' '.$ar['LB_attr'].'</label>
		<select '.$ar['S_attr'].' class="form-control '.$ar['S_class'].'" id="'.$ar['S_id'].'" name="'.$ar['S_name'].'">
		';
		if($ar['S_data']>0):
			foreach($ar['S_data'] as $ar2):
				if($ar['S_old_value']==$ar2[$ar['S_id_field']]) $selected="selected='selected'";
				else $selected='';
				$html.="<option value='".$ar2[$ar['S_id_field']]."' ".$selected.">".$ar2[$ar['S_name_field']]."</option>";
			endforeach;
		endif;
		$html.='
		</select>
		<span class="help-block">'.$ar['help_text'].'</span>
		</div>';
		return $html;
	}
	function span_redstar()
	{
		return '<span class="red-text"> *</span>';
	}
	function btn($btntype,$other_attr)
	{
		if($btntype=="delete")
		{
			$html='<button type="submit" class="btn btn-danger" '.$other_attr.'><i class="fa fa-trash-o fa-lg"></i></button>';
		}
		else if($btntype=="edit")
		{
			$html='<button type="button" class="btn btn-primary" '.$other_attr.'><i class="fa fa-edit fa-lg"></i></button>';
		}
		else if($btntype=="submitcheck")
		{
			$html='<button type="button" class="btn btn-success" '.$other_attr.'><i class="fa fa-check"></i></button>';
		}
		else if($btntype=="refreshcheck")
		{
			$html='<button type="button" class="btn btn-warning" '.$other_attr.'><i class="fa fa-refresh "></i></button>';
		}
		else if($btntype=="perpage")
		{
			$html='<button type="button" title="จำนวนแถว" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" '.$other_attr.'>
			<i class="fa fa-list-ol fa-white"></i> <span class="caret"></span>
			</button>';
		}
		else if($btntype=="sort_by")
		{
			$html='<button type="button" title="ลำดับข้อมูล" class="btn btn-success" '.$other_attr.'><i class="fa fa-sort-alpha-asc fa-white"></i></button>';
		}
		else if($btntype=="search_by")
		{
			$html='<button type="button" title="ค้นหาจาก" class="btn btn-primary" '.$other_attr.'><i class="fa fa-search fa-white"></i> <i class="fa fa-question-circle fa-white"></i></button>';
		}
		else if($btntype=="search")
		{
			$html='<button type="submit" title="ค้นหา" class="btn btn-primary" '.$other_attr.'><i class="fa fa-search"></i></button>';
		}
		else if($btntype=="clear_search")
		{
			$html='<button type="button" title="ยกเลิกการค้นหา" class="btn btn-danger" id="clearSearch" '.$other_attr.'><i class="fa fa-times"></i></button>';
		}
		else if($btntype=="submit")
		{
			$html='<button type="submit" class="btn btn-default" '.$other_attr.'><i class="fa fa-check-square-o fa-lg fa-white"></i></button>';
		}
		else if($btntype=="view")
		{
			$html='<button type="button" class="btn btn-primary" '.$other_attr.'><i class="fa fa-eye"></i></button>';
		}
		else if($btntype=="upload-submit")
		{
			$html='<button type="submit" class="btn btn-success" '.$other_attr.' title="Upload"><i class="fa fa-upload fa-lg"></i></button>';
		}
		else if($btntype=="save")
		{
			$html='<button type="button" class="btn btn-primary" '.$other_attr.' title="Upload"><i class="fa fa-save fa-lg"></i></button>';
		}
		else if($btntype=="picture")
		{
			$html='<button type="button" class="btn btn-primary" '.$other_attr.' title="จัดการรูป"><i class="fa fa-picture-o fa-lg"></i></button>';
		}
		else if($btntype=="approve")
		{
			$html='<button type="button" class="btn btn-primary" '.$other_attr.' title=""><i class="fa fa-legal fa-lg"></i></button>';
		}
		return $html;
	}
}

















