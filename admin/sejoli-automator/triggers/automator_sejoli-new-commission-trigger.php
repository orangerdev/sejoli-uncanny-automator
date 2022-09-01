<?php

use Uncanny_Automator\Recipe;

/**
 * Class Automator_Sejoli_New_Commission_Trigger
 *
 * @package Uncanny_Automator
 */
class Automator_Sejoli_New_Commission_Trigger {

	/**
	 * Integration code
	 *
	 * @var string
	 */
	public static $integration = 'SEJOLI';

	private $trigger_code;
	private $trigger_meta;

	/**
	 * Set up Automator trigger constructor.
	 */
	public function __construct() {

		$this->trigger_code = 'SEJOLI_NEW_COMMISSION';
		$this->trigger_meta = 'SEJOLI_CREATE_COMMISSION';

		$this->define_trigger();

	}

	/**
	 * Define and register the trigger by pushing it into the Automator object
	 */
	public function define_trigger() {

		$trigger = array(
			'author'              => Automator()->get_author_name( $this->trigger_code ),
			'integration'         => self::$integration,
			'code'                => $this->trigger_code,
			'sentence'            => sprintf( esc_attr__( 'If there is a new commission', 'sejoli-uncanny-automator' ) ),
			'select_option_name'  => esc_attr__( 'If there is a new commission', 'sejoli-uncanny-automator' ),
			'action'              => 'sejoli/order/new',
			'priority'            => 999,
			'accepted_args'       => 2,
			'validation_function' => array( $this, 'validate_trigger' ),
			'options_callback'    => '',
		);

		Automator()->register->trigger( $trigger );

	}

	/**
	 * Validate Trigger
	 * @return bool
	 */
	public function validate_trigger( $order_data ) : bool {

		$order_id     = $order_data['ID'];
		$user_id      = $order_data['user_id'];
		$affiliate_id = intval( $order_data['affiliate_id'] );

	    if ( empty( $order_data ) && empty( $order_id ) ) {

			return false;

		} else {

			if ( 0 === $affiliate_id ) {

				return false;

			} else {

				$pass_args = array(
					'code'     => $this->trigger_code,
					'meta'     => $this->trigger_meta,
					'order_id' => $order_id,
					'user_id'  => $user_id,
				);

				$args = Automator()->maybe_add_trigger_entry( $pass_args, false );

				if ( $args ) {

					foreach ( $args as $result ) {

						if ( true === $result['result'] ) {
							
							$trigger_meta = array(
								'user_id'        => (int) $user_id,
								'trigger_id'     => $result['args']['trigger_id'],
								'trigger_log_id' => $result['args']['get_trigger_id'],
								'run_number'     => $result['args']['run_number'],
							);

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_INVOICENUMBER';
							$trigger_meta['meta_value'] = $order_data['ID'];
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_QUANTITY';
							$trigger_meta['meta_value'] = $order_data['quantity'];
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_BUYERNAME';
							$trigger_meta['meta_value'] = $order_data['user_name'];
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_BUYEREMAIL';
							$trigger_meta['meta_value'] = $order_data['user_email'];
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_BUYERPHONE';
							$trigger_meta['meta_value'] = $order_data['user']->data->meta->phone;
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_BUYERADDRESS';
							$trigger_meta['meta_value'] = $order_data['user']->data->meta->address;
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_AFFILIATENAME';
							$trigger_meta['meta_value'] = $order_data['affiliate_name'];
							Automator()->insert_trigger_meta( $trigger_meta );

							if( isset($order_data['affiliate']) ){

								$trigger_meta['meta_key']   = 'SEJOLITOKEN_AFFILIATEEMAIL';
								$trigger_meta['meta_value'] = $order_data['affiliate']->data->user_email;
								Automator()->insert_trigger_meta( $trigger_meta );

								$trigger_meta['meta_key']   = 'SEJOLITOKEN_AFFILIATEPHONE';
								$trigger_meta['meta_value'] = $order_data['affiliate']->data->meta->phone;
								Automator()->insert_trigger_meta( $trigger_meta );

							}

							$get_affiliate_tier = array_column($order_data['product']->affiliate, 'fee', 'tier');
							$affiliate_tier = implode('', array_map(
							    function ($v, $k) { 
							    	return sprintf("Tier (%s) = %s \n", $k, sejolisa_price_format($v)); 
							    },
							    $get_affiliate_tier,
							    array_keys($get_affiliate_tier)
							));
							
							$trigger_meta['meta_key']   = 'SEJOLITOKEN_AFFILIATETIER';
							$trigger_meta['meta_value'] = $affiliate_tier;
							Automator()->insert_trigger_meta( $trigger_meta );

							$get_commission = sejolisa_get_commissions([
								'order_id'	=> $order_data['ID']
							]);

							$affiliate_commission = implode('', array_map(
								function ($entry) {
									return sprintf("Tier (%s) = %s, Komisi = %s \n", $entry->tier, $entry->affiliate_name, sejolisa_price_format($entry->commission)); 
								}, 
								$get_commission['commissions'],
								array_keys($get_commission['commissions'])
							));

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_AFFILIATECOMMISSION';
							$trigger_meta['meta_value'] = $affiliate_commission;
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_ORDERDATE';
							$trigger_meta['meta_value'] = $order_data['created_at'];
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_ORDERSTATUS';
							$trigger_meta['meta_value'] = $order_data['status'];
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_COUPONCODE';
							$trigger_meta['meta_value'] = $order_data['coupon_code'];
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_PAYMENTGATEWAY';
							$trigger_meta['meta_value'] = $order_data['payment_info']['bank'] .'-'. $order_data['payment_info']['owner'] .'-'. $order_data['payment_info']['account_number'];
							Automator()->insert_trigger_meta( $trigger_meta );

							if( isset( $order_data['courier'] ) ) {

								$trigger_meta['meta_key']   = 'SEJOLITOKEN_SHIPPINGMETHOD';
								$trigger_meta['meta_value'] = $order_data['courier'];
								Automator()->insert_trigger_meta( $trigger_meta );

							}

							if( isset( $order_data['meta_data']['variants']['0']['label'] ) ) {

								$trigger_meta['meta_key']   = 'SEJOLITOKEN_PRODUCTVARIANT';
								$trigger_meta['meta_value'] = $order_data['meta_data']['variants']['0']['label'];
								Automator()->insert_trigger_meta( $trigger_meta );

							}

							if( $order_data['status'] === 'shipping' ) {

								if( isset( $order_data['meta_data']['shipping_data']['resi_number'] ) ) {

									$trigger_meta['meta_key']   = 'SEJOLITOKEN_NUMBERRESI';
									$trigger_meta['meta_value'] = $order_data['meta_data']['shipping_data']['resi_number'];
									Automator()->insert_trigger_meta( $trigger_meta );

								}

							}

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_ORDERID';
							$trigger_meta['meta_value'] = $order_data['ID'];
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_PRODUCTNAME';
							$trigger_meta['meta_value'] = $order_data['product']->post_title;
							Automator()->insert_trigger_meta( $trigger_meta );

							$trigger_meta['meta_key']   = 'SEJOLITOKEN_ORDERGRANDTOTAL';
							$trigger_meta['meta_value'] = sejolisa_price_format($order_data['grand_total']);
							Automator()->insert_trigger_meta( $trigger_meta );

							global $wpdb;

							$subscription_expired = $wpdb->get_results( "
							    SELECT end_date 
							    FROM {$wpdb->prefix}sejolisa_subscriptions
							    WHERE order_id = '".$order_data['ID']."'
							", ARRAY_A );

						    if( !empty( $subscription_expired ) ) {
							    
							    $trigger_meta['meta_key']   = 'SEJOLITOKEN_SUBSCRIPTIONEXPIRE';
								$trigger_meta['meta_value'] = $subscription_expired[0]['end_date'];
								Automator()->insert_trigger_meta( $trigger_meta );

						    }

							$get_license = sejolisa_get_license_by_order($order_id);
							
						    if( false !== $get_license['valid'] ) {

						    	$trigger_meta['meta_key']   = 'SEJOLITOKEN_LICENCE';
								$trigger_meta['meta_value'] = $get_license['licenses']['code'];
								Automator()->insert_trigger_meta( $trigger_meta );

						    }

							Automator()->maybe_trigger_complete( $result['args'] );

						}

					}

				}

				return true;

			}

		}

	}

	/**
	 * Set Order ID
	 * @param mixed $args
	 */
	protected function prepare_to_run( $order_data ) {

		// Set Order ID
		$order_id = absint( $order_data['ID'] );
		$this->set_ignore_post_id( $order_id );

	}

}
