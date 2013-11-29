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
}