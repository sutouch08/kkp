<?php
class Cancle_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }


  public function get($id)
  {
    $rs = $this->db->where('id', $id)->get('cancle');
    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return FALSE;
  }



  public function get_data(array $ds = array(), $perpage = NULL, $offset = NULL)
  {
    $this->db
    ->select('cancle.*')
    ->select('products.name AS product_name')
    ->select('zone.name AS zone_name')
    ->select('order_state.name AS state_name')
    ->from('cancle')
    ->join('products', 'cancle.product_code = products.code', 'left')
    ->join('zone', 'cancle.zone_code = zone.code', 'left')
    ->join('orders', 'cancle.order_code = orders.code', 'left')
    ->join('order_state', 'orders.state = order_state.state');

    if(!empty($ds['order_code']))
    {
      $this->db->like('cancle.order_code',$ds['order_code']);
    }

    if(!empty($ds['pd_code']))
    {
      $this->db->like('cancle.product_code', $ds['pd_code']);
    }

    if(!empty($ds['zone_code']))
    {
      $this->db->group_start();
      $this->db->like('cancle.zone_code', $ds['zone_code']);
      $this->db->or_like('zone.name', $ds['zone_code']);
      $this->db->group_end();
    }

    if(!empty($ds['from_date']) && !empty($ds['to_date']))
    {
      $this->db->where('cancle.date_upd >=', from_date($ds['from_date']));
      $this->db->where('cancle.date_upd <=', to_date($ds['to_date']));
    }

    if($perpage > 0)
    {
      $offset = $offset === NULL ? 0 : $offset;
      $this->db->limit($perpage, $offset);
    }

    $rs = $this->db->get();

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return FALSE;
  }


  public function count_rows(array $ds = array(), $perpage = NULL, $offset = NULL)
  {
    $this->db
    ->from('cancle')
    ->join('zone', 'cancle.zone_code = zone.code', 'left')
    ->join('orders', 'cancle.order_code = orders.code', 'left')
    ->join('order_state', 'orders.state = order_state.state');

    if(!empty($ds['order_code']))
    {
      $this->db->like('cancle.order_code',$ds['order_code']);
    }

    if(!empty($ds['pd_code']))
    {
      $this->db->like('cancle.product_code', $ds['pd_code']);
    }

    if(!empty($ds['zone_code']))
    {
      $this->db->group_start();
      $this->db->like('cancle.zone_code', $ds['zone_code']);
      $this->db->or_like('zone.name', $ds['zone_code']);
      $this->db->group_end();
    }

    if(!empty($ds['from_date']) && !empty($ds['to_date']))
    {
      $this->db->where('cancle.date_upd >=', from_date($ds['from_date']));
      $this->db->where('cancle.date_upd <=', to_date($ds['to_date']));
    }

    return $this->db->count_all_results();
  }


  public function get_sum_product($product_code, $warehouse_code = NULL)
  {
    $this->db->select_sum('qty')->where('product_code', $product_code);

    if( ! empty($warehouse_code))
    {
      $this->db->where('warehouse_code', $warehouse_code);
    }

    $rs = $this->db->get('cancle');

    if($rs->num_rows() === 1)
    {
      return $rs->row()->qty;
    }

    return 0;
  }


  public function get_sum_cancle_product($order_code, $product_code)
  {
    $rs = $this->db->select_sum('qty')
    ->where('order_code', $order_code)
    ->where('product_code', $product_code)
    ->get('cancle');

    return intval($rs->row()->qty);
  }


  public function get_details($order_code, $product_code)
  {
    $rs = $this->db
    ->where('order_code', $order_code)
    ->where('product_code', $product_code)
    ->get('cancle');

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return FALSE;
  }



  public function get_all_details($order_code)
  {
    $rs = $this->db->where('order_code', $order_code)->get('cancle');
    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return FALSE;
  }



  public function add(array $ds = array())
  {
    if(!empty($ds))
    {
      return $this->db->insert('cancle', $ds);
    }

    return FALSE;
  }



  public function update($order_code, $product_code, $zone_code, $qty)
  {
    $qr = "UPDATE cancle SET qty = (qty + {$qty}) ";
    $qr .= "WHERE order_code = '{$order_code}' AND product_code = '{$product_code}' ";
    $qr .= "AND zone_code = '{$zone_code}'";

    return $this->db->query($qr);
  }


  public function delete($id)
  {
    return $this->db->where('id', $id)->delete('cancle');
  }


  public function restore_buffer($code)
  {
    $sc = TRUE;

    $details = $this->get_cancle_details($code);

    if( ! empty($details))
    {
      foreach($details as $rs)
      {
        if($sc === FALSE)
        {
          break;
        }

        if($this->is_buffer_exists($rs->order_code, $rs->product_code, $rs->zone_code))
        {
          $this->db
          ->set("qty", "qty + {$rs->qty}", FALSE)
          ->set("user", $rs->user)
          ->where('order_code', $rs->order_code)
          ->where('product_code', $rs->product_code)
          ->where('zone_code', $rs->zone_code);

          if( ! $this->db->update('buffer'))
          {
            $sc = FALSE;
          }
        }
        else
        {
          $arr = array(
            'order_code' => $rs->order_code,
            'product_code' => $rs->product_code,
            'warehouse_code' => $rs->warehouse_code,
            'zone_code' => $rs->zone_code,
            'qty' => $rs->qty,
            'user' => $rs->user
          );

          if( ! $this->db->insert('buffer', $arr))
          {
            $sc = FALSE;
          }
        }

        if($sc === TRUE)
        {
          if( ! $this->delete($rs->id))
          {
            $sc = FALSE;
          }
        }
      }
    }

    return $sc;
  }


  public function get_cancle_details($code)
  {
    $rs = $this->db->where('order_code', $code)->get('cancle');

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function is_buffer_exists($code, $pd_code, $zone_code)
  {
    $rs = $this->db->select('id')
    ->where('order_code', $code)
    ->where('product_code', $pd_code)
    ->where('zone_code', $zone_code)
    ->get('buffer');

    if($rs->num_rows() > 0)
    {
      return TRUE;
    }

    return FALSE;
  }


  public function get_product_cancle_zone($zone_code, $product_code)
  {
    $rs = $this->db
    ->select_sum('qty')
    ->where('zone_code', $zone_code)
    ->where('product_code', $product_code)
    ->get('cancle');

    if($rs->num_rows() === 1)
    {
      return $rs->row()->qty > 0 ? $rs->row()->qty : 0;
    }

    return 0;
  }

}
 ?>
