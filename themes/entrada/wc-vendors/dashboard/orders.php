<script type="text/javascript">
	jQuery(function() {
		jQuery('a.view-items').on('click', function(e) {
			e.preventDefault();
			var id = jQuery(this).closest('tr').data('order-id');

			if (jQuery(this).text() == "<?php _e('Hide items',  'entrada'); ?>") {
				jQuery(this).text("<?php _e('View items',  'entrada'); ?>");
			} else {
				jQuery(this).text("<?php _e('Hide items',  'entrada'); ?>");
			}

			jQuery("#view-items-" + id).fadeToggle();
		});

		jQuery('a.view-order-tracking').on('click', function(e) {
			e.preventDefault();
			var id = jQuery(this).closest('tr').data('order-id');
			jQuery("#view-tracking-" + id).fadeToggle();
		});
	});
</script>

<h2><?php _e('Orders', 'entrada'); ?></h2>

<?php global $woocommerce; ?>

<?php if (function_exists('wc_print_notices')) {
	wc_print_notices();
} ?>
<div class="table-responsive">

	<table class="table table-condensed table-vendor-sales-report">
		<thead>
			<tr>
				<th class="product-header"><?php _e('Order', 'entrada'); ?></th>
				<th class="quantity-header"><?php _e('Shipping', 'entrada') ?></th>
				<th class="commission-header"><?php _e('Total', 'entrada') ?></th>
				<th class="rate-header"><?php _e('Date', 'entrada') ?></th>
				<th class="rate-header"><?php _e('Links', 'entrada') ?></th>
		</thead>
		<tbody>

			<?php if (!empty($order_summary)) : $totals = 0;
				$user_id = get_current_user_id();
				?>

				<?php foreach ($order_summary as $order) :

						$order = new WC_Order($order->order_id);
						$valid_items = WCV_Queries::get_products_for_order($order->id);
						$valid = array();
						$needs_shipping = false;

						$items = $order->get_items();

						foreach ($items as $key => $value) {
							if (in_array($value['variation_id'], $valid_items) || in_array($value['product_id'], $valid_items)) {
								$valid[] = $value;
							}
							// See if product needs shipping
							$product = new WC_Product($value['product_id']);
							$needs_shipping = (!$product->needs_shipping() || $product->is_downloadable('yes')) ? false : true;
						}

						$shippers = (array) get_post_meta($order->id, 'wc_pv_shipped', true);
						$shipped = in_array($user_id, $shippers);

						?>

					<tr id="order-<?php echo esc_attr($order->id); ?>" data-order-id="<?php echo esc_attr($order->id); ?>">
						<td><?php echo sprintf(__('%s', 'entrada'), $order->get_order_number()); ?></td>
						<td><?php echo apply_filters('wcvendors_dashboard_google_maps_link', '<a target="_blank" href="' . esc_url('http://maps.google.com/maps?&q=' . urlencode(esc_html(preg_replace('#<br\s*/?>#i', ', ', $order->get_formatted_shipping_address()))) . '&z=16') . '">' . esc_html(preg_replace('#<br\s*/?>#i', ', ', $order->get_formatted_shipping_address())) . '</a>'); ?></td>
						<td><?php $sum = WCV_Queries::sum_for_orders(array($order->id), array('vendor_id' => get_current_user_id()));
									$total = $sum[0]->line_total;
									$totals += $total;
									echo woocommerce_price($total); ?></td>
						<td><?php echo sprintf(__('%s', 'entrada'), $order->order_date); ?></td>
						<td>
							<?php
									$order_actions = array(
										'view'		=> array(
											'class' 	=> 'view-items',
											'content'	=> __('View items', 'entrada'),
										)
									);
									if ($needs_shipping) {
										$order_actions['shipped'] = array(
											'class' 	=> 'mark-shipped',
											'content'	=> __('Mark shipped', 'entrada'),
											'url'		=> '?wc_pv_mark_shipped=' . $order->id
										);
									}
									if ($shipped) {
										$order_actions['shipped'] = array(
											'class' 	=> 'mark-shipped',
											'content'	=> __('Shipped', 'entrada'),
											'url'		=> '#'
										);
									}

									if ($providers && $needs_shipping && class_exists('WC_Shipment_Tracking')) {
										$order_actions['tracking'] = array(
											'class'		=> 'view-order-tracking',
											'content'	=> __('Tracking', 'entrada')
										);
									}

									$order_actions = apply_filters('wcvendors_order_actions', $order_actions, $order);

									if ($order_actions) {
										$output = array();
										foreach ($order_actions as $key => $data) {
											$output[] = sprintf(
												'<a href="%s" id="%s" class="%s">%s</a>',
												(isset($data['url'])) ? $data['url'] : '#',
												(isset($data['id'])) ? $data['id'] : $key . '-' . $order->id,
												(isset($data['class'])) ? $data['class'] : '',
												$data['content']
											);
										}
										echo implode(' | ', $output);
									}
									?>
						</td>
					</tr>

					<tr id="view-items-<?php echo esc_attr($order->id); ?>" style="display:none;">
						<td colspan="5">
							<?php
									$product_id = '';
									foreach ($valid as $key => $item) :

										$product_id = !empty($item['variation_id']) ? $item['variation_id'] : $item['product_id'];

										$_product  = $order->get_product_from_item($item);

										$item_meta = new WC_Order_Item_Meta($item);
										$item_meta = $item_meta->display(false, true); ?>
								<?php


											echo sprintf(__('%s', 'entrada'), $item['qty']);
											echo 'x ';
											echo sprintf(__('%s', 'entrada'), $item['name']);

											?>

								<?php
											if ($metadata = $order->has_meta($item['product_id'])) {
												echo '<table cellspacing="1" class="wcv_display_meta">';
												foreach ($metadata as $meta) {

													// Skip hidden core fields
													if (in_array($meta['meta_key'], apply_filters('woocommerce_hidden_order_itemmeta', array(
														'_qty',
														'_tax_class',
														'_product_id',
														'_variation_id',
														'_line_subtotal',
														'_line_subtotal_tax',
														'_line_total',
														'_line_tax',
														WC_Vendors::$pv_options->get_option('sold_by_label'),
													)))) {
														continue;
													}

													// Skip serialised meta
													if (is_serialized($meta['meta_value'])) {
														continue;
													}

													// Get attribute data
													if (taxonomy_exists(wc_sanitize_taxonomy_name($meta['meta_key']))) {
														$term               = get_term_by('slug', $meta['meta_value'], wc_sanitize_taxonomy_name($meta['meta_key']));
														$meta['meta_key']   = wc_attribute_label(wc_sanitize_taxonomy_name($meta['meta_key']));
														$meta['meta_value'] = isset($term->name) ? $term->name : $meta['meta_value'];
													} else {
														$meta['meta_key']   = apply_filters('woocommerce_attribute_label', wc_attribute_label($meta['meta_key'], $_product), $meta['meta_key']);
													}

													echo '<tr><th>' . wp_kses_post(rawurldecode($meta['meta_key'])) . ':</th><td>' . wp_kses_post(wpautop(make_clickable(rawurldecode($meta['meta_value'])))) . '</td></tr>';
												}
												echo '</table>';
											}
											?>

								<br />

							<?php endforeach ?>

						</td>
					</tr>

					<?php if (class_exists('WC_Shipment_Tracking')) : ?>

						<?php if (is_array($providers)) : ?>
							<tr id="view-tracking-<?php echo esc_attr($order->id); ?>" style="display:none;">
								<td colspan="5">
									<div class="order-tracking">
										<?php
														wc_get_template('shipping-form.php', array(
															'order_id'       => $order->id,
															'product_id'     => $product_id,
															'providers'      => $providers,
														), 'wc-vendors/orders/shipping/', wcv_plugin_dir . 'templates/orders/shipping/');
														?>
									</div>

								</td>
							</tr>
						<?php endif; ?>

					<?php endif; ?>

				<?php endforeach; ?>

				<tr>
					<td><b>Total:</b></td>
					<td colspan="4"><?php echo woocommerce_price($totals); ?></td>
				</tr>

			<?php else : ?>

				<tr>
					<td colspan="4" style="text-align:center;"><?php _e('You have no orders during this period.', 'entrada'); ?></td>
				</tr>

			<?php endif; ?>

		</tbody>
	</table>

</div>