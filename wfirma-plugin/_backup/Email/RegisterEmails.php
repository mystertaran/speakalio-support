<?php
/**
 * Email: Register email templates.
 *
 * WooCommerce only accept classes without namespaces.
 *
 * @package WooCommerceWFirma
 */

use WPDesk\WooCommerceWFirma\Plugin;

/**
 * Register email templates and pass them to the WooCommerce filter.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class WooCommerceWFirmaRegisterEmails implements WFirmaVendor\WPDesk\PluginBuilder\Plugin\Hookable {

	/**
	 * Plugin.
	 *
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * WooCommerceWFirmaRegisterEmails constructor.
	 *
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Hooks
	 */
	public function hooks() {
		add_filter( 'woocommerce_email_classes', [ $this, 'register_emails' ], 11 );
	}

	/**
	 * Register emails in WooCommerce.
	 *
	 * @param array $emails Emails.
	 *
	 * @return array
	 */
	public function register_emails( array $emails ) {
		$emails[ \WooCommerceWFirmaEmailInvoice::class ]         = new \WooCommerceWFirmaEmailInvoice( $this->plugin->get_plugin_path(), $this->plugin->get_template_path() );
		$emails[ \WooCommerceWFirmaEmailInvoiceForeign::class ]  = new \WooCommerceWFirmaEmailInvoiceForeign( $this->plugin->get_plugin_path(), $this->plugin->get_template_path() );
		$emails[ \WooCommerceWFirmaEmailInvoiceProForma::class ] = new \WooCommerceWFirmaEmailInvoiceProForma( $this->plugin->get_plugin_path(), $this->plugin->get_template_path() );
		$emails[ \WooCommerceWFirmaEmailBill::class ]            = new \WooCommerceWFirmaEmailBill( $this->plugin->get_plugin_path(), $this->plugin->get_template_path() );
		$emails[ \WooCommerceWFirmaEmailBillForeign::class ]     = new \WooCommerceWFirmaEmailBillForeign( $this->plugin->get_plugin_path(), $this->plugin->get_template_path() );
		$emails[ \WooCommerceWFirmaEmailReceipt::class ]         = new \WooCommerceWFirmaEmailReceipt( $this->plugin->get_plugin_path(), $this->plugin->get_template_path() );

		return $emails;
	}

}
