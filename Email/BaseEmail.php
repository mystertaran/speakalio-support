<?php
/**
 * Email template: Base Template.
 *
 * @package WooCommerceWFirma
 */

use \WFirmaVendor\WPDesk\Invoices\Email\DocumentEmail;
use WPDesk\WooCommerceWFirma\Plugin;

/**
 * Register base template email.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class WooCommerceWFirmaBaseEmail extends DocumentEmail {

	/**
	 * Main plugin class instance.
	 *
	 * @var Plugin
	 */
	private $plugin;

	/**
	 * Email constructor.
	 *
	 * @param string $plugin_path          Plugin path.
	 * @param string $plugin_template_path Plugin template path.
	 */
	public function __construct( $plugin_path, $plugin_template_path ) {
		parent::__construct();
		$this->template_base  = untrailingslashit( $plugin_path ) . '/templates/';
		$this->customer_email = true;
		$this->manual         = true;

		$this->setTemplatePath( $plugin_template_path );
	}

	/**
	 * Trigger.
	 *
	 * @param \WC_Order $order        Order.
	 * @param string    $pdf_document PDF document content.
	 * @param string    $file_name    Attachement file name.
	 *
	 * @throws \Exception Exception.
	 */
	public function trigger( $order, $pdf_document = '', $file_name = '', $download_url = '' ) {
		try {
			$this->triggerEmail( $order, $pdf_document, $file_name, $download_url );
			$order->add_order_note(
				sprintf(
				// Translators: email title.
					__( 'wFirma - wysłano email: %1$s', 'woocommerce-wfirma' ),
					$this->get_subject()
				)
			);
		} catch ( \Exception $e ) {
			$order->add_order_note(
				sprintf(
				// Translators: type name and document number.
					__( 'wFirma - błąd przy wysyłania emaila: %1$s', 'woocommerce-wfirma' ),
					$this->get_subject()
				)
			);
			throw $e;
		}
	}


	/**
	 * @param \WC_Order $order        order.
	 * @param string    $pdfDocument  document.
	 * @param string    $fileName     filename.
	 * @param string    $download_url Download URL.
	 */
	public function triggerEmail( $order, $pdfDocument, $fileName, $download_url ) {
		if ( ! \is_object( $order ) ) {
			$order = new \WC_Order( \absint( $order ) );
		}
		if ( $order ) {
			$this->download_url                   = $download_url;
			$this->object                         = $order;
			$this->recipient                      = $order->get_billing_email();
			$this->placeholders['{order_date}']   = date_i18n( wc_date_format(), $order->get_date_created() ? $order->get_date_created()->getTimestamp() : strtotime( current_time( 'mysql' ) ) );
			$this->placeholders['{order_number}'] = $order->get_order_number();
		}
		if ( ! $this->get_recipient() ) {
			return;
		}

		if ( ! empty( $pdfDocument ) && ! empty( $fileName ) ) {
			$attachments = array(
				'pdf' => array(
					'fileName' => $fileName,
					'content'  => $pdfDocument,
				),
			);

			$stringAttachments = new \WFirmaVendor\WPDesk\Invoices\Email\StringAttachments( $attachments );
			$stringAttachments->addAction();
			$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), array() );
			$stringAttachments->removeAction();
		} else {
			$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), array() );
		}
	}

}
