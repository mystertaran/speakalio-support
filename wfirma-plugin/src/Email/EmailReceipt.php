<?php
/**
 * Email template: receipt.
 *
 * @package WooCommerceWFirma
 */

/**
 * Register receipt email template.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class WooCommerceWFirmaEmailReceipt extends WooCommerceWFirmaBaseEmail {

	/**
	 * EmailBill WooCommerceWFirmaEmailReceipt.
	 *
	 * @param string $plugin_path          Plugin path.
	 * @param string $plugin_template_path Plugin template path.
	 */
	public function __construct( $plugin_path, $plugin_template_path ) {

		$this->id             = 'woo_wfirma_receipt';
		$this->title          = __( 'Paragon niefiskalny (wFirma)', 'woocommerce-wfirma' );
		$this->description    = __( 'Email z paragonem.', 'woocommerce-wfirma' );
		$this->heading        = __( 'Paragon do zamówienia', 'woocommerce-wfirma' );
		$this->subject        = __( '[{site_title}] Receipt for order {order_number} - {order_date}', 'woocommerce-wfirma' );
		$this->template_html  = 'emails/receipt.php';
		$this->template_plain = 'emails/plain/receipt.php';

		parent::__construct( $plugin_path, $plugin_template_path );

	}

}
