<?php
/**
 * Email template: bill.
 *
 * @package WooCommerceWFirma
 */

/**
 * Register bill template email.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class WooCommerceWFirmaEmailBill extends WooCommerceWFirmaBaseEmail {

	/**
	 * EmailBill WooCommerceWFirmaEmailBill.
	 *
	 * @param string $plugin_path          Plugin path.
	 * @param string $plugin_template_path Plugin template path.
	 */
	public function __construct( $plugin_path, $plugin_template_path ) {

		$this->id             = 'woo_wfirma_rachunek';
		$this->title          = __( 'Faktura bez VAT (wFirma)', 'woocommerce-wfirma' );
		$this->description    = __( 'Email z fakturą.', 'woocommerce-wfirma' );
		$this->heading        = __( 'Invoice for order', 'woocommerce-wfirma' );
		$this->subject        = __( '[{site_title}] Invoice for order {order_number} - {order_date}', 'woocommerce-wfirma' );
		$this->template_html  = 'emails/rachunek.php';
		$this->template_plain = 'emails/plain/rachunek.php';

		parent::__construct( $plugin_path, $plugin_template_path );

	}

}
