<?php 
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
class CSV_Woocommerce_Support{
 	public function variation_function($complete_data_array, $mode,$variationtypeimport){
                $data_array = $variation_data = $update_data = array();
		global $wpdb;
		if(isset($complete_data_array['CORE']['variation_sku']['mapped_value']))
		 $variation_sku = $complete_data_array['CORE']['variation_sku']['mapped_value'];
                if(isset($complete_data_array['CORE']['parentsku']['mapped_value']))
                 $parent_sku = $complete_data_array['CORE']['parentsku']['mapped_value'];	
		if(isset($variationtypeimport) && $variationtypeimport == 'importUsingSku'){
                        $get_parent_product_id = $wpdb->get_results("select post_id from $wpdb->postmeta where meta_value = '$parent_sku' order by post_id desc");
			if(!empty($get_parent_product_id)) {
                              	$product_id = $get_parent_product_id[0]->post_id;
			}
		}
		if(isset($variationtypeimport) && $variationtypeimport == 'importUsingProductId'){
			$product_id = $complete_data_array['CORE']['productid']['mapped_value'];

		}
		if(isset($variationtypeimport) && $variationtypeimport == 'updateVariationSku'){
			$get_variationid = $wpdb->get_results("select post_id from $wpdb->postmeta where meta_value = '$variation_sku' order by post_id desc"); 
			if(!empty($get_variationid)){
				$variation_id = $get_variationid[0]->post_id;
			}
		}
		if(isset($variationtypeimport) && $variationtypeimport == 'updateVariationId'){
			$variation_id = $complete_data_array['CORE']['variationid']['mapped_value'];
		}

		/*else{
			$product_id = $complete_data_array['CORE']['variationid']['mapped_value'];
		}*/
		// create variation
		if($mode == 'insert') {
			if(isset($product_id)) { 
				$New_Variation_ID = $product_id;
				$get_count_of_variations = $wpdb->get_results("select count(*) as variations_count from $wpdb->posts where post_parent = $product_id and post_type = 'product_variation'");
				$variations_count = $get_count_of_variations[0]->variations_count;
				$menuorder_count = 0;
				if($variations_count == 0) {
					$variations_count = '';
					$menu_order = 0;
				} else {
					$variations_count = $variations_count + 1;
					$menuorder_count = $variations_count - 1;
					$variations_count = '-' . $variations_count;
				}
				$Variation_Slug = 'product-' . $product_id . '-variation';
				$get_variation_data = $wpdb->get_results("select *from $wpdb->posts where ID = $product_id");
				foreach($get_variation_data as $key => $val) {
					if($product_id == $val->ID){
						//$Variation_GUID = site_url() . '?product_variation=' . $Variation_Slug;
						$variation_data['post_title'] = 'Variation #' . $val->ID . ' of ' . $val->post_title;
						$variation_data['post_date'] = $val->post_date;
						$variation_data['post_status'] = 'publish';
						$variation_data['comment_status'] = 'open';
						$variation_data['ping_status'] = 'open';
						$variation_data['menu_order'] = $menuorder_count;
						$variation_data['post_name'] = 'product-' . $val->ID . '-variation' . $variations_count;
						$variation_data['post_parent'] = $val->ID;
						$variation_data['guid'] =  site_url() . '?product_variation=product-' . $val->ID . '-variation' . $variations_count;
						$variation_data['post_type'] = 'product_variation';
						$data_array = $variation_data;
					}
				}
		        }
		}
		//update variation
		if($mode = 'update' || $mode = 'freshupdate'){
			if(isset($variation_id)){
				$get_update_data = $wpdb->get_results("select *from $wpdb->posts where (ID = $variation_id) and (post_type = 'product_variation')");
				$existing_variation_id = '';
				$existing_variation_id = $get_update_data[0]->ID;
				if(isset($variationtypeimport) && ($existing_variation_id == $variation_id)){
					foreach($get_update_data as $key => $val) {
						$update_data['ID'] = $val->ID;
						$update_data['post_title'] = $val->post_title;
						$update_data['post_status'] = 'publish';
						$update_data['comment_status'] = 'open';
						$update_data['ping_status'] = 'open';
						$update_data['post_name'] = $val->post_name;
						$update_data['post_parent'] = $val->post_parent;
						$update_data['guid'] = $val->guid;
						$update_data['post_type'] = 'product_variation';
						$update_data['menu_order'] = $val->menu_order;
						$data_array = $update_data;

					}
				}
			}
		} 
//$get_update_postmeta = $wpdb->get_results("select ID from $wpdb->posts where post_parent = $product_id AND post_type = 'product_variation'");
//$get_existing_variation_id = $get_update_postmeta[0]->ID;
//$get_data = $wpdb->get_results("select meta_key,meta_value from $wpdb->postmeta where post_id = '$get_existing_variation_id'"); 

return $data_array;
}
public function create_refunds($mode,$complete_data_array){
	global $wpdb;
	$post_excerpt = '';
	$data_array = array();
	if(isset($complete_data_array['CORE']['post_parent']['mapped_value']))
	 $parent_order_id = $complete_data_array['CORE']['post_parent']['mapped_value'];
	if(isset($complete_data_array['CORE']['post_excerpt']['mapped_value']))
	 $post_excerpt = $complete_data_array['CORE']['post_excerpt']['mapped_value'];
	$get_order_id = $wpdb->get_results("select * from $wpdb->posts where (ID = $parent_order_id) and (post_type = 'shop_order')");
	if(!empty($get_order_id)){
		$refund = '';
		$refund = $get_order_id[0]->ID;
		if(isset($refund) && $refund == $parent_order_id){
			$date_format = date('M-j-Y-Hi-a');
			$data_array['post_type'] = 'shop_order_refund';
			$data_array['post_parent'] = $parent_order_id;
			$data_array['post_status'] = 'wc-completed';
			$data_array['post_excerpt'] = $post_excerpt;
			$data_array['post_name'] = 'refund-'.$date_format;
			$data_array['guid'] = site_url() . '?shop_order_refund=' . 'refund-'.$date_format;
		}
	}
	return $data_array;
}
public function update_coupons($mode,$complete_data_array){
	global $wpdb;
	$data_array = $update_data = array();
	if($mode = 'update' || $mode = 'freshupdate'){
		$update_coupon_id = $complete_data_array['CORE']['couponid']['mapped_value'];
		$post_title = $complete_data_array['CORE']['coupon_code']['mapped_value'];
		$post_name = $complete_data_array['CORE']['coupon_code']['mapped_value'];
		$post_excerpt = $complete_data_array['CORE']['description']['mapped_value'];
		if(isset($update_coupon_id)){
			$get_update_data = $wpdb->get_results("select *from $wpdb->posts where (ID = $update_coupon_id) and (post_type = 'shop_coupon')");	
			$existing_coupon_id = '';
			$existing_coupon_id = $get_update_data[0]->ID;
			if(isset($update_coupon_id) && ($update_coupon_id == $existing_coupon_id)){
				foreach($get_update_data as $key => $val) {
					$update_data['ID'] = $val->ID;
					$update_data['post_title'] = $post_title;
					$update_data['post_status'] = $val->post_status;
					$update_data['comment_status'] = 'open';
					$update_data['ping_status'] = 'open';
					$update_data['post_name'] = $post_name;
					$update_data['post_parent'] = $val->post_parent;
					$update_data['post_excerpt'] = $post_excerpt;
					$update_data['guid'] = $val->guid;
					$update_data['post_type'] = $val->post_type;
					$update_data['menu_order'] = $val->menu_order;
					$data_array = $update_data;

				}	
			}
		}
	}
	return $data_array;
}
public function update_refunds($mode,$complete_data_array){
	global $wpdb;
	$data_array = $update_data = array();
	if($mode = 'update' || $mode = 'freshupdate'){
		$update_refund_id = $complete_data_array['CORE']['refundid']['mapped_value'];
		$post_excerpt = $complete_data_array['CORE']['post_excerpt']['mapped_value'];
		if(isset($update_refund_id)){
			$get_update_data = $wpdb->get_results("select *from $wpdb->posts where (ID = $update_refund_id) and (post_type = 'shop_order_refund')");
			$existing_refund_id = '';
			$existing_refund_id = $get_update_data[0]->ID;
			if(isset($update_refund_id) && ($update_refund_id == $existing_refund_id)){
				foreach($get_update_data as $key => $val) {
					$update_data['ID'] = $val->ID;
					$update_data['post_title'] = $val->post_title;					
					$update_data['comment_status'] = 'open';
					$update_data['ping_status'] = 'open';
					$update_data['post_name'] = $val->post_name;
					$update_data['post_parent'] = $val->post_parent;
					$update_data['guid'] = $val->guid;
					$update_data['post_excerpt'] = $post_excerpt;
					$update_data['post_type'] = $val->post_type;
					$update_data['menu_order'] = $val->menu_order;
					$data_array = $update_data;

				}
			}
		}
	}
//echo '<pre>'; print_r($data_array); echo '</pre>'; die('lll');
        return $data_array;
}
public function update_orders($mode,$update_order_id,$complete_data_array){
        global $wpdb;
	$data_array = $update_data = array();
	if($mode = 'update' || $mode = 'freshupdate'){
		if(isset($update_order_id)){
			$get_update_data = $wpdb->get_results("select *from $wpdb->posts where (ID = $update_order_id) and (post_type = 'shop_order')");
			$existing_order_id = '';
			$existing_order_id = $get_update_data[0]->ID;
			$customernote = $complete_data_array['CORE']['customer_note']['mapped_value'];
			$product_status = $complete_data_array['CORE']['product_status']['mapped_value'];
			if(isset($update_order_id) && ($update_order_id == $existing_order_id)){
				foreach($get_update_data as $key => $val) {
					$update_data['ID'] = $val->ID;
					$update_data['post_title'] = $val->post_title;
					$update_data['post_status'] = $product_status;
					$update_data['post_excerpt'] = $customernote;
					$update_data['comment_status'] = 'open';
					$update_data['ping_status'] = 'open';
					$update_data['post_name'] = $val->post_name;
					$update_data['post_parent'] = $val->post_parent;
					$update_data['guid'] = $val->guid;
					$update_data['post_type'] = $val->post_type;
					$update_data['menu_order'] = $val->menu_order;
					$data_array = $update_data;

				}
			}
		}
	}
//echo '<pre>'; print_r($data_array); echo '</pre>'; die('lll');
        return $data_array;
}
public function orders_function($post_id,$mode,$Item_metaDatas = Null,$Fee_metaDatas = Null ,$Shipment_metaDatas = Null ){
	global $wpdb;
	$order_id = absint( $post_id );
	// WooCommerce Item details import starts here
	$exploded_order_items = explode(',', $Item_metaDatas['order_item_name']);
	$item_count = 0;
	if(isset($Item_metaDatas['_variation_id']))
	$exploded_variations_id = explode(',', $Item_metaDatas['_variation_id']);
	if(isset($Item_metaDatas['_product_id']))
	$exploded_product_id = explode(',', $Item_metaDatas['_product_id']);
	$exploded_line_subtotal = explode(',', $Item_metaDatas['_line_subtotal']);
	$exploded_line_subtotal_tax = explode(',', $Item_metaDatas['_line_subtotal_tax']);
	$exploded_line_total = explode(',', $Item_metaDatas['_line_total']);
	$exploded_line_tax = explode(',', $Item_metaDatas['_line_tax']);
	$exploded_line_tax_data = explode('|', $Item_metaDatas['_line_tax_data']);
	$exploded_tax_class = explode(',', $Item_metaDatas['_tax_class']);
	$exploded_qty = explode(',', $Item_metaDatas['_qty']);
	if(isset($exploded_order_items)){
	   foreach($exploded_order_items as $singleitem) {
	       if ( ! $order_id )
		       return false;
	       $singleitem = trim($singleitem);
	       if (is_numeric($singleitem)) {
		       $get_item_title = $wpdb->get_results("select post_title from $wpdb->posts where ID = '{$singleitem}' and post_type = 'product'");
	       } else {
		       $get_item_title = $wpdb->get_results("select post_title from $wpdb->posts where post_title = '{$singleitem}' and post_type = 'product'");
	       }
	       if(!empty($get_item_title)){
	       $singleitem = $get_item_title[0]->post_title;
	       if( $singleitem != '' ) {
		       $item = array(
				       'order_item_name'     => $singleitem,
				       'order_item_type'     => 'line_item',
				    );
		       $wpdb->insert( $wpdb->prefix . "woocommerce_order_items",
				       array(
					       'order_item_name'     => $item['order_item_name'],
					       'order_item_type'     => $item['order_item_type'],
					       'order_id'        => $order_id
					    ),
				       array(
					       '%s', '%s', '%d'
					    )
				    );
		       $item_id = absint( $wpdb->insert_id );
		       if($mode == 'insert'){
				 if(isset($exploded_variations_id[$item_count]))
				       woocommerce_add_order_item_meta( $item_id, '_variation_id', $exploded_variations_id[$item_count]);
				 if(isset($exploded_product_id[$item_count]))
				       woocommerce_add_order_item_meta( $item_id, '_product_id', $exploded_product_id[$item_count]);
			       woocommerce_add_order_item_meta( $item_id, '_line_subtotal', $exploded_line_subtotal[$item_count]);
			       woocommerce_add_order_item_meta( $item_id, '_line_subtotal_tax', $exploded_line_subtotal_tax[$item_count]);
			       woocommerce_add_order_item_meta( $item_id, '_line_total', $exploded_line_total[$item_count]);
			       woocommerce_add_order_item_meta( $item_id, '_line_tax', $exploded_line_tax[$item_count]);
			       if(isset($exploded_line_tax_data[$item_count])) {
				       $unserialized_tax_data = @unserialize($exploded_line_tax_data[$item_count]);
				       woocommerce_add_order_item_meta( $item_id, '_line_tax_data', $unserialized_tax_data);
			       }		       
			       woocommerce_add_order_item_meta( $item_id, '_tax_class', $exploded_tax_class[$item_count]);
			       woocommerce_add_order_item_meta( $item_id, '_qty', $exploded_qty[$item_count]);
		       }
		       if($mode == 'update' || $mode == 'freshupdate'){
				 if(isset($exploded_variations_id[$item_count]))
					woocommerce_update_order_item_meta($item_id, '_variation_id', $exploded_variations_id[$item_count]);
				 if(isset($exploded_product_id[$item_count]))
				       woocommerce_update_order_item_meta( $item_id, '_product_id', $exploded_product_id[$item_count]);
				  woocommerce_update_order_item_meta($item_id, '_line_subtotal', $exploded_line_subtotal[$item_count]);
				  woocommerce_update_order_item_meta($item_id, '_line_subtotal_tax', $exploded_line_subtotal_tax[$item_count]);
				  woocommerce_update_order_item_meta($item_id, '_line_total', $exploded_line_total[$item_count]);
				  woocommerce_update_order_item_meta( $item_id, '_line_tax', $exploded_line_tax[$item_count]);
				 if(isset($exploded_line_tax_data[$item_count])) {
				       $unserialized_tax_data = unserialize($exploded_line_tax_data[$item_count]);
				       woocommerce_update_order_item_meta( $item_id, '_line_tax_data', $unserialized_tax_data);
				 }
				 woocommerce_update_order_item_meta($item_id, '_tax_class', $exploded_tax_class[$item_count]);
				 woocommerce_update_order_item_meta($item_id, '_qty', $exploded_qty[$item_count]);
		       }
		       $item_count++;
	       	  }
		}
	     }
	 }
	$exploded_fee_items = explode(',', $Fee_metaDatas['order_item_name']);
	$fee_count = 0;
	$exploded_fee_line_subtotal = explode(',', $Fee_metaDatas['_line_subtotal']);
	$exploded_fee_line_subtotal_tax = explode(',', $Fee_metaDatas['_line_subtotal_tax']);
	$exploded_fee_line_total = explode(',', $Fee_metaDatas['_line_total']);
	$exploded_fee_line_tax = explode(',', $Fee_metaDatas['_line_tax']);
	$exploded_fee_line_tax_data = explode('|', $Fee_metaDatas['_line_tax_data']);
	$exploded_fee_tax_class = explode(',', $Fee_metaDatas['_tax_class']);
	if(isset($exploded_fee_item)){
		foreach($exploded_fee_items as $feeitem) {
		       if ( ! $order_id )
			       return false;
		       $feeitem = trim($feeitem);
		       $item = array(
			       'order_item_name'     => $feeitem,
			       'order_item_type'     => 'fee',
			       );
		       #  $item = wp_parse_args( $item, $defaults );
		       $wpdb->insert( $wpdb->prefix . "woocommerce_order_items",
			       array(
				       'order_item_name'     => $item['order_item_name'],
				       'order_item_type'     => $item['order_item_type'],
				       'order_id'        => $order_id
				    ),
			       array(
				       '%s', '%s', '%d'
				    )
			       );
		       $item_id = absint( $wpdb->insert_id );
		       if($mode == 'insert'){
			       woocommerce_add_order_item_meta( $item_id, '_line_subtotal', $exploded_fee_line_subtotal[$fee_count]);
			       woocommerce_add_order_item_meta( $item_id, '_line_subtotal_tax', $exploded_fee_line_subtotal_tax[$fee_count]);
			       woocommerce_add_order_item_meta( $item_id, '_line_total', $exploded_fee_line_total[$fee_count]);
			       woocommerce_add_order_item_meta( $item_id, '_line_tax', $exploded_fee_line_tax[$fee_count]);
			       if(isset($exploded_fee_line_tax_data[$fee_count])) {
				       $unserialized_tax_data = unserialize($exploded_fee_line_tax_data[$fee_count]);
				       woocommerce_add_order_item_meta( $item_id, '_line_tax_data', $unserialized_tax_data);
			       }
			       woocommerce_add_order_item_meta( $item_id, '_tax_class', $exploded_fee_tax_class[$fee_count]);	
		       }
		       if($mode == 'update' || $mode == 'freshupdate'){
				woocommerce_update_order_item_meta($item_id, '_line_subtotal', $exploded_fee_line_subtotal[$fee_count]);
				woocommerce_update_order_item_meta($item_id, '_line_subtotal_tax', $exploded_fee_line_subtotal_tax[$fee_count]);
				woocommerce_update_order_item_meta($item_id, '_line_total', $exploded_fee_line_total[$fee_count]);
				woocommerce_update_order_item_meta($item_id, '_line_tax', $exploded_fee_line_tax[$fee_count]);
				if(isset($exploded_fee_line_tax_data[$fee_count])) {
				       $unserialized_tax_data = unserialize($exploded_fee_line_tax_data[$fee_count]);
					woocommerce_update_order_item_meta($item_id, '_line_tax_data', $unserialized_tax_data);
				}
				woocommerce_update_order_item_meta( $item_id, '_tax_class', $exploded_fee_tax_class[$fee_count]);
		       }
		       $fee_count++;
		}
	}
	       // WooCommerce Fee details import ends here
// WooCommerce Shipment details import starts here
	$exploded_shipment_items = explode(',', $Shipment_metaDatas['order_item_name']);
	$shipment_count = 0;
	$exploded_shipment_method_id = explode(',', $Shipment_metaDatas['method_id']);
	$exploded_shipment_cost = explode(',', $Shipment_metaDatas['cost']);
	$exploded_shipment_taxes = explode(',', $Shipment_metaDatas['taxes']);
	if(isset($exploded_shipment_items)){
		foreach($exploded_shipment_items as $shipmentitem) {
		       if ( ! $order_id )
			       return false;

		       $shipmentitem = trim($shipmentitem);
		       $item = array(
			       'order_item_name'     => $shipmentitem,
			       'order_item_type'     => 'shipping',
			       );
		       #  $item = wp_parse_args( $item, $defaults );
		       $wpdb->insert( $wpdb->prefix . "woocommerce_order_items",
			       array(
				       'order_item_name'     => $item['order_item_name'],
				       'order_item_type'     => $item['order_item_type'],
				       'order_id'        => $order_id
				    ),
			       array(
				       '%s', '%s', '%d'
				    )
			       );
		       $item_id = absint( $wpdb->insert_id );
		       if($mode == 'insert'){
			       woocommerce_add_order_item_meta( $item_id, 'method_id', $exploded_shipment_method_id[$shipment_count]);
			       woocommerce_add_order_item_meta( $item_id, 'cost', $exploded_shipment_cost[$shipment_count]);
			       if(isset($exploded_shipment_taxes[$shipment_count])) {
				       $unserialized_tax_data = @unserialize($exploded_shipment_taxes[$shipment_count]);
				       woocommerce_add_order_item_meta( $item_id, 'taxes', $unserialized_tax_data);
			       }
		       }
		       if($mode == 'update' || $mode == 'freshupdate'){
				woocommerce_update_order_item_meta($item_id, 'method_id', $exploded_shipment_method_id[$shipment_count]);
				woocommerce_update_order_item_meta($item_id, 'cost', $exploded_shipment_cost[$shipment_count]);
				if(isset($exploded_shipment_taxes[$shipment_count])) {
				       $unserialized_tax_data = unserialize($exploded_shipment_taxes[$shipment_count]);
				       woocommerce_update_order_item_meta( $item_id, 'taxes', $unserialized_tax_data);
				}
		       }
		       $shipment_count++;
		}
	 }
  }

}
