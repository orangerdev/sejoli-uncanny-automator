<?php

// namespace Uncanny_Automator;
use Uncanny_Automator\Recipe;

/**
 * Class Sejoli_Tokens
 *
 * @package Uncanny_Automator
 */
class Sejoli_Tokens {

	// use Recipe\Tokens;

	/**
	 * Integration code
	 *
	 * @var string
	 */
	public static $integration = 'SEJOLI';

	/**
	 * WP_Anon_Tokens constructor.
	 */
	public function __construct() {
		
		add_filter( 'automator_maybe_parse_token', array( $this, 'parse_sejoli_post_tokens' ), 20, 6 );
		add_filter( 'automator_maybe_trigger_sejoli_tokens', array( $this, 'sejoli_possible_tokens' ), 20, 2 );
	
	}

	/**
	 * Only load this integration and its triggers and actions if the related plugin is active
	 *
	 * @param $status
	 * @param $code
	 *
	 * @return bool
	 */
	public function plugin_active( $status, $code ) {

		if ( self::$integration === $code ) {

			$status = true;
		}

		return $status;
	
	}

	/**
	 * @param array $tokens
	 * @param array $args
	 *
	 * @return array
	 */
	public function sejoli_possible_tokens( $tokens = array(), $args = array() ) {
		
		if ( ! automator_do_identify_tokens() ) {
			return $tokens;
		}

		$trigger_integration = $args['integration'];
		$trigger_meta        = $args['meta'];

		$fields = array(
			array(
				'tokenId'         => 'SEJOLITOKEN_INVOICENUMBER',
				'tokenName'       => __( 'Nomor Invoice', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_ORDERID',
				'tokenName'       => __( 'ID Order', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_PRODUCTNAME',
				'tokenName'       => __( 'Nama Produk', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_PRODUCTVARIANT',
				'tokenName'       => __( 'Variasi Produk', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_QUANTITY',
				'tokenName'       => __( 'QTY', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_BUYERNAME',
				'tokenName'       => __( 'Nama Pembeli', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_BUYEREMAIL',
				'tokenName'       => __( 'Email Pembeli', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_BUYERPHONE',
				'tokenName'       => __( 'No. Telepon Pembeli', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_BUYERADDRESS',
				'tokenName'       => __( 'Alamat Pembeli', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_ORDERDATE',
				'tokenName'       => __( 'Tanggal Order', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_ORDERSTATUS',
				'tokenName'       => __( 'Status Order', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_ORDERGRANDTOTAL',
				'tokenName'       => __( 'Total Order', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_AFFILIATENAME',
				'tokenName'       => __( 'Nama Affiliasi', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_AFFILIATEEMAIL',
				'tokenName'       => __( 'Email Affiliasi', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_AFFILIATEPHONE',
				'tokenName'       => __( 'No. Telepon Affiliasi', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_AFFILIATETIER',
				'tokenName'       => __( 'Tier Affiliasi', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_AFFILIATECOMMISSION',
				'tokenName'       => __( 'Komisi Affiliasi', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_COUPONCODE',
				'tokenName'       => __( 'Kupon', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_PAYMENTGATEWAY',
				'tokenName'       => __( 'Metode Pembayaran', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_SHIPPINGMETHOD',
				'tokenName'       => __( 'Metode Pengiriman', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_NUMBERRESI',
				'tokenName'       => __( 'No. Resi', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_SUBSCRIPTIONEXPIRE',
				'tokenName'       => __( 'Waktu Berakhir Berlangganan', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
			array(
				'tokenId'         => 'SEJOLITOKEN_LICENCE',
				'tokenName'       => __( 'Lisensi', 'sejoli-uncanny-automator' ),
				'tokenType'       => 'text',
				'tokenIdentifier' => $trigger_meta,
			),
		);

		$tokens = array_merge( $tokens, $fields );

		return $tokens;
		
	}

	/**
	 * @param $value
	 * @param $pieces
	 * @param $recipe_id
	 * @param $trigger_data
	 *
	 * @param int $user_id
	 * @param $replace_args
	 *
	 * @return mixed
	 */
	public function parse_sejoli_post_tokens( $value, $pieces, $recipe_id, $trigger_data, $user_id = 0, $replace_args = array() ) {
	
		$tokens = array(
			'SEJOLITOKEN_WPTAXONOMIES',
			'SEJOLITOKEN_SPECIFICTAXONOMY',
			'SEJOLITOKEN_QUANTITY',
			'SEJOLITOKEN_BUYERNAME',
			'SEJOLITOKEN_ORDERID',
			'SEJOLITOKEN_PRODUCTNAME',
			'SEJOLITOKEN_PRODUCTVARIANT',
			'SEJOLITOKEN_INVOICENUMBER',
			'SEJOLITOKEN_BUYEREMAIL',
			'SEJOLITOKEN_BUYERPHONE',
			'SEJOLITOKEN_BUYERADDRESS',
			'SEJOLITOKEN_ORDERDATE',
			'SEJOLITOKEN_ORDERSTATUS',
			'SEJOLITOKEN_ORDERGRANDTOTAL',
			'SEJOLITOKEN_AFFILIATENAME',
			'SEJOLITOKEN_AFFILIATEEMAIL',
			'SEJOLITOKEN_AFFILIATEPHONE',
			'SEJOLITOKEN_AFFILIATETIER',
			'SEJOLITOKEN_AFFILIATECOMMISSION',
			'SEJOLITOKEN_COUPONCODE',
			'SEJOLITOKEN_PAYMENTGATEWAY',
			'SEJOLITOKEN_SHIPPINGMETHOD',
			'SEJOLITOKEN_NUMBERRESI',
			'SEJOLITOKEN_SUBSCRIPTIONEXPIRE',
			'SEJOLITOKEN_LICENCE',
		);
	
		if ( empty( $pieces ) ) {
			return $value;
		}
		if ( empty( $trigger_data ) ) {
			return $value;
		}
		if ( ! isset( $pieces[2] ) ) {
			return $value;
		}

		$token = (string) $pieces[2];
		if ( empty( $token ) ) {
			return $value;
		}

		if ( ! in_array( $token, $tokens, false ) ) {
			return $value;
		}

		foreach ( $trigger_data as $trigger ) {

			$trigger_id     = absint( $trigger['ID'] );
			$trigger_log_id = absint( $replace_args['trigger_log_id'] );
			$run_number     = absint( $replace_args['run_number'] );
			$parse_tokens   = array(
				'trigger_id'     => $trigger_id,
				'trigger_log_id' => $trigger_log_id,
				'user_id'        => $user_id,
				'run_number'     => $run_number,
			);

			$entry = '';
			switch ( $token ) {
				case 'SEJOLITOKEN_WPTAXONOMIES':
					$value    = $trigger['meta']['SEJOLITOKEN_WPTAXONOMIES_readable'];
					$meta_key = join( ':', $pieces );
					$entry    = Automator()->db->trigger->get_token_meta( $meta_key, $parse_tokens );
					break;
				case 'SEJOLITOKEN_SPECIFICTAXONOMY':
					$value = $trigger['meta']['SEJOLITOKEN_SPECIFICTAXONOMY_readable'];
					break;
				default:
					global $wpdb;
					$entry = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->prefix}uap_trigger_log_meta WHERE meta_key LIKE %s AND automator_trigger_id = %d ORDER BY ID DESC LIMIT 0,1", "%%$token", $trigger_id ) );
					break;
			}

			if ( ! empty( $entry ) && is_array( $entry ) ) {
				$value = join( ', ', $entry );
			} elseif ( ! empty( $entry ) ) {
				$value = $entry;
			}

		}

		return $value;
	
	}

}
