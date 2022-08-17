<?php

/**
 * Checkout Functions
 */


	/**
	 * Check for any valid pricing discounts on page load, and save them to the session
	 */
	function gmt_pricing_parity_set_discount() {
		$discount = gmt_pricing_parity_get_discount();
		EDD()->session->set('pricing_parity', ((empty($discount)) ? null : $discount));
	}
	add_action( 'init', 'gmt_pricing_parity_set_discount' );


	/**
	 * If one exists, apply the location based discount to each item in the cart
	 * @param  Float   $price The price
	 * @return Float          The location-adjusted price
	 */
	function gmt_pricing_parity_adjust_item_price ($price) {
		$discount = EDD()->session->get( 'pricing_parity');
		if (empty($discount)) return $price;
		$price = floatval($price);
		return $price - ($price * (intval($discount['amount']) / 100));
	}
	add_filter( 'edd_cart_item_price', 'gmt_pricing_parity_adjust_item_price', 10 );
	add_filter( 'edd_recurring_signup_fee', 'gmt_pricing_parity_adjust_item_price', 8, 1 );


	/**
	 * Display the original price after each price-adjusted item in the cart
	 * @param  Array  $item The item details
	 * @return String       The message
	 */
	function gmt_pricing_parity_item_price_message($item) {

		// If there's no pricing parity discount, do nothing
		$discount = EDD()->session->get( 'pricing_parity');
		if (empty($discount)) return;

		// Get the pre-adusted and discounted prices
		$price = gmt_pricing_parity_get_item_preadjusted_price( $item['id'], $item['options'] );
		$discounted_price = edd_cart_item_price( $item['id'], $item['options'] );

		// If they don't match, display a message
		if ( edd_currency_filter( edd_format_amount( $price, true ) ) !== $discounted_price ) {
			echo '<div><em class="text-small text-muted">(' . edd_currency_filter( edd_format_amount( $price, false ) ) . ' before discount)</em></div>';
		}

	}
	add_action( 'edd_checkout_cart_item_price_after', 'gmt_pricing_parity_item_price_message' );


	/**
	 * Display a price-adjustment message above the cart
	 * @return String The message
	 */
	function gmt_pricing_parity_cart_message() {

		$cart_items = edd_get_cart_contents();
		if (empty($cart_items)) return;

		// If there's no pricing parity discount, do nothing
		$discount = EDD()->session->get( 'pricing_parity');
		if (empty($discount)) return;

		// Otherwise, display a discount message
		echo '<div class="clearfix pricing-parity-discount"><img width="100" style="float:left;margin: 0.5em 1em 1em 0;" src="https://flagpedia.net/data/flags/normal/' . $discount['code'] . '.png"><p><em>Hi! Looks like you\'re from <strong>' . $discount['country'] . '</strong>, where my products might be a bit expensive. <strong>A discount of ' . $discount['amount'] . '%</strong> has automatically been applied to the items in your cart. Cheers!</em></p></div>';

	}
	add_action( 'edd_cart_items_before', 'gmt_pricing_parity_cart_message' );


	/**
	 * Add pricing parity details to the payment
	 * @param  array $merged_data The payment meta data
	 * @param  array
	 */
	function gmt_pricing_parity_add_details_to_payment($merged_data) {

		// Check for a discount
		$discount = EDD()->session->get( 'pricing_parity');

		// Add discount to data
		if (!empty($discount)) {
			$merged_data['pricing_parity'] = $discount;
		}

		return $merged_data;

	}
	add_filter( 'edd_payment_meta', 'gmt_pricing_parity_add_details_to_payment' );