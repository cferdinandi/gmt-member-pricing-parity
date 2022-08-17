<?php

	/**
	 * Add settings section
	 * @param array $sections The current sections
	 */
	function gmt_pricing_parity_settings_section ( $sections ) {
		$sections['gmt_pricing_parity'] = __( 'GMT Pricing Parity', 'gmt_pricing_parity' );
		return $sections;
	}
	add_filter( 'edd_settings_sections_extensions', 'gmt_pricing_parity_settings_section' );


	/**
	 * Add settings
	 * @param  array $settings The existing settings
	 */
	function gmt_pricing_parity_settings( $settings ) {

		$custom_settings = array(

			// API endpoint
			array(
				'id'      => 'gmt_pricing_parity_api',
				'name'    => __( 'API Endpoint', 'gmt_pricing_parity' ),
				'desc'    => __( 'Endpoint for the pricing parity API', 'gmt_pricing_parity' ),
				'type'    => 'text',
				'std'     => __( '', 'gmt_pricing_parity' ),
			),

		);

		if ( version_compare( EDD_VERSION, 2.5, '>=' ) ) {
			$custom_settings = array( 'gmt_pricing_parity' => $custom_settings );
		}

		return array_merge( $settings, $custom_settings );

	}
	add_filter( 'edd_settings_extensions', 'gmt_pricing_parity_settings', 999, 1 );