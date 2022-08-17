<?php

/**
 * Helper Methods
 */


	/**
	 * Get the discount (if any) for the user's country
	 * @return Array                The discount details
	 */
	function gmt_pricing_parity_get_discount () {

		// Get the API endpoint
		$endpoint = edd_get_option('gmt_pricing_parity_api');
		if (empty($endpoint)) return;

		// Call the API
		$request = wp_remote_get('https://gomakethings.com/checkout/wp-json/gmt-pricing-parity/v1/discount/');
		$response = wp_remote_retrieve_body($request);
		$data = json_decode($response, true);

		// if (empty($data) || !array_key_exists('amount', $data)) return null;
		return empty($data['amount']) ? array() : $data;

	}


	/**
	 * Get an item's pre-adjusted price
	 * @param  Array $item    The item details
	 * @param  Array $options The options array
	 * @return Float          The pre-adjusted price
	 */
	function gmt_pricing_parity_get_item_preadjusted_price($item_id, $options) {

		$price = 0;
		$variable_prices = edd_has_variable_prices( $item_id );

		if ( $variable_prices ) {
			$prices = edd_get_variable_prices( $item_id );

			if ( $prices ) {
				if ( ! empty( $options ) ) {
					$price = isset( $prices[ $options['price_id'] ] ) ? $prices[ $options['price_id'] ]['amount'] : false;
				} else {
					$price = false;
				}
			}
		}

		if ( ! $variable_prices || false === $price ) {
			// Get the standard Download price if not using variable prices
			$price = edd_get_download_price( $item_id );
		}

		return $price;

	}