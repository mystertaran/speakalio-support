<?php
/**
 * Email z rachunkiem
 *
 * @author 		StudioWP
 * @package 	WooiFirma
 * @version   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<b><?php printf( __('Please find attached an invoice for your order %s.', 'woocommerce-wfirma'), $order->get_order_number() ); ?></b><br/><br/>
<?php
if( isset( $download_url ) ) {
	printf( __('Bill for order: <a href=\"%s\"><b>Download PDF.</b></a>', 'woocommerce-wfirma'), $download_url );
	echo '<br/><br/>';
} ?>
<h2><?php echo __( 'Order #', 'woocommerce' ) . $order->get_order_number(); ?> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->get_date_created() ) ), date_i18n( wc_date_format(), strtotime( $order->get_date_created() ) ) ); ?>)</h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<thead>
		<tr>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			switch ( $order->get_status() ) {
				case "completed" :
                    if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
                        echo $order->email_order_items_table(array());
                    }
                    else {
                        echo wc_get_email_order_items( $order);
                    }
				break;
				case "processing" :
                    if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
                        echo $order->email_order_items_table(array());
                    }
                    else {
                        echo wc_get_email_order_items( $order);
                    }
				break;
				default :
                    if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
                        echo $order->email_order_items_table(array());
                    }
                    else {
                        echo wc_get_email_order_items( $order);
                    }
				break;
			}
		?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
						<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['value']; ?></td>
					</tr><?php
				}
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email ) ?>

<h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2>

<?php if ( $order->get_billing_email() ) : ?>
	<p><strong><?php _e( 'Email:', 'woocommerce' ); ?></strong> <?php echo $order->get_billing_email(); ?></p>
<?php endif; ?>
<?php if ( $order->get_billing_phone() ) : ?>
	<p><strong><?php _e( 'Tel:', 'woocommerce' ); ?></strong> <?php echo $order->get_billing_phone(); ?></p>
<?php endif; ?>

<?php wc_get_template( 'emails/email-addresses.php', array( 'order' => $order ) ); ?>

<?php do_action( 'woocommerce_email_footer' ); ?>
