<?php
/**
 * Email z fakturą proforma (plain text)
 *
 * @author		StudioWP
 * @package		WooiFirma
 * @version		1.0.0
 */
/**
 * @var $order WC_Order
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo $email_heading . "\n\n";

echo "****************************************************\n\n";

printf( __( "W załączniku przesyłamy fakturę proforma do zamówienia %s.", 'woocommerce-wfirma' ) , $order->get_order_number() ) . "\n\n";

if ( isset( $download_url ) ) {
	printf( __( 'Faktura do zamówienia: %s', 'woocommerce-wfirma' ), $download_url ) . "\n\n";
}

echo __( 'Order #', 'woocommerce' ) . $order->get_order_number() . ' ' ;
printf( date_i18n( wc_date_format(), strtotime( $order->get_date_created() ) ) );

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

echo "\n";

switch ( $order->get_status() ) {
    case "completed" :
        if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
            echo $order->email_order_items_table( array( 'plain_text'    => true ) );
        }
        else {
            echo wc_get_email_order_items( $order, array( 'plain_text'    => true ) );
        }
        break;
    case "processing" :
        if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
            echo $order->email_order_items_table( array( 'plain_text'    => true ) );
        }
        else {
            echo wc_get_email_order_items( $order, array( 'plain_text'    => true ) );
        }
        break;
    default :
        if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
            echo $order->email_order_items_table( array( 'plain_text'    => true ) );
        }
        else {
            echo wc_get_email_order_items( $order, array( 'plain_text'    => true ) );
        }
        break;
}

echo "----------\n\n";

if ( $totals = $order->get_order_item_totals() ) {
	foreach ( $totals as $total ) {
		echo $total['label'] . "\t " . $total['value'] . "\n";
	}
}

echo "\n****************************************************\n\n";

do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email );

echo __( 'Your details', 'woocommerce' ) . "\n\n";

if ( $order->get_billing_email() )
	echo __( 'Email:', 'woocommerce' ); echo $order->get_billing_email() . "\n";

if ( $order->get_billing_phone() )
	echo __( 'Tel:', 'woocommerce' ); ?> <?php echo $order->get_billing_phone() . "\n";

wc_get_template( 'emails/plain/email-addresses.php', array( 'order' => $order ) );

echo "\n****************************************************\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
