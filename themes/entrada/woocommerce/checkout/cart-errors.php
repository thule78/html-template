<?php
/**
 * Cart errors page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<?php wc_print_notices(); ?>
<p><?php esc_html__( 'There are some issues with the items in your cart (shown above). Please go back to the cart page and resolve these issues before checking out.', 'entrada' ) ?></p>
<?php do_action( 'woocommerce_cart_has_errors' ); ?>
<p><a class="button wc-backward" href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>"><?php esc_html__( 'Return To Cart', 'entrada' ) ?></a></p>