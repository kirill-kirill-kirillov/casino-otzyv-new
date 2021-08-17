<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HW_Cmt_ImpExpCsv_AJAX_Handler {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_ajax_product_comments_csv_import_request', array( $this, 'csv_import_request' ) );
	}
	
	/**
	 * Ajax event for importing a CSV
	 */
	public function csv_import_request() {
		define( 'WP_LOAD_IMPORTERS', true );
                HW_Cmt_ImpExpCsv_Importer::product_importer();
	}

		
}

new HW_Cmt_ImpExpCsv_AJAX_Handler();