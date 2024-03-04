<?php
/**
 * Email: Autosend.
 *
 * @package WooCommerceWFirma
 */

use WPDesk\WooCommerceWFirma\Documents\DocumentType;
use WPDesk\WooCommerceWFirma\InvoicesIntegration;
use WFirmaVendor\WPDesk\Invoices\Metadata\MetadataContent;


/**
 * Send automatically email.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class WooCommerceWFirmaEmailAutoSend {

	/**
	 * Document type.
	 *
	 * @var DocumentType
	 */
	private $type;

	/**
	 * EmailAutoSend constructor.
	 *
	 * @param DocumentType $type Document type.
	 */
	public function __construct( $type ) {
		$this->type = $type;
	}


	/**
	 * Get emails.
	 *
	 * @return array
	 */
	private function get_emails() {
		return WC()->mailer()->get_emails();
	}

	/**
	 * Should send email?
	 *
	 * @param \WC_Order           $order       Order.
	 * @param InvoicesIntegration $integration Integration.
	 *
	 * @return bool
	 */
	private function should_send_email( \WC_Order $order, $integration ) {
		$send_email    = false;
		$document_type = strtolower( $this->type->getTypeName() );
		$metadata      = new MetadataContent( $this->type->getMetaDataName(), $order );

		if ( strpos( $document_type, 'invoice' ) !== false && $integration->woocommerce_integration->isAutoSendInvoice() ) {
			$send_email = true;
		} elseif ( strpos( $document_type, 'proforma' ) && $integration->woocommerce_integration->isAutoSendInvoiceProforma() ) {
			$send_email = ! $integration->isFiscalReceipt( $metadata );
		} elseif ( strpos( $document_type, 'receipt' ) && $integration->woocommerce_integration->isAutoSendReceipt() ) {
			$send_email = ! $integration->isFiscalReceipt( $metadata );
		} elseif ( strpos( $document_type, 'bill' ) !== false && $integration->woocommerce_integration->isAutoSendBill() ) {
			$send_email = true;
		}

		return $send_email;
	}

	/**
	 * Maybe send email after document create.
	 *
	 * @param WC_Order $order         Order.
	 * @param string   $download_hash Download hash string.
	 */
	public function maybe_send_email( $order, $download_hash ) {
		$integration = $this->type->getIntegration();
		if ( $this->should_send_email( $order, $integration ) ) {
			$email_class = $this->type->getEmailClass();
			$emails      = $this->get_emails();
			if ( ! empty( $emails ) && ! empty( $emails[ $email_class ] ) ) {
				$meta_data_name    = $this->type->getMetaDataName();
				$metadata_content  = new \WFirmaVendor\WPDesk\Invoices\Metadata\MetadataContent( $meta_data_name, $order );

				$document_pdf      = $integration->GetDocumentPdf( $metadata_content );

				$document_metadata = $this->type->prepareDocumentMetadata( $metadata_content );
				$number            = $document_metadata->getNumber();
				$file_name         = str_replace(
					[ ' ', '/' ],
					'_',
					sprintf( '%1$s_%2$s.pdf', $document_metadata->getTypeName(), $number )
				);

				$download_url = add_query_arg( [
					'order_id'         => $order->get_id(),
					'type'             => $this->type->getMetaDataName(),
					'invoice_download' => $download_hash
				], get_site_url() );

				$emails[ $email_class ]->trigger( $order, $document_pdf, $file_name, $download_url );
			}
		}
	}

}
