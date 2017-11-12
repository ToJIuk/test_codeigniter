<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_Products {


	public function input_form($input_array, $cell_id)
	{
		$CI =& get_instance();
		
		$query = $CI->db->query("SELECT 
									* 
									from ".$input_array['rel_table']." 
									
									WHERE ".$input_array['rel_key']." = ".intval($cell_id));
		$products_arr = $query->result_array();

		$data = '';
		ob_start();					
?>
		<table style="text-align:center; margin-top:-10px;">
			<thead class="tbl">
				<tr style="border-bottom:1px solid #CCC;">
					<th style="float:left;  margin-top:5px;">
						Тип товара
					</th>
					<th>
						Бренд
					</th>
					<th>
						Цена
					</th>
					<th>
						Количество
					</th>
					<th class="alignRight">
						Сумма
					</th>
				</tr>
			</thead>
			
			<?php 
			
			$summ = 0;
			// print_r($products_arr);
			foreach	($products_arr as $product) {
			
			?>
			<tr style="height:px; border-bottom:1px solid #CCC;" class="tbl2">
				<td style="float:left; margin-top:10px;">
					<a target="_blank" href="/products/all/list/?search_text=<?=$product['order_product_id']?>"><?=$product['order_product_name']?> [<?=$product['order_product_id']?>]</a>
				</td>
				<td>
					<?=$product['order_product_brand_name']?>
				</td>
				<td>
					<?=$product['order_product_price']?> грн.
				</td>
				<td>
					<?=$product['order_product_qty']?>
				</td>
				<td class="alignRight">
					<?=( intval($product['order_product_qty'])*intval($product['order_product_price']) )?> грн.
				</td>
			</tr>	
			<?php 
				$summ += ( intval($product['order_product_qty'])*intval($product['order_product_price']) );
				} 				
			?>
			
			<tr style="height:px; border-bottom:1px solid #CCC;" class="tbl2">
				<th style="float:left; margin-top:10px;">
					
				</th>
				<th>
					
				</th>
				<th>
					
				</th>
				<th class="alignRight">
					Всего:
				</th>
				<th class="alignRight">
					<?=$summ?> грн.
				</th>
			</tr>
		

		</table>
<?php			
		$data .= ob_get_clean();
		

		return $data;
	}
	public function db_save($input_array, $cell_id)
	{
		/*
		$CI =& get_instance();
		$CI->db->query("DELETE FROM ".$input_array['rel_table']." WHERE ".$input_array['rel_key']." = '".$cell_id."'");			
		if ( isset($_POST[$input_array['name']]) )
		{
			foreach ($_POST[$input_array['name']] as $join_id)
			{
			$join_id = intval($join_id);
			$data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
			$CI->db->insert($input_array['rel_table'], $data); 
			}	
		}
		*/
	}
	public function db_add($input_array, $cell_id)
	{
		/*
		$CI =& get_instance();
		if ( isset($_POST[$input_array['name']]) )
			{
				foreach ($_POST[$input_array['name']] as $join_id)
				{
				$join_id = intval($join_id);
				$data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
				$CI->db->insert($input_array['rel_table'], $data); 
				}	
			}
		*/
	}

}

?>
	