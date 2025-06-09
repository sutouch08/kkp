<?php
function select_channels($code = '')
{
  $sc = '';
  $CI =& get_instance();
  $CI->load->model('masters/channels_model');
  $channels = $CI->channels_model->get_data();
  if(!empty($channels))
  {
    foreach($channels as $rs)
    {
      $sc .= '<option value="'.$rs->code.'" '.is_selected($rs->code, $code).'>'.$rs->name.'</option>';
    }
  }

  return $sc;
}


function channels_array()
{
  $sc = [];

  $ci =& get_instance();
  $ci->load->model('masters/channels_model');

  $list = $ci->channels_model->get_all();

  if( ! empty($list))
  {
    foreach($list as $rs)
    {
      $sc[$rs->code] = $rs->name;
    }
  }

  return $sc;
}

 ?>
