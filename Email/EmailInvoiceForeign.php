<?php
/**
 * Email template: foreign.
 *
 * @package WooCommerceWFirma
 */

/**
 * Register foreign email template.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class WooCommerceWFirmaEmailInvoiceForeign extends WooCommerceWFirmaBaseEmail {

	/**
	 * Constructor.
	 *
	 * @param string $plugin_path          Plugin path.
	 * @param string $plugin_template_path Plugin template path.
	 */
	public function __construct( $plugin_path, $plugin_template_path ) {
		$this->id             = 'woo_wfirma_faktura_zagraniczna';
		$this->title          = __( 'Faktura walutowa (wFirma)', 'woocommerce-wfirma' );
		$this->description    = __( 'Email z fakturą zagraniczną (wFirma).', 'woocommerce-wfirma' );
		$this->heading        = __( 'Faktura walutowa do zamówienia', 'woocommerce-wfirma' );
		$this->subject        = __( '[{site_title}] Faktura walutowa do zamówienia {order_number} - {order_date}', 'woocommerce-wfirma' );
		$this->template_html  = 'emails/faktura-walutowa.php';
		$this->template_plain = 'emails/plain/faktura-walutowa.php';

		parent::__construct( $plugin_path, $plugin_template_path );

	}


}
