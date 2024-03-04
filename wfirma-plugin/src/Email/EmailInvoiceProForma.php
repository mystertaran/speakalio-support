<?php
/**
 * Email template: proforma.
 *
 * @package WooCommerceWFirma
 */

/**
 * Register proforma email template.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class WooCommerceWFirmaEmailInvoiceProForma extends WooCommerceWFirmaBaseEmail {

	/**
	 * WooCommerceWFirmaEmailInvoiceProForma constructor.
	 *
	 * @param string $plugin_path          Plugin path.
	 * @param string $plugin_template_path Plugin template path.
	 */
	public function __construct( $plugin_path, $plugin_template_path ) {

		$this->id             = 'woo_wfirma_faktura_proforma';
		$this->title          = __( 'Faktura Pro Forma (wFirma)', 'woocommerce-wfirma' );
		$this->description    = __( 'Email z fakturą pro forma.', 'woocommerce-wfirma' );
		$this->heading        = __( 'Proforma invoice for order', 'woocommerce-wfirma' );
		$this->subject        = __( '[{site_title}] Proforma invoice for order {order_number} - {order_date}', 'woocommerce-wfirma' );
		$this->template_html  = 'emails/faktura-proforma.php';
		$this->template_plain = 'emails/plain/faktura-proforma.php';

		parent::__construct( $plugin_path, $plugin_template_path );

	}


}
