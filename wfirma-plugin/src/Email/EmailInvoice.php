<?php
/**
 * Email: invoice.
 *
 * @package WooCommerceWFirma
 */

/**
 * Register invoice template email.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class WooCommerceWFirmaEmailInvoice extends WooCommerceWFirmaBaseEmail {

	/**
	 * WooCommerceWFirmaEmailInvoice constructor.
	 *
	 * @param string $plugin_path          Plugin path.
	 * @param string $plugin_template_path Plugin template path.
	 */
	public function __construct( $plugin_path, $plugin_template_path ) {

		$this->id             = 'woo_wfirma_faktura';
		$this->title          = __( 'Faktura (wFirma)', 'woocommerce-wfirma' );
		$this->description    = __( 'Email z fakturą (wFirma).', 'woocommerce-wfirma' );
		$this->heading        = __( 'Invoice for order', 'woocommerce-wfirma' );
		$this->subject        = __( '[{site_title}] Invoice for order {order_number} - {order_date}', 'woocommerce-wfirma' );
		$this->template_html  = 'emails/faktura.php';
		$this->template_plain = 'emails/plain/faktura.php';

		parent::__construct( $plugin_path, $plugin_template_path );

	}


}
